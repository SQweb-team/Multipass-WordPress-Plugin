# SQweb - WordPress Plugin - Release Instructions

## Requirements

Provided that you have an authorized WordPress.org account with commit access:

- A copy of the SVN repo from wordpress.org (one level up from your Git clone).

	```shell
	mkdir sqweb-wordpress-plugin-svn
	cd sqweb-wordpress-plugin-svn
	svn co https://plugins.svn.wordpress.org/sqweb/
	```
	
- A clone of [SQweb-Coding-Style](https://github.com/SQweb-team/SQweb-Coding-Style) one level up from your working directory.

## 1. Checks

Make sure `readme.txt` includes up to date version, changelog and release notes information.

Then tag the latest commit with the target version, such as `v1.5.2`.

If this is the first time you release, attempt to prepare a release archive with `gulp`.

## 2. WordPress.org Release

Run `./release_wordpress.sh`.

If everything worked as expected, you should receive a confirmation email within a few minutes.

## 3. GitHub Release

Prepare a release archive with `gulp`. The resulting zip is found under `dist/`.

If you properly pushed your release tag during step 1, GitHub will see a new release.

1. Click on "**Edit**".
2. Name the release using the following form : "SQweb WordPress Plugin - v1.5.2".
3. Paste the contents of the `readme.txt` changelog in the release description area.
4. Attach `sqweb-wordpress-plugin.zip`.
5. Click "**Update Release**".
