#!/usr/bin/env bash

# SQWEB - GITHUB RELEASE
# ------------------------------------------------------------------------------
# This script is called after a succesful deploy by Travis.
# It updates the latest release details on Github.com.

RELEASE_ID=$(curl -X "GET" "https://api.github.com/repos/SQweb-team/SQweb-WordPress-Plugin/releases/latest" -s | grep -E '"id":\s[0-9]+' -m 1 | grep -E "[0-9]+" -oh)

GIT_TAG=$(git describe --abbrev=0 --tags)
GIT_TAG_PREVIOUS=$(git describe --abbrev=0 --tags $GIT_TAG^)

# Update the release title

curl -X "PATCH" "https://api.github.com/repos/SQweb-team/SQweb-WordPress-Plugin/releases/"$RELEASE_ID \
    -H "Authorization: token $GITHUB_API_TOKEN" \
    -H "Content-Type: application/json; charset=utf-8" \
    -d "{\"name\":\"SQweb WordPress Plugin - $GIT_TAG\"}"

# TODO : update the release description
