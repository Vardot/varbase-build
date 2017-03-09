<?php
/**
 * @file
 * Contains \Vardot\Varbase\Procedures.
 */

namespace Vardot\Varbase;
use Composer\Script\Event;
use Composer\Package\PackageInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Varbase build default procedures and script handler.
 */
class Procedures {

  /**
   * Get the Drupal root directory.
   *
   * @param type $project_root
   * @return type
   */
  protected static function getDrupalRoot($project_root) {
    return $project_root . '/docroot';
  }

  /**
   * Post install procedure.
   *
   * @param \Composer\Script\Event $event
   *   The script event.
   */
  public static function postInstallProcedure(Event $event) {
    // Generated the new varbase info into the varbase info file.
    Procedures::updateProfileInfoFile($event);
  }
  
  /**
   * Post Drupal Scaffold Procedure.
   *
   * @param \Composer\EventDispatcher\Event $event
   *   The script event.
   */
  public static function postDrupalScaffoldProcedure(\Composer\EventDispatcher\Event $event) {
    
    $fs = new Filesystem();
    $root = static::getDrupalRoot(getcwd());

    if ($fs->exists($root . '/profiles/varbase/src/assets/robots-staging.txt')) {
      //Create staging robots file
      copy($root . '/profiles/varbase/src/assets/robots-staging.txt', $root . '/robots-staging.txt');
    }
    
    if ($fs->exists($root . '/.htaccess')) {
      //Alter .htaccess file
      $htaccess_path = $root . '/.htaccess';
      $htaccess_lines = file($htaccess_path);
      $lines = [];
      foreach ($htaccess_lines as $line) {
        $lines[] = $line;
        if (strpos($line, "RewriteEngine on") !== FALSE
          && $fs->exists($root . '/profiles/varbase/src/assets/htaccess_extra')) {
          $lines = array_merge($lines, file($root . '/profiles/varbase/src/assets/htaccess_extra'));
        }
      }
      file_put_contents($htaccess_path, $lines);
    }
  }

  /**
   * Post update procedure.
   *
   * @param \Composer\Script\Event $event
   *   The script event.
   */
  public static function postUpdateProcedure(Event $event) {
    // Updated the new varbase info into the varbase info file.
    Procedures::updateProfileInfoFile($event);
  }

  /**
   * Update Profile Info File.
   *
   * @param Event $event
   */
  public static function updateProfileInfoFile(Event $event) {

    $fs = new Filesystem();
    $root = static::getDrupalRoot(getcwd());

    // File name for the varbase.info.yml file.
    $varbase_info_file = '/profiles/varbase/varbase.info.yml';
    $varbase_info_file_with_root_path = $root . $varbase_info_file;

    // File names for varbase features info files.
    $varbase_features_info_files = array(
      'varbase_admin' => '/profiles/varbase/modules/varbase_features/varbase_admin/varbase_admin.info.yml',
      'varbase_core' => '/profiles/varbase/modules/varbase_features/varbase_core/varbase_core.info.yml',
      'varbase_development' => '/profiles/varbase/modules/varbase_features/varbase_development/varbase_development.info.yml',
      'varbase_internationalization' => '/profiles/varbase/modules/varbase_features/varbase_internationalization/varbase_internationalization.info.yml',
      'varbase_landing' => '/profiles/varbase/modules/varbase_features/varbase_landing/varbase_landing.info.yml',
      'varbase_media' => '/profiles/varbase/modules/varbase_features/varbase_media/varbase_media.info.yml',
      'varbase_page' => '/profiles/varbase/modules/varbase_features/varbase_page/varbase_page.info.yml',
      'varbase_security' => '/profiles/varbase/modules/varbase_features/varbase_security/varbase_security.info.yml',
      'varbase_seo' => '/profiles/varbase/modules/varbase_features/varbase_seo/varbase_seo.info.yml',
      'varbase_site' => '/profiles/varbase/modules/varbase_features/varbase_site/varbase_site.info.yml',
      'varbase_user' => '/profiles/varbase/modules/varbase_features/varbase_user/varbase_user.info.yml',
    );

    if ($fs->exists($varbase_info_file_with_root_path)) {
      $varbase_info_datestamp = time();
      // Parse the varbase.info.yml file.
      $varbase_info = Yaml::parse(file_get_contents($varbase_info_file_with_root_path));

      // Varbase version.
      $varbase_version = '8.x-4.x-dev';
      $varbase_package = $event->getComposer()
        ->getRepositoryManager()
        ->getLocalRepository()
        ->findPackage('vardot/varbase', "*");
      
      // Only get the version if it was not DEV. to follow Drupal standard.
      if (!$varbase_package->isDev()) {
        $varbase_version = $varbase_package->getVersion();
      }

      // Information added by varbase-build packaging script.
      $varbase_info['version'] = $varbase_version;
      $varbase_info['project'] = 'varbase';
      $varbase_info['datestamp'] = $varbase_info_datestamp;

      // Dump the array to string of Yaml format.
      $new_varbase_info = Yaml::dump($varbase_info);

      // Save the new varbase info into the varbase info file.
      file_put_contents($varbase_info_file_with_root_path, $new_varbase_info);

      // Print out a message to the user on Install and update.
      $event->getIO()->write(" Information added by varbase-build packaging script.");
      $event->getIO()->write(" - version: " . $varbase_version);
      $event->getIO()->write(" - datestamp: " . $varbase_info_datestamp);
      $event->getIO()->write(" - Updated files.");
      $event->getIO()->write($varbase_info_file);
      
      // Update all varbase features info.yml files.
      foreach ($varbase_features_info_files as $varbase_feature_info_file) {
        $varbase_feature_info_file_with_root_path = $root . $varbase_feature_info_file;
        if ($fs->exists($varbase_feature_info_file_with_root_path)) {
          // Parse the varbase feature info.yml file.
          $varbase_feature_info = Yaml::parse(file_get_contents($varbase_feature_info_file_with_root_path));

          // Information added by varbase-build packaging script.
          $varbase_feature_info['version'] = $varbase_version;
          $varbase_feature_info['datestamp'] = $varbase_info_datestamp;

          // Dump the array to string of Yaml format.
          $new_varbase_feature_info = Yaml::dump($varbase_feature_info);

          // Save the new varbase feature info into the info.yml file.
          file_put_contents($varbase_feature_info_file_with_root_path, $new_varbase_feature_info);

          // Print out a message to the user on Install and update.
          $event->getIO()->write($varbase_feature_info_file);
        }
      }
    }
  }
}
