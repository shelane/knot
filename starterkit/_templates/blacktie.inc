<?php
use App\Knot;
use App\Page;
?>
<div class="navbar-container">
  <div data-sticky="top" style="top: 0px;">
    <nav class="navbar navbar-expand-md">
      <a class="navbar-brand" href="<?= Knot::get('root_path') ?>"><?= Knot::get('site_name') ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <?= Page::$menu ?>
      </div>
      <!--end nav collapse-->
    </nav>
  </div>
</div>

<div class="content">
  <div class="page-header d-flex justify-content-between align-items-center">
    <h1 class="page-title"><?= Page::$title ?></h1>
    <div class="taskbar">
      <div class="btn-toolbar" role="group" aria-label="Taskbar">
        <?= Page::$taskbar ?>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <?php include BASE_PATH . '_templates/pages/' . Page::$template . '.inc'; ?>
    <footer>
      <hr>
      <p class="float-end"></p> <!-- Use float-end class for Bootstrap 5 -->
      <p>&copy; <?= date('Y') ?></p>
    </footer>
  </div>
</div>


