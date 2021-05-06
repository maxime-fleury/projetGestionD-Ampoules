<?php
//Ce fichier permet d'afficher un message "redirection en cours" de manière plus propre qu'une simple redirection
//C'est à dire que au lieu d'attendre x secondes comme nous ne somme pas connecté pour aller sur index.php
//Cela pourrai aussi permettre pourquoi pas de logger les abus etc ...
//On ne peut pas écrire du texte avant une redirection instanté via php
$err = "";
if(isset($_GET["err"])){
    $err = $_GET["err"];
    echo "Redirection en cours ! Car " . $err; 
    echo "<meta http-equiv='refresh' content='1;URL=index.php?err=" . $err . "'>";
}
else{
 $err = "ERROR !!!";
 echo "<meta http-equiv='refresh' content='1;URL=index.php?err=" . $err . "'>";
}
