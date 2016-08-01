#!/usr/bin/env bash

# SQWEB - WORDPRESS.ORG RELEASE
# ------------------------------------------------------------------------------
# WordPress.org handles releases through svn. This script takes care of it.

DIR_DIST="./dist/sqweb-wordpress-plugin/"
DIR_DIST_SVN="../sqweb-wordpress-plugin-svn/sqweb"

# Grabbing the latest release version.
GIT_TAG=$(git describe --abbrev=0 --tags)
GIT_TAG_SHORT=$(git describe --abbrev=0 --tags | cut -d v -f 2)

# Creating a release and extracting it
gulp && unzip sqweb-wordpress-plugin.zip

# Cleaning up the trunk
rm -rf $DIR_DIST_SVN/trunk/* && svn delete trunk/*

# Copying the release to the trunk
cp -R $DIR_DIST $DIR_DIST_SVN/trunk

# Create a release tag in svn
mkdir $DIR_DIST_SVN/tags/$GIT_TAG_SHORT

# Copying the release to the svn tag
cp -R $DIR_DIST $DIR_DIST_SVN/tags/$GIT_TAG_SHORT

# Cleaning up the release sources
rm -rf ./dist/*

# Moving into the svn folder
cd ../sqweb-wordpress-plugin-svn/sqweb

# Checking out to svn
svn add tags/$GIT_TAG_SHORT && svn add trunk/*

# Pushing to SVN
svn ci -m "$GIT_TAG"
