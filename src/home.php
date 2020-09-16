<?php include('functions.php'); ?>
<?php include('Parsedown.php'); ?>
<?php $entries = getAllEntries(); ?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title>Ryan Rickgauer's Blog</title>
</head>
<body>

  <div class="container">

    <h1 id="hero" class="custom-font mt-5 mb-5">Ryan Rickgauer's Blog</h1>

    <!-- sorting select options -->
    <div class="toolbar-sort">
      <span class="label"><b>Sort:</b></span>
      <div>
        <select class="form-control form-control-sm select-sort">
          <option value="date">Date</option>
          <option value="title">Title</option>
        </select>
      </div>
    </div>

    <ul class="list-group list-group-flush">
      <?php
        while ($entry = $entries->fetch(PDO::FETCH_ASSOC)) {
          $id = $entry['id'];
          $title = $entry['title'];
          $date = $entry['date_formatted'];

          echo '<li class="list-group-item entry">';
          echo "<div  class=\"title\"><a href=\"entries.php?entryID=$id\">$title</a></div>";
          echo "<div class=\"date\">$date</div>";
          echo '</li>';
        }
      ?>
    </ul>

    <p class="text-center mt-4">
      <span>&copy; 2020 by </span>
      <a href="https://www.ryanrickgauer.com/resume/index.html" target="_blank">Ryan Rickgauer</a>
    </p>
  </div>


  <?php include('footer.php'); ?>
  <script src="js/home.js"></script>

</body>
</html>