<?php
// Load the settings file
require_once('inc/settings.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <!-- Load stylesheets -->
  <link rel="stylesheet" href="skin/<?php echo CSS_MAIN; ?>">
  <link rel="stylesheet" href="skin/<?php echo CSS_MOBILE; ?>">
</head>
<body>
  <header>
    <h1>Photo archive</h1>
    <div class="right">
      Viewing: /<?php // Get image path ?><br />
      <?php // get number of files ?> files
    </div>
  </header>
  <section id="fileManager">

  </section>
  <section id="imageBrowser">
    <div class="center">
      Copyright &copy; <?php // get copyright holder ?> (<?php echo date("Y"); ?>) - Powered by: <a href="http://f13dev.com">PHP Photo Archive</a>
    </div>
  </section>
  <footer>

  </footer>
</body>
</html>
