<?php

include_once('functions.php');


$id = insertEntry($_POST['title'], $_POST['content']);

header('Location: entry.php?id=' . $id);
exit;

?>
