<?php

namespace App;

/**
 * The components that are part of building the page output.
 */
class Page {
  /**
   * The page title.
   *
   */
  public static string $title = '';

  /**
   * The template file name.
   */
  public static string $template = 'basic';

  /**
   * The page html content.
   */
  public static string $content;

  /**
   * The rendered menu for the page.
   */
  public static string $menu;

  /**
   * The rendered taskbar for the page.
   */
  public static string $taskbar = '';

  /**
   * The scripts used on a page.
   *
   * @var string[]
   */
  private static array $scripts = [];

  /**
   * @param string|null $value
   *  The optional value to add to the scripts.
   *
   */
  public static function scripts(?string $value = NULL): string|null {
    if ($value !== NULL) {
      self::$scripts[] = $value;
      return NULL;
    }
    else {
      return implode("\r\n", self::$scripts);
    }
  }

}

