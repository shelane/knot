
<!-- Javascript -->
<script src="/assets/fontawesome/js/all.js"></script>
<script src="/assets/jquery/jquery.min.js"></script>
<script src="/assets/bootstrap/bootstrap.bundle.js"></script>

<!-- Template css -->
<?php use App\Knot;
$template_js = 'js/' . Knot::get('default_template') . '.inc';
if (file_exists($template_js)):
  include $template_js;
endif;
?>
