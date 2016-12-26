#!/bin/bash

# Create new vartheme subtheme.

# Default theme name
theme_name="mytheme";

# Default themes creation path.
theme_path="docroot/themes/custom";

# Grape the theme name argument.
if [ "$1" != "" ]; then
  if [[ $1 =~ ^[A-Za-z][A-Za-z0-9_]*$ ]]; then
    theme_name=$1;
  else
    echo "Theme name is not a valid theme name.";
    exit 1;
  fi
else
  echo "Please add the name of your theme.";
  exit 1;
fi

# Grape the theme path argument.
if [ "$2" != "" ]; then
  if [[ $1 =~ ^[A-Za-z][A-Za-z0-9_-]*$ ]]; then
    if [[ ! -d "$2" ]]; then
      theme_path=$2;
      mkdir -p $theme_path;
    fi
  else
    echo "Theme path must be in the right format.";
    exit 1;
  fi
else
  if [[ ! -d "$theme_path" ]]; then
    mkdir -p $theme_path;
  fi
fi


# Create the new Vartheme subtheme if we do not have a folder with that name yet.
if [[ ! -d "$theme_path/$theme_name" ]]; then
  # 1. Copy the VARTHEME_SUBTHEME folder to your custom theme location.
  cp -r docroot/profiles/varbase/themes/vartheme/VARTHEME_SUBTHEME ${theme_path}/${theme_name} ;

  # 2. Rename VARTHEME_SUBTHEME.starterkit.yml your_subtheme_name.info.yml
  mv ${theme_path}/${theme_name}/VARTHEME_SUBTHEME.starterkit.yml ${theme_path}/${theme_name}/green.info.yml ;

  # 3. Rename VARTHEME_SUBTHEME.libraries.yml your_subtheme_name.libraries.yml
  mv ${theme_path}/${theme_name}/VARTHEME_SUBTHEME.libraries.yml ${theme_path}/${theme_name}/${theme_name}.libraries.yml ;

  # 4. Rename VARTHEME_SUBTHEME.theme your_subtheme_name.theme
  mv ${theme_path}/${theme_name}/VARTHEME_SUBTHEME.theme ${theme_path}/${theme_name}/${theme_name}.theme ;

  # 5. Rename VARTHEME_SUBTHEME.settings.yml
  mv ${theme_path}/${theme_name}/config/install/VARTHEME_SUBTHEME.settings.yml ${theme_path}/${theme_name}/config/install/${theme_name}.settings.yml ;

  # 5. Rename VARTHEME_SUBTHEME.schema.yml
  mv ${theme_path}/${theme_name}/config/schema/VARTHEME_SUBTHEME.schema.yml ${theme_path}/${theme_name}/config/schema/${theme_name}.schema.yml ;

  # 6. Replace all VARTHEME_SUBTHEME with the machine name of your theme.
  grep -rl 'VARTHEME_SUBTHEME' ${theme_path}/${theme_name} | xargs sed -i "s/VARTHEME_SUBTHEME/${theme_name}/g" ;

  # 7. Replace the name: 'Vartheme Sub-Theme (LESS)' to the name of your theme.
  grep -rl 'Vartheme Sub-Theme (LESS)' ${theme_path}/${theme_name} | xargs sed -i "s/Vartheme Sub-Theme (LESS)/${theme_name}/g" ;

else
  echo "The folder \"${theme_path}/${theme_name}\" theme in is already in the site.";
  exit 1;
fi
