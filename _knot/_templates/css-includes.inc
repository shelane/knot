<!-- Plugins css Style -->
<link href="/assets/fontawesome/css/all.css" rel="stylesheet">
<link href="/assets/bootstrap/bootstrap.css" rel="stylesheet">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Dosis:300,400,600,700|Open+Sans:300,400,600,700" rel="stylesheet">

<!-- Template css -->
<?php use App\Knot;
$template_css = '_templates/css/' . Knot::get('default_template') . '.inc';

if (file_exists(BASE_PATH . $template_css)):
  include BASE_PATH . $template_css;
endif;
?>
