<?php

namespace App;

/**
 * The menu class that will compute the needed output for each page including
 * all necessary classes for active state.
 */
class Menu {
  /**
   * The menu data.
   *
   * @var array
   */
  public static array $menu = [];

  /**
   * The current page title.
   *
   * @var string
   */
  public static string $title = '';

  /**
   * The current page template.
   *
   * @var string
   */
  public static string $template = '';

  /**
   * The current path.
   *
   * @var string
   */
  public static string $path = '';

  /**
   * The current path.
   *
   * @var bool
   */
  public static bool $restricted = FALSE;

  /**
   * Builds standard menu.
   *
   * @param string $path
   *   The current path of the request.
   * @param int $level
   *   The depth of the menu.
   * @param array $menu
   *   The menu items in an associative array.
   *
   * @return string
   *   The html menu output.
   */
  public static function renderMenu(array $menu = []): string {
    if (empty($menu)) {
      $menu = self::$menu;
    }
    $output = '<ul class="navbar-nav">';
    foreach ($menu as $item) {
      if (isset($item['path']) && $item['path'] == self::$path) {
        self::$title = $item['title'] ?? 'Untitled';
        self::$template = $item['template'] ?? '';
        self::$restricted = $item['restricted'] ?? FALSE;
        $item['astyle'] = ' active';
      }
      if (isset($item['children'])) {
        $output .= self::renderDropdown($item);
      }
      elseif (isset($item['menu']) && $item['menu']) {
        $output .= self::renderMenuItem($item);
      }
    }
    $output .= '</ul>';

    return $output;
  }

  /**
   * Builds the icon code.
   *
   * @return string
   *   The HTML element with the icon class.
   */
  private static function renderIcon($icon): string {
    $iconMarkup = '';
    if (!empty($icon)) {
      $iconMarkup = "<i class=\"{$icon}\" aria-hidden=\"true\"></i> ";
    }
    return $iconMarkup;
  }

  /**
   * Builds menu list item.
   *
   * @param array $menuElement
   *   The menu element with defined setting attributes.
   *
   * @return string
   *   The li menu element.
   */
  private static function renderMenuItem(array $menuElement): string {
    $style = $menuElement['style'] ?? '';
    $path = $menuElement['path'] ?? '';
    $icon = $menuElement['icon'] ?? '';
    $label = $menuElement['label'] ?? '';
    $astyle = $menuElement['astyle'] ?? '';
    $iconMarkup = self::renderIcon($icon);
    $markup = <<<MARKUP
      <li class="nav-item {$style}">
        <a class="nav-link {$astyle}" href="/{$path}">
          {$iconMarkup}<span>{$label}</span>
        </a>
      </li>
MARKUP;

    return $markup;
  }

  /**
   * Builds the dropdown html for items with children.
   *
   * @return string
   *   The HTML string of the dropdown item with the returned children.
   */
  private static function renderDropdown(array $menuElement): string {
    $style = $menuElement['style'] ?? '';
    $icon = $menuElement['icon'] ?? '';
    $label = $menuElement['label'] ?? '';
    $astyle = $menuElement['astyle'] ?? '';
    $iconMarkup = self::renderIcon($icon);
    $output = <<<MARKUP
      <li class="nav-item dropdown {$style}">
        <a class="nav-link dropdown-toggle {$astyle}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {$iconMarkup}<span>{$label}</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <ul class="dropdown-list">
MARKUP;

    foreach ($menuElement['children'] as $childItem) {
      if (isset($childItem['menu']) && $childItem['menu']) {
        $output .= self::renderMenuItem($childItem);
      }
    }

    $output .= '</ul></div></li>';

    return $output;
  }

}
