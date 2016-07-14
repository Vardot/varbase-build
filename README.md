# HOW TO BUILD FOR NEW PROJECT #

This is an installation guide to build and update (rebuild), Varbase and other distros and sites using Varbase.

### 1. Download the build script from Github releases (you don't have to clone this repo). ###
https://github.com/Vardot/varbase-build/releases

```
#!shell

wget https://github.com/Vardot/varbase-build/archive/7.3.0.zip -O ~/varbase-build-7.3.0.zip
```

### 2. Prepare your project root directory ###
Change `/var/www/` to your preferred web server. Don't forget to change `[project name]` to your project name.
```
#!shell

mkdir -p /var/www/[project name]/docroot
```

### 3. Extract the build script to your new created directory ###
Change `/var/www/` to your preferred web server. Don't forget to change `[project name]` to your project name.
```
#!shell

unzip -j ~/varbase-build-7.3.0.zip -d /var/www/[project name]/docroot/build
```
Then *optionally* cleanup the original downloaded script.
```
#!shell

rm ~/varbase-build-7.3.0.zip
```

### 4. Go into the newly created `build`, make your make file to build the new project website ###
```
#!shell

cd /var/www/[project name]/docroot/build
cp example.make [project name].make
```

### 5. Run the build script ###
```
#!shell

./build.sh
```

### 6. Follow the wizard ###
You will need the most recent Drush version. See [this snippet](https://bitbucket.org/snippets/Vardot/8rGL#1%29%20Install%20nodeJS%2C%20npm%2C%20less%2C%20sass%20and%20Drush-18).
