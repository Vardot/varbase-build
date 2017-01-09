<?php
/**
 * @file
 * Contains \Vardot\Varbase\Procedures.
 */

namespace Vardot\Varbase;
use Composer\Script\Event;

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

  }
  
  /**
   * Post update procedure.
   *
   * @param \Composer\Script\Event $event
   *   The script event.
   */
  public static function postUpdateProcedure(Event $event) {

  }
}