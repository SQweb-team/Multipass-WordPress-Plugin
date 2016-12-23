#!/usr/bin/env bash

# Exit this script if a command fails.
set -e

# SQWEB - WORDPRESS.ORG RELEASE
# ------------------------------------------------------------------------------
# WordPress.org handles releases through svn. This script takes care of it.

DIR_DIST_SVN="../sqweb-wordpress-plugin-svn/sqweb"

# Grabbing the latest release version, without the leading "v".
GIT_TAG_SHORT=$(git describe --abbrev=0 --tags | cut -d v -f 2)

# Make sure that node dependencies are installed.
yarn install

echo "Create a release tag in svn..."
mkdir $DIR_DIST_SVN/tags/$GIT_TAG_SHORT

echo "Creating a release and extracting it..."
# Use bsdtar to remove the top parent directory when extracting. Unzip can't do that.
gulp && bsdtar -xf ./dist/sqweb-wordpress-plugin.zip -s'|[^/]*/||' -C $DIR_DIST_SVN/tags/$GIT_TAG_SHORT/

echo "Cleaning up the trunk..."
rm -rf $DIR_DIST_SVN/trunk/* && svn delete $DIR_DIST_SVN/trunk --force

echo "Copying the release to the trunk..."
cp -R $DIR_DIST_SVN/tags/$GIT_TAG_SHORT $DIR_DIST_SVN/trunk

echo "Cleaning up the release sources..."
rm -rf ./dist/*

echo "Moving into the svn folder..."
cd $DIR_DIST_SVN

# SVN voodoo to avoid "E170004: Item '/sqweb/trunk' is out of date"
svn update

echo "Checking out to svn..."
svn add tags/$GIT_TAG_SHORT && svn add trunk/* --parents

echo "Pushing to SVN..."
svn ci -m "v$GIT_TAG_SHORT"

# Letting the team know
curl -X POST --data-urlencode 'payload={"channel": "#sqw-dev-plug-wp", "text": "Version '$GIT_TAG_SHORT' has been pushed to WordPress.org"}' \
	https://hooks.slack.com/services/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

echo "Done!"
