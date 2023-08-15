<?php

use App\Page;
use App\TaskBarButtonGroup;

$widget_jump_array = [
  'Tasks' => 'systems/tasks?systemID=1',
  'Errors' => 'systems/errors?ID=1',
  'Help' => 'systems/help?systemID=1',
  'Edit' => 'systems/input?ID=1',
  'Duplicate' => 'systems/input?type=>duplicate&ID=1'
];

$task_buttons = new TaskBarButtonGroup();

$task_buttons->setItems(['Actions' => $widget_jump_array, 'Filters' => '']);

$taskbar = $task_buttons->render();

Page::$taskbar = $taskbar;
?>

<div class="card square-card" id="stats_module">
  <div class="card-header">
    <div>
        System Status
      <span class="end-button">
        <a href="/?task=stats" class="stats-refresh"><i class="fa-solid fa-arrows-rotate"></i></a>
      </span>
    </div>
  </div>
  <div id="stats-results" class="card-body">

  </div>
</div>