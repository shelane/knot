<?php

namespace App;

/**
 * A pagination class for full pager, previous/next paging, shown items.
 */
class Pagination {

  /**
   * @var string
   */
  private string $baseurl;

  /**
   * @var int
   */
  private int $foundCount;

  /**
   * @var int
   */
  private int $shownCount;

  /**
   * @var int
   */
  private int $page;

  /**
   * Settings are initiated on construct of the object and are shared with
   * members.
   *
   * @param string $baseurl
   * @param int $foundCount
   * @param int $shownCount
   * @param int $page
   */
  public function __construct(string $baseurl, int $foundCount, int $shownCount, int $page) {
    $this->baseurl = $baseurl;
    $this->foundCount = $foundCount;
    $this->shownCount = $shownCount;
    $this->page = $page;
  }

  /**
   * Build and output pagination with settings for number pages shown.
   *
   * @param int $range
   *
   * @return string|void
   */
  public function renderPager(int $range = 5) {
    if ($this->foundCount > $this->shownCount) {
      $total = ceil($this->foundCount / $this->shownCount);
      $output = '<ul class="pagination">';

      if ($this->page > 1) {
        // First page link
        $output .= '<li class="page-item"><a class="page-link" href="' . $this->baseurl . '1">&laquo;</a></li>';
        // Previous page link
        $output .= '<li class="page-item"><a class="page-link" href="' . $this->baseurl . ($this->page - 1) . '">&lsaquo;</a></li>';
      }

      // Calculate start and end page links based on range
      $startPage = max(1, $this->page - $range);
      $endPage = min($total, $this->page + $range);

      for ($num = $startPage; $num <= $endPage; $num++) {
        $isActive = $num === $this->page ? ' active' : '';
        $output .= '<li class="page-item' . $isActive . '"><a class="page-link" href="' . $this->baseurl . $num . '">' . $num . '</a></li>';
      }

      if ($this->page < $total) {
        // Next page link
        $output .= '<li class="page-item"><a class="page-link" href="' . $this->baseurl . $this->page + 1 . '">&rsaquo;</a></li>';
        // Last page link
        $output .= '<li class="page-item"><a class="page-link" href="' . $this->baseurl . $total . '">&raquo;</a></li>';
      }

      $output .= '</ul>';

      return $output;
    }
  }

  /**
   * A first/previous and next/last navigation with shown.
   *
   * @param string $size
   * @param bool $shown
   * @param string $label
   *
   * @return string
   */
  public function pageNav(string $size = '', bool $shown = TRUE, string $label = ''): string {
    $total = ceil($this->foundCount / $this->shownCount);

    $first = $this->page != 1 ? $this->baseurl . '1' : '';
    $previous = $this->page != 1 ? $this->baseurl . ($this->page - 1) : '';
    $next = $this->page != $total ? $this->baseurl . $this->page + 1 : '';
    $last = $this->page != $total ? $this->baseurl . $total : '';
    $output = '<nav class="d-flex justify-content-between align-items-center"><div class="d-flex">';
    if ($first) {
      $output .= "<a href=\"{$first}\" class=\"me-2\"><i class=\"fa-solid fa-backward-fast {$size}\"></i></a><a href=\"{$previous}\"><i class=\"fa-solid fa-backward-step {$size}\"></i></a>";
    }
    else {
      $output .= "<a class=\"disabled me-2\" aria-disabled=\"true\"><i class=\"fa-solid fa-backward-fast {$size}\"></i></a>
<a class=\"disabled\" aria-disabled=\"true\"><i class=\"fa-solid fa-backward-step {$size} me-2\"></i></a>";
    }
    $output .= '</div>';
    if ($shown) {
      $output .= "<div class=\"flex-grow-1 text-center shown-count\">{$this->shown($label)}</div>";
    }
    $output .= '<div class=\"d-flex\">';
    if ($last) {
      $output .= "<a href=\"{$next}\"><i class=\"fa-solid fa-forward-step {$size}\"></i></a><a href=\"{$last}\" class=\"ms-2\"><i class=\"fa-solid fa-forward-fast {$size}\"></i></a>";
    }
    else {
      $output .= "<a class=\"disabled\" aria-disabled=\"true\"><i class=\"fa-solid fa-forward-step {$size}\"></i></a><a class=\"disabled ms-2\" aria-disabled=\"true\"><i class=\"fa-solid fa-forward-fast {$size}\"></i></a>";
    }

    $output .= '</div></nav>';

    return $output;
  }

  /**
   * @param string $label
   * @return string
   */
  public function shown(string $label = ''): string {
    $start = ($this->page - 1) * $this->shownCount + 1;
    $end = min($this->page * $this->shownCount, $this->foundCount);

    if ($start == $end) {
      $numbers = $start;
    }
    else {
      $numbers = "{$start} - {$end}";
    }

    return "{$numbers} of {$this->foundCount} $label";
  }
}
