<?php
// connects to DB
// returns the PDO connection
function dbConnect() {
  include('db-info.php');

  try {
    // connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

  } catch(PDOexception $e) {
      return 0;
  }
}

function insertEntry($title, $content) {

   $pdo = dbConnect();

   $content = addslashes($content);
   $title = addslashes($title);

   $sql = "INSERT INTO Entries (date, title, content) VALUES (CURRENT_DATE(), \"$title\", \"$content\")";
   $result = $pdo->exec($sql);

   $sql = 'SELECT id FROM Entries ORDER BY id desc LIMIT 1';
   $result = $pdo->query($sql);
   $row = $result->fetch(PDO::FETCH_ASSOC);

   $pdo = null;

   return $row['id'];
}

function updateEntry($id, $title, $content) {

   $pdo = dbConnect();

   $content = addslashes($content);
   $title = addslashes($title);

   $sql = "UPDATE Entries SET title=\"$title\", content=\"$content\" WHERE id=$id";
   $result = $pdo->exec($sql);

   $pdo = null;

}

function getEntry($id) {

  $pdo = dbConnect();
  $sql = "SELECT Entries.id, Entries.title, Entries.content, DATE_FORMAT(Entries.date, \"%M %D, %Y\") as \"date\" FROM Entries WHERE id=$id";
  $result = $pdo->query($sql);

  return $result->fetch(PDO::FETCH_ASSOC);

}

function deleteEntry($id) {
  $pdo = dbConnect();
  $sql = "DELETE FROM Entries WHERE id=$id";
  $result = $pdo->exec($sql);
  $pdo = null;
  $result = null;
}

function printTitleSelectOptions() {

  $pdo = dbConnect();
  $sql = 'SELECT * from Entries ORDER BY Title desc';
  $result = $pdo->query($sql);

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $date = $row['date'];
    $title = $row['title'];
    $content = $row['content'];

    echo "<option value=\"$id\">$title</option>";

  }
}

function isLoginSuccessful($username, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Authors.password FROM Authors WHERE Authors.username=:username');

  // filter variables
  $username = filter_var($username, FILTER_SANITIZE_STRING);

  // bind the parameters
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  // execute sql statement
  $sql->execute();

  // fetch the results
  $author = $sql->fetch(PDO::FETCH_ASSOC);

  // close the pdo connections
  $pdo = null;
  $sql = null;

  // return true if passwords match
  // otherwise, return false
  return ($password == $author['password']);
}

function getAllEntries() {
  $pdo = dbConnect();
  $sql = "select Entries.id, Entries.title, Entries.date, DATE_FORMAT(Entries.date, \"%M %D, %Y\") as 'date_formatted' from Entries ORDER BY date desc, id desc";
  $results = $pdo->query($sql);

  $pdo = null;
  $sql = null;

  return $results;
}

function printFooter() {
    echo "<div class=\"container-fluid\" id=\"footer\">
		<p>Made by <a href=\"https://www.ryanrickgauer.com/resume/index.html\">Ryan Rickgauer</a> &copy; 2019</p>
	</div>";
}




?>
