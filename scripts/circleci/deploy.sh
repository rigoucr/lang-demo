#!/usr/bin/env bash
BRANCH=$1
MESSAGE=$2
REPO=$PANTHEON_GIT_REPO
CLONEFOLDER=`cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 12 | head -n 1`
git clone --branch $BRANCH $REPO $CLONEFOLDER || git clone $REPO $CLONEFOLDER
cd $CLONEFOLDER
git branch $BRANCH ; git checkout $BRANCH
shopt -s extglob
rm -rf ./!(.git|.|..)
cd ../
composer install --no-dev --ignore-platform-reqs

find ./web/modules/contrib/ -name ".git" -exec rm -rf {} \;
find ./web/themes/contrib/ -name ".git" -exec rm -rf {} \;
find ./web/libraries/ -name ".git" -exec rm -rf {} \;
find ./web/sites/all/libraries/ -name ".git" -exec rm -rf {} \;
find ./vendor/ -name ".git" -exec rm -rf {} \;
find ./web/profiles/contrib/ -name ".git" -exec rm -rf {} \;
find ./web/ -name ".git" -exec rm -rf {} \;
find ./web/core -name ".git" -exec rm -rf {} \;

if [ -f ./web/sites/default/settings.secret.php ]; then
  rm ./web/sites/default/settings.secret.php
fi
if [ -d ./web/sites/default/files ]; then
  rm -rf ./web/sites/default/files
fi
cp -r scripts web $CLONEFOLDER/
mv vendor $CLONEFOLDER/
cp ./{.drush-lock-update,composer.json,composer.lock,composer.patches.json,package.json,package-lock.json,pantheon.yml} $CLONEFOLDER/
cd $CLONEFOLDER
composer prepare-for-pantheon
git add --all .
git commit -m "$MESSAGE"
git push origin $BRANCH
cd ../
rm -rf $CLONEFOLDER
