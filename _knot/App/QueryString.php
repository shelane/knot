<?php

namespace App;

/**
 * Define a QueryString that you can build on and then output with your links.
 * You can add an additional item at the time of output that won't be built into
 * the existing object.
 */
class QueryString {

  /**
   * The query string to build and output for related links.
   *
   * @var string
   */
  private string $query_string;

  /**
   * When instantiating a new QueryString, you can default it with an initial
   * list from builder and any items that need to be removed.
   *
   * @param array|string|null $incoming
   *   An initial string or array of query values
   * @param array|string|null $remove
   *   A means to remove unneeded default values from incoming.
   */
  public function __construct(array|string $incoming = NULL, array|string $remove = NULL) {
    $this->query_string = '';
    if ($incoming != NULL) {
      if ($remove != NULL && is_array($incoming)) {
        if (is_string($remove)) {
          unset($incoming[$remove]);
        }
        elseif (is_array($remove)) {
          foreach ($remove as $value) {
            unset($incoming[$value]);
          }
        }
      }
      $this->add($incoming);
    }
  }

  /**
   * Add new item to query string
   *
   * @param string|array $incoming
   *   Item(s) to add to
   *
   * @return void
   */
  public function add($incoming): void {
    if (is_array($incoming)) {
      foreach ($incoming as $key => $value) {
        $this->build('&' . $key . '=' . $value);
      }
    }
    else {
      $this->build($incoming);
    }
  }

  /**
   * Add a proper item to the query string.
   *
   * @param string $item
   *   The item to add.
   *
   * @return void
   */
  private function build(string $item): void {
    $this->query_string .= !str_starts_with($item, '&') ? '&' : '';
    $this->query_string .= $item;
  }

  /**
   * Building the final string encoded as a proper url query string.
   *
   * @param string $incoming
   *   On the fly string to add to the output without adding to object.
   *
   * @return string
   *   The final query string.
   */
  public function output(string $incoming = ''): string {
    $output = $this->query_string;
    if ($incoming) {
      $output .= !str_starts_with($incoming, '&') ? '&' : '';
      $output .= $incoming;
    }
    if ($output) {
      // Remove leading '&' if present
      $output = ltrim($output, '&');

      // Split the query string into individual key-value pairs
      $params = explode('&', $output);

      // Initialize an array to hold the encoded key-value pairs
      $encoded = [];

      // Encode key-value pairs and add them to the encoded array
      foreach ($params as $param) {
        // Split the parameter into key and value
        $parts = explode('=', $param, 2);
        $key = $parts[0] ?? ''; // Default to empty string if not set
        $value = $parts[1] ?? ''; // Default to empty string if not set

        // Encode key and value
        $encodedKey = urlencode($key);
        $encodedValue = urlencode($value);

        // Add the encoded pair to the array
        $encoded[] = "{$encodedKey}={$encodedValue}";
      }

      // Join the encoded key-value pairs back together
      $output = '?' . implode('&', $encoded);
    }

    return $output;
  }


}
