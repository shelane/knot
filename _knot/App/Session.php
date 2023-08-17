<?php

namespace App;

/**
 * Manage sessions.
 */
class Session {
  /**
  * The session state.
  *
  */
  private bool $isStarted = FALSE;

  public function __construct() {
    $this->start();
  }

  public function isStarted(): bool {
    $this->isStarted = session_status() === PHP_SESSION_ACTIVE;

    return $this->isStarted;
  }

  public function start(): bool {
    if ($this->isStarted) {
      return TRUE;
    }

    if (session_status() === PHP_SESSION_ACTIVE) {
      $this->isStarted = TRUE;

      return TRUE;
    }

    session_start();
    $this->isStarted = TRUE;

    return TRUE;
  }

  public function has(string $key): bool {
    return array_key_exists($key, $_SESSION);
  }

  public function get(string $key, $default = NULL) {
    if ($this->has($key)) {
      return $_SESSION[$key];
    }

    return $default;
  }

  public function set(string $key, $value): void {
    $_SESSION[$key] = $value;
  }

  public function clear(): void {
    $_SESSION = [];
  }

  public function remove(string $key): void {
    if ($this->has($key)) {
      unset($_SESSION[$key]);
    }
  }

}







