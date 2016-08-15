#!/usr/bin/env bash

# SQWEB - WORDPRESS.ORG RELEASE
# ------------------------------------------------------------------------------
# WordPress.org handles releases through svn. This script takes care of it.

DIR_DIST="./dist/sqweb-wordpress-plugin/"
DIR_DIST_SVN="../sqweb-wordpress-plugin-svn/sqweb"

# Grabbing the latest release version.
GIT_TAG=$(git describe --abbrev=0 --tags)
GIT_TAG_SHORT=$(git describe --abbrev=0 --tags | cut -d v -f 2)

# Make sure that node dependencies are installed.
npm install

echo "Creating a release and extracting it..."
gulp && unzip ./dist/sqweb-wordpress-plugin.zip -d $DIR_DIST

echo "Cleaning up the trunk..."
rm -rf $DIR_DIST_SVN/trunk/* && svn delete $DIR_DIST_SVN/trunk

echo "Copying the release to the trunk..."
cp -R $DIR_DIST $DIR_DIST_SVN/trunk

echo "Create a release tag in svn..."
mkdir $DIR_DIST_SVN/tags/$GIT_TAG_SHORT

echo "Copying the release to the svn tag..."
cp -R $DIR_DIST $DIR_DIST_SVN/tags/$GIT_TAG_SHORT

echo "Cleaning up the release sources..."
rm -rf ./dist/*

echo "Moving into the svn folder..."
cd ../sqweb-wordpress-plugin-svn/sqweb

# Confirming we're in the proper directory
pwd

echo "Checking out to svn..."
svn add tags/$GIT_TAG_SHORT && svn add trunk/*

echo "Pushing to SVN..."
svn ci -m "$GIT_TAG"

echo "Done!"
