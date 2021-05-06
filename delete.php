<?php
    require("config.php");
  try
  {
      $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
  }
  catch (Exception $e)
  {
          die('Erreur : ' . $e->getMessage());
  }

if(isset($_GET['id']) && $_GET['id'] != ""){
   $statement = "DELETE FROM {$db_table_histo} WHERE id = '{$_GET['id']}'";
   $h = $conn->exec($statement);
   header('Location: histo.php?page='.$_GET['page'].'&delete=1&sh='.$_GET['sh']);//getParams si ya des erreur c'est gerré via checkParams dans config.php

}
else{

  header('Location: histo.php?page='.$_GET['page'].'&delete=2&sh='.$_GET['sh']);//getParams si ya des erreur c'est gerré via checkParams dans config.php

}

