#!/bin/bash

#set -o errexit -o nounset

rev=$(git rev-parse --short HEAD)

php vendor/bin/sami.php update sami.php
mkdir _site
cp -R api _site/
cd _site

git init
git config user.name "gossi"
git config user.email "github@gos.si"

echo "Add upstream:"
git remote add upstream "https://$GH_TOKEN@github.com/gossi/php-code-generator.git"
echo "Fetch upstream:"
git fetch upstream
echo "Reset to gh-pages:"
git reset upstream/gh-pages

touch .

echo "Add everything new:"
git add -A .
echo "Commit:"
git commit -m "rebuild pages at ${rev}"
echo "Push:"
git push upstream HEAD:gh-pages
