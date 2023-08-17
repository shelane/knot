<?php

/**
 * Debug output of variable in readable fashion.
 *
 * @param mixed $value
 *   The variable to output.
 */
function dd(mixed $value): void {
  echo "<pre>";
  var_dump($value);
  echo "</pre>";

  die();
}

function br(): void {
  echo '<br>';
}

function hr(): void {
  echo '<hr>';
}
