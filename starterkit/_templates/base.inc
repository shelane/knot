<?php
use App\Knot;
use App\Page;
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <meta charset="utf-8" />
  <title><?php
    $html_title = Knot::get('site_name') . ' | ' . Page::$title;
    $html_title = strip_tags($html_title);
    echo $html_title;
    ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include BASE_PATH . '_templates/css-includes.inc'; ?>
</head>
<body id="body" class="up-scroll" data-bs-spy="scroll" data-bs-target=".element-right-sidebar" data-bs-offset="0">
<?php include BASE_PATH . '_templates/' . Knot::get('default_template') . '.inc'; ?>
<?php include BASE_PATH . '_templates/js-includes.inc'; ?>
</body>
</html>
