<?php
/**
 * @file
 * Contains \Vardot\Varbase\Procedures.
 */
namespace Vardot\Varbase;
use Composer\Script\Event;
class Procedures {
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
  }
}