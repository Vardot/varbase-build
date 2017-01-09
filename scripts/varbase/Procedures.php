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

    // Full path and file name for the varbase.info.yml file.
    $varbase_info_file = $root . '/profiles/varbase/varbase.info.yml';

    if ($fs->exists($varbase_info_file)) {
      // Parse the varbase.info.yml file.
      $varbase_info = Yaml::parse(file_get_contents($varbase_info_file));

      // Get varbase version.
      $varbase_version = $event->getComposer()
        ->getRepositoryManager()
        ->getLocalRepository()
        ->findPackage('vardot/varbase', "*")
        ->getVersion();

      // Information added by varbase-build packaging script.
      $varbase_info['version'] = $varbase_version;
      $varbase_info['project'] = 'varbase';
      $varbase_info['datestamp'] = time();

      // Dump the array to string of Yaml format.
      $new_varbase_info = Yaml::dump($varbase_info);

      // Save the new varbase info into the varbase info file.
      file_put_contents($varbase_info_file, $new_varbase_info);

      // Print out a message to the user on Install and update.
      $event->getIO()->write(" Information added by varbase-build packaging script.");
      $event->getIO()->write(" - Updated varbase.info.yml file.");
      $event->getIO()->write(" - version: " . $varbase_version);
    }
  }
}
