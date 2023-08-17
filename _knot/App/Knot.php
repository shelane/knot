<?php

namespace App;

use Exception;

class Knot {
  /**
   * All registered keys.
   *
   * @var array
   */
  protected static array $registry = [];

  /**
   * Bind a new key/value into the container.
   *
   * @param string $key
   *   The key to store.
   * @param mixed $value
   *   The value for the key may be many types.
   */
  public static function set(string $key, mixed $value): void {
    static::$registry[$key] = $value;
  }

  /**
   * Retrieve a value from the registry.
   *
   * @param string $key
   *   The key to retrieve.
   *
   * @return mixed
   *   The value that is stored for the key may be many types.
   * @throws \Exception
   */
  public static function get(string $key): mixed {
    if (!array_key_exists($key, static::$registry)) {
      throw new Exception("No {$key} is bound in the container.");
    }
    if (is_callable(static::$registry[$key])) {
      return call_user_func(static::$registry[$key]);
    }
    return static::$registry[$key];
  }

}
