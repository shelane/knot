<?php

/**
 * @file
 * The supportive functions for knot.
 */

/**
 * Provides function to clear the render buffer.
 */
function cancel_render(): void {
  global $rendering;
  $rendering = FALSE;
  ob_end_clean();
}

/**
 * Provides a redirect function for a page.
 *
 * @param $destination
 *   The URL or path of the page to redirect to.
 * @param int $code
 *   The response code.
 */
function redirect($destination, int $code = 303): void {
  cancel_render();
  $response_codes = [
    300 => "Multiple Choices",
    301 => "Moved Permanently",
    302 => "Found",
    303 => "See Other",
    304 => "Not Modified",
    305 => "Use Proxy",
    307 => "Temporary Redirect",
  ];
  if (isset($response_codes[$code])) {
    $http_line = "HTTP/1.0 $code " . $response_codes[$code];
    header($http_line);
    header("Location: " . $destination);
  }
  exit();
}

/**
 * Figures out the path to the requested content item.
 *
 * @param $query_path
 * @param $content_path
 *
 * @return false|string
 *   The path of the page
 *
 */
function get_path($query_path, $content_path): false|string {

  $path_elements = explode("/", $query_path);
  $path_elements = array_filter($path_elements); //accounts for an end slash

  $numbpath_elements = count($path_elements);

  $file_path = "";

  for ($i = 0; $i < $numbpath_elements; $i++) {
    $file_path .= $path_elements[$i];

    if ($i === $numbpath_elements - 1) {
      $file_path .= ".inc";
    }
    else {
      $file_path .= "/";
    }
  }

  $page = $content_path . "_pages/" . $file_path;

  if (file_exists($page)) {
    return $page;
  }
  else {
    return FALSE;
  }
}

/**
 * Gets the rendered content of the encapsulated content.
 *
 * @param $callback
 *   A callback function for wrapping around content to save.
 *
 * @return false|string
 *   The rendered content of the page.
 */
function capture_content($callback): false|string {
  ob_start();
  $callback();
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

/**
 * Gets the rendered content of the requested page.
 *
 * @param $file
 *   The file path to process and render.
 *
 * @return false|string
 *   The rendered content of the page.
 */
function get_content($file): false|string {
  ob_start();
  include $file;
  return ob_get_clean();
}

/**
 * Adds the site page content to app var.
 *
 * @param $file
 *
 * @return false|string
 *   The rendered page content.
 */
function page_content($file): false|string {
  return $file ? get_content($file) : '';
}

/**
 * Return sensitive data obfuscated.
 *
 * @param $input
 *   The value to obfuscate.
 *
 * @return string
 *   The obfuscated string value.
 */
function obfuscate($input): string {
  $output = '';
  foreach (str_split($input) as $obj) {
    $output .= '&#' . ord($obj) . ';';
  }
  return $output;
}

/**
 * Returns variable value based on cascading rules.
 *
 * @param $default
 *   An optional default value of the variable if none other provided.
 * @param $override
 *   An optional override value, usually from request parameter value.
 * @param array $validate
 *   An optional validation array of values to check from request parameter.
 * @param $force
 *   An optional overload value.
 * @return mixed|string
 *   The value of the variable based on the cascading rules check.
 */
function var_define($default = NULL, $override = NULL, array $validate = [], $force = NULL): mixed {
  if ($force) {
    return $force;
  }
  elseif ($override && !empty($validate)) {
    if (in_array($override, $validate)) {
      return rtrim(trim(htmlspecialchars(strip_tags($override))), '/');
    }
    elseif ($default) {
      return $default;
    }
    else {
      return '';
    }
  }
  elseif ($override) {
    return $override;
  }
  elseif ($default) {
    return $default;
  }
  else {
    return '';
  }
}
