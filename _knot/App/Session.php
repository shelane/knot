<?php

namespace App;

/**
 * Manage sessions.
 */
class Session {

  /**
   * The session state.
   *
   * @var bool
   */
  private bool $isStarted = FALSE;

  /**
   * Session timeout in seconds.
   *
   * @var int
   */
  private int $timeout;

  public function __construct(int $timeout = 3600) {
    $this->timeout = $timeout;
    $this->start();
  }

  /**
   * Starts the session if it is not already started.
   *
   * @return bool
   */
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
    $this->handleTimeout();
    return TRUE;
  }

  /**
   * Handles session timeout.
   *
   * @return void
   */
  private function handleTimeout(): void {
    if ($this->has('last_activity') && (time() - $this->get('last_activity') > $this->timeout)) {
      $this->destroy();
    }
    else {
      $this->set('last_activity', time());
    }
  }

  /**
   * Checks if a session variable is set.
   *
   * @param string $key
   *
   * @return bool
   */
  public function has(string $key): bool {
    return isset($_SESSION[$key]);
  }

  /**
   * Retrieves a value from the session.
   *
   * @param string $key
   * @param mixed $default
   *
   * @return mixed
   */
  public function get(string $key, $default = NULL) {
    return $this->has($key) ? $_SESSION[$key] : $default;
  }

  /**
   * Destroys the session.
   *
   * @return void
   */
  public function destroy(): void {
    session_unset();
    session_destroy();
    $this->isStarted = FALSE;
  }

  /**
   * Sets a value in the session.
   *
   * @param string $key
   * @param mixed $value
   *
   * @return void
   */
  public function set(string $key, $value): void {
    $_SESSION[$key] = $value;
  }

  /**
   * Checks if the session is started.
   *
   * @return bool
   */
  public function isStarted(): bool {
    return $this->isStarted;
  }

  /**
   * Regenerates the session ID.
   *
   * @param bool $deleteOldSession Whether to delete the old session data or not.
   *
   * @return bool
   */
  public function regenerateId(bool $deleteOldSession = TRUE): bool {
    if ($this->isStarted) {
      return session_regenerate_id($deleteOldSession);
    }
    return FALSE;
  }

  /**
   * Sets a session timeout.
   *
   * @param int $timeout Timeout in seconds.
   *
   * @return void
   */
  public function setTimeout(int $timeout): void {
    $this->timeout = $timeout;
  }

  /**
   * Clears all session variables.
   *
   * @return void
   */
  public function clear(): void {
    $_SESSION = [];
  }

  /**
   * Removes a session variable.
   *
   * @param string $key
   *
   * @return void
   */
  public function remove(string $key): void {
    unset($_SESSION[$key]);
  }
}
