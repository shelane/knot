<?php

namespace App;

/**
 * Utility class to track sort field and output a table header row with ability
 * to sort and mark as it is sorted.
 */
class SortParams {
  /**
   * The available fields list.
   *
   * @var array
   */
  private array $fields = [];

  /**
   * The sort field to use in a database query.
   *
   * @var string
   */
  public string $sortField = '';

  /**
   * The sort order to use in a database query.
   *
   * @var string
   */
  public string $sortOrder = 'asc';

  /**
   * To set the field list available for sorting by associative array as
   * title => field or title => false for not using the column for sorting.
   *
   * @param array $fields
   * @return void
   */
  public function setFields(array $fields): void {
    $this->fields = $fields;
  }

  /**
   * Adds additional item to the fields list.
   *
   * @param string $title
   * @param string $field
   * @return void
   */
  public function addField(string $title, string $field): void {
    $this->fields[$title] = $field;
  }

  /**
   * Gets list of sortable fields by fieldname only.
   *
   * @return array
   */
  public function getFieldList(): array {
    return array_values(array_filter($this->fields, function($value) {
      return $value !== false;
    }));
  }

  /**
   * Sets the sort field and sort order based on allowed field list and
   * submitted sort value.
   *
   * @param string $sorted
   * @param string $default
   * @param string $defaultorder
   * @return void
   */
  public function setSortField(string $sorted = '', string $default = '', string $defaultorder = ''): void {
    $sortableFields = $this->getFieldList();

    if (str_contains($sorted, '-')) {
      $sorted = explode('-', $sorted);
      if (in_array($sorted[0], $sortableFields)) {
        $this->sortField = $sorted[0];
        if ($sorted[1] == 'desc') {
          $this->sortOrder = 'desc';
        }
      }
      elseif ($default && in_array($default, $sortableFields)) {
        $this->sortField = $default;
        if ($defaultorder == 'desc') {
          $this->sortOrder = 'desc';
        }
      }
    }
    elseif ($default && in_array($default, $sortableFields)) {
      $this->sortField = $default;
      if ($defaultorder == 'desc') {
        $this->sortOrder = 'desc';
      }
    }
  }

  /**
   * Renders the table header row with sort field and markers.
   *
   * @param string $baseurl
   * @param string $class
   * @param string $prepend
   * @param string $append
   * @return string
   */
  public function renderHeader(string $baseurl, string $class = '', string $prepend = '', string $append = ''): string {
    $class = $class ? ' class="' . $class . '"' : '';
    $output = '<tr>';
    $delimiter = str_contains($baseurl, '?') ? '&' : '?';
    if ($prepend) {
      $output .= "<th{$class}>{$prepend}</th>";
    }
    foreach ($this->fields as $title => $field) {
      if ($this->sortField == $field && $this->sortOrder == 'desc') {
        $order = '';
        $mark = '&#9660;';
      }
      elseif ($this->sortField == $field) {
        $order = 'desc';
        $mark = '&#9650;';
      }
      else {
        $order = $mark = '';
      }
      $output .= "<th{$class}>";
      if ($field) {
        $output .= "<a href=\"{$baseurl}{$delimiter}sort={$field}-{$order}\"{$class}>{$title}</a>";
        $output .= $mark ? "<span class=\"sortmarker\">{$mark}</span>" : '';
      }
      else {
        $output .= $title;
      }
      $output .= '</th>';
    }
    if ($append) {
      $output .= "<th{$class}>{$append}</th>";
    }
    $output .= '</tr>';
    return $output;
  }
}
