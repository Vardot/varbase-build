<?php
/**
 * @file
 * Contains \Vardot\Varbase\Procedures.
 */
namespace Vardot\Varbase;
use Composer\Script\Event;
use Composer\Util\ProcessExecutor;
class Procedures {
  /**
   * Post install proceduare.
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
      if (isset($varbase)) {
        $varbase = str_replace('{$name}', 'varbase', $varbase);
        $executor = new ProcessExecutor($event->getIO());
        $output = NULL;
        $executor->execute('npm run install-libraries', $output, $varbase);
      }
    }
  }
  
  /**
   * Post Update proceduare.
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
      if (isset($varbase)) {
        $varbase = str_replace('{$name}', 'varbase', $varbase);
        $executor = new ProcessExecutor($event->getIO());
        $output = NULL;
        $executor->execute('npm run install-libraries', $output, $varbase);
      }
    }
  }
}