<?php
    if(isset($_SESSION['user'])){
        //echo '<meta http-equiv="refresh" content="durée;URL=adresse-de-destination">';
       
    }
    else{
       
    }
require("config.php");
try
{
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

if(!checkParams("etage,prix,position,date")){
    $etage = $_GET["etage"];
    $prix = $_GET["prix"];
    $pos = $_GET["position"];
    $date_a = $_GET["date"];
    $statement = "INSERT INTO historique VALUES (NULL, '{$etage}', '{$prix}', '{$pos}',  '{$date_a}')";
    $h = $conn->exec($statement);
}

function checkParams($list){ //verifie chaque parametre existe
    $res = false; //false = tout les parametre sont valide
    $l = explode(",", $list);//coupe la liste en un tableau
    foreach($l as $k )//pour chaque parametre 
    {
        if(isset($_GET[$k]))//existe
        {
            if($_GET[$k] == "")//parametre vide
            {
                $res = true;
            }
        }
        else // n'existe pas
        {
            $res = true;
        }
        return $res;
    }
}

header('Location: histo.php?page='.$_GET['page'].'&add=1');//getParams si ya des erreur c'est gerré via checkParams dans config.php
exit();