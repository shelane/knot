<?php

namespace App;

class TaskBarButtonGroup extends TaskBar {

  /**
   * {@inheritdoc}
   */
  public function render(): string {

    if (empty(parent::$icons)) {
      throw new \Exception('Icons mapping not set. Please call Taskbar::setIcons() to set the available icons before rendering the navbar.');
    }
    $output = '<div class="btn-group btn-group-sm btn-text-dark">';

    foreach ($this->items as $title => $item) {
      $iconId = 'icon-' . preg_replace('/[^a-zA-Z0-9_\-]/', '-', $title);
      if (is_array($item)) {
        // If $item is an array, render a dropdown menu
        $output .= '<div class="btn-group" role="group">';
        $output .= '<button type="button" id="' . $iconId . '" class="btn btn-light btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
        $output .= '<i class="' . parent::$icons[$title] . ' ' . $this->iconSize . '"></i>&nbsp;';
        $output .= $title;
        $output .= '</button>';
        $output .= '<ul class="dropdown-menu btn-sm">';

        foreach ($item as $subTitle => $subLink) {
          if ($subLink === 'divider') {
            // Render a divider
            $output .= '<li><hr class="dropdown-divider"></li>';
          }
          // If $item is a string, render a regular item
          elseif ($subLink === '') {
            // Render non-clickable item
            $output .= '<span class="dropdown-item-text">' . $subTitle . '</span>';
          }
          else {
            $icon = parent::$icons[$subTitle] ?? '';
            $icon = $icon ? "<i class=\"{$icon}\"></i> " : '';
            $output .= "<li><a class=\"dropdown-item\" href=\"{$subLink}\">{$icon}{$subTitle}</a></li>";
          }
        }

        $output .= '</ul></div>';
      }
      else {
        // If $item is a string, render a regular item
        $output .= '<a id="' . $iconId . '" class="btn btn-light btn-sm btn-outline-secondary" href="' . $item . '">';
        $output .= '<i class="' . parent::$icons[$title] . ' ' . $this->iconSize . '"></i>&nbsp;';
        $output .= $title;
        $output .= '</a>';
      }
    }

    $output .= '</div>';

    return $output;
  }

}
