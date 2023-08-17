<?php

namespace App;

/**
 * The TaskBar class is for creating a Task Bar navigation of actions available
 * to users. This is expecting font awesome class values for the icons.
 *
 * Usage:
 *
 * The icons should be set in an application configuration file prior to
 * instantiating a new TaskBar object. See docs for full usage.
 */
class TaskBar {

  /**
   * The defined available icons as an associative array by title => icon.
   *
   * @var array
   */
  protected static array $icons = [];

  /**
   * The array of items that will appear in the taskbar as either
   * title => link or title => 'array of links'.
   *
   * @var array
   */
  protected array $items = [];

  /**
   * The optional icon size modifier such as 'fa-lg'.
   *
   */
  protected string $iconSize = '';

  /**
   * Set the available icons for the entire application use.
   *
   * @param array $iconList
   *   The list of icons as associative array by title => icon.
   *
   */
  public static function setIcons(array $iconList): void {
    self::$icons = $iconList;
  }

  /*
   * Returns the icon array.
   *
   * @return array
   */
  public static function getIcons(): array {
    return self::$icons;
  }

  /**
   * Set the size of the icons to be displayed in the taskbar.
   *
   * @param string $size
   *   The class size modifier.
   *
   */
  public function setIconSize(string $size): void {
    $this->iconSize = $size;
  }

  /**
   * Set initial items to appear in the taskbar.
   *
   * @param array $items
   *   The initial set of items as needed.
   *
   */
  public function setItems(array $items): void {
    $this->items = $items;
  }

  /**
   * Add a single item to the taskbar.
   *
   * @param string $title
   *   The title of the item.
   * @param mixed $link
   *   A link or array of additional items.
   * @param string $position
   *   The position to add the item as start|end.
   *
   * @throws \Exception
   */
  public function addItem(string $title, mixed $link, string $position = 'end'): void {
    if (isset(self::$icons[$title])) {
      if ($position == 'start') {
        // Add the new item at the start of the array.
        $this->items = [$title => $link] + $this->items;
      }
      else {
        $this->items[$title] = $link;
      }

    }
    else {
      throw new \Exception('Invalid icon. Icon not found in the icons mapping.');
    }
  }

  /**
   * Remove an item from the taskbar.
   *
   * @param string $title
   *   The item title to remove from items.
   *
   */
  public function removeItem(string $title): void {
    unset($this->items[$title]);
  }

  /**
   * Clear all items from the taskbar.
   *
   */
  public function clearItems(): void {
    $this->items = [];
  }

  /**
   * Render the taskbar as a Bootstrap navbar.
   *
   * @throws \Exception
   */
  public function render(): string {
    // This method is intentionally left blank in the base class.
    // It will be implemented differently in the subclasses.

    return '';
  }

}
