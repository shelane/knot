<?php

namespace App;

class TaskBarFontAwesome extends TaskBar {

  /**
   * {@inheritdoc}
   */
  public function render(): string {

    if (empty(parent::$icons)) {
      throw new \Exception('Icons mapping not set. Please call Taskbar::setIcons() to set the available icons before rendering the navbar.');
    }
    $output = '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    $output .= '<div class="container">';
    $output .= '<ul class="navbar-nav">';

    foreach ($this->items as $title => $item) {
      if (is_array($item)) {
        // If $item is an array, render a dropdown menu
        $output .= '<li class="nav-item dropdown">';
        $output .= '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">';
        $output .= '<div class="dropdown-icon">';
        $output .= '<i class="' . self::$icons[$title] . ' ' . $this->iconSize . '"></i>';
        $output .= '<i class="fas fa-caret-down"></i>';
        $output .= '</div>';
        $output .= $title;
        $output .= '</a>';
        $output .= '<ul class="dropdown-menu">';

        foreach ($item as $subTitle => $subLink) {
          $output .= '<li><a class="dropdown-item" href="' . $subLink . '">' . $subTitle . '</a></li>';
        }

        $output .= '</ul>';
      }
      else {
        // If $item is a string, render a regular navbar item
        $link = $item;
        $output .= '<li class="nav-item">';
        $output .= '<a class="nav-link" href="' . $link . '">';
        $output .= '<div class="dropdown-icon">';
        $output .= '<i class="' . self::$icons[$title] . ' ' . $this->iconSize . '"></i>';
        $output .= '</div>';
        $output .= $title;
        $output .= '</a>';
      }
      $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</nav>';

    return $output;
  }

}
