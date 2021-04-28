<?php
$db_host = "localhost";
$db_name = "bulb";//nom base de donné
$db_user = "";//utilisateur
$db_pass = "";//mot de passe
$host_name = "hote";//

$db_table_user = "users";
$db_table_histo = "historique";
$disconnected = false;
session_start();
if(isset($_GET["disconnect"])){
    if($_GET["disconnect"] == "1"){
        unset($_SESSION["user"]);
        echo "Utilisateur déconnecté !";
        $disconnected = true;
    }
}
if(isset($_SESSION['user'])){
    //echo '<meta http-equiv="refresh" content="durée;URL=adresse-de-destination">';
    echo "Bienvenue " . $_SESSION['user'] . " ! ";
    echo '<a href="?disconnect=1">Se déconnecter !</a><br>';
}
else{
    if($_SERVER["SCRIPT_NAME"] != "/bulb/index.php"){
        if(!$disconnected){
            echo '<meta http-equiv="refresh" content="1;URL=index.php?err=`Vous n\'êtes pas connecté !`">';
        }
        else{
            echo '<meta http-equiv="refresh" content="1;URL=index.php?err=`Vous-vous êtes bien déconnecté !`">';
        }
    }
}