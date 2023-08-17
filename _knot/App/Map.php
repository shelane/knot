<?php

namespace App;

/**
 * Settings data maintainer.
 */
class Map {
  /**
   * The settings map.
   *
   * @var array
   */
  protected array $map = [];

  /**
   * Adds setting to settings map.
   *
   * @param string $setting
   *   The setting name and value.
   */
  public function set(string $setting, mixed $value): void {
    $this->map[$setting] = $value;
  }

  /**
   * Get setting value from settings map.
   *
   * @param string $setting
   *   The setting name.
   *
   * @return mixed
   *   The value that is stored for the key may be many types.
   */
  public function get(string $setting): mixed {
    return $this->map[$setting] ?? '';
  }

}
