#!/bin/bash

print_hello_msg () {
  echo '____   ____                .___      __   ';
  echo '\   \ /   /____ _______  __| _/_____/  |_ ';
  echo ' \   Y   /\__  \\_  __ \/ __ |/  _ \   __\';
  echo '  \     /  / __ \|  | \/ /_/ (  <_> )  |  ';
  echo '   \___/  (____  /__|  \____ |\____/|__|  ';
  echo '               \/           \/            ';
}

print_readme () {
  echo 'We need README here.';
}

check_script () {
  CURRENT_DIRECTORY=${PWD##*/};
  if [[ $CURRENT_DIRECTORY != 'build' ]]
  then
    echo 'This script needs to be inside a build directory.';
    exit 1;
  fi
}

get_user_input() {
  echo -n "Project make file name: ";
  read PROJECT_NAME;

  # add make extension if not included in the project name.
  if [[ $PROJECT_NAME != *"make" ]]
  then
    PROJECT_NAME="$PROJECT_NAME.make";
  fi

  # check if the make file exists.
  if [[ ! -f $PROJECT_NAME ]]
  then
    echo 'Please check project make file name, this script can not find it.';
    exit 1;
  fi
}

update_varbase_make_file () {
  # Download the latest version from varbase make file.
  rm -f varbase.make;

  status=`curl -w "%{http_code}\\n" -L  -o varbase.make -O "http://cgit.drupalcode.org/varbase/plain/make.varbase?h=7.x-3.x"`;
  if [ $status != 200 ];
  then
    echo 'Varbase make script could not be installed, please check your bitbucket username and password.';
    rm -f varbase.make;
    exit 1;
  fi
}

rebuild_project_files () {
  CALLPATH=`dirname $0`;
  TEMPFILENAME="varbase_$$";

  if ! drush make --shallow-clone --concurrency=5 $CALLPATH/$PROJECT_NAME /tmp/$TEMPFILENAME;
  then
    echo "There is an error with make file couldn't build the project";
    exit 1;
  fi

  # remove files that we dont want to update or override.
  if [[ -f ../.gitignore ]]
  then
    rm -f /tmp/$TEMPFILENAME/.gitignore;
  fi
  if [[ -f ../.htaccess ]]
  then
    rm -f /tmp/$TEMPFILENAME/.htaccess;
  fi
  if [[ -f ../robots.txt ]]
  then
    rm -f /tmp/$TEMPFILENAME/robots.txt;
  fi

  # Remove files that will be updataed.
  rm -rf ../includes ../misc ../modules ../profiles ../scripts ../themes;
  find ../sites/*/modules/* -maxdepth 0 -type d ! -name 'custom' ! -name 'starter_kits' ! -name 'features' -exec rm -rf {} +;
  find ../sites/*/themes/* -maxdepth 0 -type d ! -name 'custom' -exec rm -rf {} +;
  rm -rf ../sites/*/libraries

  # move project files.
  cp -r /tmp/$TEMPFILENAME/. ../;

  # move starter kits to sites default if they dont exist
  if [[ ! -d ../sites/default/modules/starter_kits ]]
  then
    mkdir -p ../sites/default/modules
    cp -r ../profiles/varbase/modules/starter_kits ../sites/default/modules/starter_kits
    find ../sites/default/modules/starter_kits -name '*.starterkit' -exec sh -c 'mv "$0" "${0%.starterkit}.info"' {} \;
  fi

  rm -rf /tmp/$TEMPFILENAME;
}

main () {
  print_hello_msg;
  print_readme;
  check_script;
  get_user_input;
  update_varbase_make_file;
  rebuild_project_files;
}
main;
