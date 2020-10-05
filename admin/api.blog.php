<?php

session_start();
include_once('functions.php');




////////////////////////////////////////////
// Retrieve all entries from the database //
////////////////////////////////////////////
if (isset($_GET['function']) && $_GET['function'] == 'get-entries') {
  $entries = getEntries()->fetchAll(PDO::FETCH_ASSOC);
  // echo $entries;
  echo json_encode($entries);
  exit;
}

//////////////////////////////////////
// Retrieve data for a single entry //
//////////////////////////////////////
else if (isset($_GET['function'], $_GET['entryID']) && $_GET['function'] == 'get-entry') {
  $entryID = $_GET['entryID'];
  $entry = getEntry($entryID)->fetch(PDO::FETCH_ASSOC);
  echo json_encode($entry);
  exit;
}

// Update an entry
else if (isset($_POST['function'], $_POST['entryID']) && $_POST['function'] == 'update-entry') {
  $entryID = $_POST['entryID'];
  $title   = $_POST['title'];
  $link    = $_POST['link'];
  $date    = $_POST['date'];
  $topicID = $_POST['topicID'];

  $result = updateEntry($entryID, $title, $link, $date, $topicID);

  // return error response if there was an error
  if ($result->rowCount() != 1) {
    echo getBadResponseCode();
  }

  exit;
}

////////////////////////
// Insert a new entry //
////////////////////////
else if (isset($_POST['new-entry-title'], $_POST['new-entry-link'], $_POST['new-entry-date'], $_POST['new-entry-topic'])) {
  $title = $_POST['new-entry-title'];
  $link  = $_POST['new-entry-link'];
  $date  = $_POST['new-entry-date'];
  $topic = $_POST['new-entry-topic'];

  $result = insertEntry($title, $link, $date, $topic);
  header('Location: home.php?entry-inserted=true');
  exit;

}

////////////////////////
// Log into account   //
////////////////////////
else if (isset($_POST['login-email'], $_POST['login-password'])) {
  $email = $_POST['login-email'];
  $password = $_POST['login-password'];

  if (isValidEmailAndPassword($email, $password)) {
    $_SESSION['loggedIn'] = true;
    header('Location: home.php');
    exit;
  }

  else {
    header('Location: login.php?logged-in=false');
    exit;
  }
}

////////////////////////
// Delete entry       //
////////////////////////
else if (isset($_POST['function'], $_POST['entryID']) && $_POST['function'] == 'delete-entry') {
  $entryID = $_POST['entryID'];
  $result = deleteEntry($entryID);

  // return error if not successful
  if ($result->rowCount() != 1)
    echo getBadResponseCode();
  
  exit;
}


?>