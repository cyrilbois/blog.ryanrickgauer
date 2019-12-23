<?php
include_once('include-top.php');
include('Parsedown.php');

$entry = getEntry($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('header.php'); ?>

<link href="https://fonts.googleapis.com/css?family=Special+Elite&display=swap" rel="stylesheet" />

	<title><?php echo $entry['title'] ?></title>
</head>

<body>
	<?php include('navbar.php'); ?>
	<div class="container" id="content">

    <!-- entry title and date -->
    <div class="entry-title">
      <h1><?php echo $entry['title']; ?></h1>
      <h5><?php echo $entry['date']; ?></h5>
    </div>

    <br><br>
    <div id="content">
     <?php 
      $Parsedown = new Parsedown();
      echo $Parsedown->text($entry['content']);
     ?>
   </div>

   <br><br>

 </div>

 <script src="js/prism.js"></script>

 <script>
	 $(document).ready(function() {
		 $("#entries-nav").addClass("selected");
	 });
 </script>


<?php printFooter(); ?>

</body>

</html>
