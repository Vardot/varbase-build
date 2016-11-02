# Varbase Build

## Usage

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

> Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
You might need to replace `composer` with `php composer.phar` (or similar)
for your setup.

After that you can create the project:

```
composer create-project Vardot/varbase-build:8.4.0-beta8 PROJECT_DIR_NAME --stability beta --no-interaction
```

If you want to create a project with the development option, to get the latest
development work.

```
composer create-project Vardot/varbase-build:8.x PROJECT_DIR_NAME --stability dev --no-interaction
```

## Automated testing
To run the automated testing with behat you will need to change the [ wd_host and base_url ] settings in the
[ behat.varbase.yml ] file to go with your project configuration and the selenium server.

```
    Behat\MinkExtension:
      files_path: "%paths.base%/tests/assets/"
      goutte: ~
      selenium2:
        wd_host: 127.0.0.1:4445/wd/hub
        capabilities:
          browser: 'firefox'
          # browser: 'chrome'
          # browser: 'phantomjs'
          nativeEvents: true
      base_url: 'http://127.0.0.1:8080'
      browser_name: 'firefox'
      # browser_name: 'chrome'
      # browser_name: 'phantomjs'
      javascript_session: selenium2
```
      
Then go to [ PROJECT_DIR_NAME/docroot/profiles/varbase ] in the terminal then you could run the following command:

```
$ ../../../bin/behat tests/features/varbase

```
Then you will be able to open the full report for the automated test in a web browser at the following path:
[ PROJECT_DIR_NAME/docroot/profiles/varbase/tests/reports/index.html ]
