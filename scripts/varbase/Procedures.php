<?php
/**
 * @file
 * Contains \Vardot\Varbase\Procedures.
 */

namespace Vardot\Varbase;
use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;

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
    $extra = $event->getComposer()->getPackage()->getExtra();
    if (isset($extra['installer-paths'])) {
      foreach ($extra['installer-paths'] as $path => $criteria) {
        if (array_intersect(['drupal/varbase', 'type:drupal-profile'], $criteria)) {
          $varbase = $path;
        }
      }
    }
    
    
    try {
      // Remove the not needed vendor directory as we are using the varbase-build composer file.
      $fs = new Filesystem();
      $root = static::getDrupalRoot(getcwd());

      if (!$fs->exists($root . '/vendor')) {
        $fs->remove($root . '/vendor');
      }
    } catch (IOExceptionInterface $e) {
        echo "An error occurred while removing the not needed vendor directory at ".$e->getPath();
    }
  }
  
  /**
   * Post update procedure.
   *
   * @param \Composer\Script\Event $event
   *   The script event.
   */
  public static function postUpdateProcedure(Event $event) {
    $extra = $event->getComposer()->getPackage()->getExtra();
    if (isset($extra['installer-paths'])) {
      foreach ($extra['installer-paths'] as $path => $criteria) {
        if (array_intersect(['drupal/varbase', 'type:drupal-profile'], $criteria)) {
          $varbase = $path;
        }
      }
    }
    
    try {
      // Remove the not needed vendor directory as we are using the varbase-build composer file.
      $fs = new Filesystem();
      $root = static::getDrupalRoot(getcwd());

      if (!$fs->exists($root . '/vendor')) {
        $fs->remove($root . '/vendor');
      }
    } catch (IOExceptionInterface $e) {
        echo "An error occurred while removing the not needed vendor directory at ".$e->getPath();
    }
    
  }
}