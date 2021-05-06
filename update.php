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
    if(isset($_GET['etage']) && $_GET['etage'] != ""){
        if(isset($_GET['prix']) && $_GET['prix'] != ""){
            if(isset($_GET['position']) && $_GET['position'] != ""){
                if(isset($_GET['date']) && $_GET['date'] != ""){
                    $etage = $_GET["etage"];
                    $prix = $_GET["prix"];
                    $pos = $_GET["position"];
                    $date = $_GET["date"];

                   $statement = "UPDATE {$db_table_histo} SET etage = '{$etage}', position = '{$pos}', prix = '{$prix}', date_amp = '{$date}' WHERE id = '{$_GET['id']}'";
                   $h = $conn->exec($statement);
                }
                else echo "Erreur date innexistante ou invalide <br>";
            }
            else echo "Erreur position innexistante ou invalide <br>";
        }
        else echo "Erreur prix innexistant ou invalide <br>";
    }
    else echo "Erreur etage innexistant ou invalide <br>";
}
header('Location: histo.php?page=' . $_GET["page"] . '&update=1&sh='.$_GET['sh']);//getParams si ya des erreur c'est gerré via checkParams dans config.php
exit();
