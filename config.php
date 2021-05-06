<?php
$db_host = "localhost";
$db_name = "bulb";
$db_user = "root";
$db_pass = "password123";
$host_name = "http://xill.tk";

$db_table_user = "users";
$db_table_histo = "historique";
$disconnected = false;
$lang_names = array('Fr', 'En');
$lang = 
array( array(
    "Langue", "Utilisateur", "Mot de passe", "Ampoule", "Bienvenue", "Envoyer", "Ajouter", "Supprimer", "Mettre à Jour", "Mise à jour réussi !", "Nom d'Utilisateur Ou Mot De Passe inccorect", 
    "Vous-vous êtes déconnecté avec success", "Se déconnecter !", "Langue Française", "Vous n'êtes pas connecté !", "Liste des utilisateurs", "Vous êtes dans l'espace de gestion des utilisateurs",
    "Historique", "Nom d'utilisateur", "Mot de passe", "Ajouter un utilisateur", "Modifier", "Êtes vous sûr de vouloir modifier ?", "Êtes-sûr de vouloir supprimer ?", "Êtes-sûr de vouloir ajouter ?",
    "supprimé avec success !", "ajouté avec success !", "modifié avec success !", "Espace client", "Gestion des ampoules", "Gestions des utilisateurs", "Changement d'ampouple", "Etage", "Prix", "Coté Gauche",
    "Coté droit", "Fond", "Ajouter un changement d'ampoule", "Elements par page", "Page suivante", "Page précédente"
), array(
    "Language", "User", "Password", "Lightbulb", "Welcome", "Send", "Add", "Delete", "Update", "Updated successfully !", "Username Or password Incorrect",
    "You successfully disconnected.", "Disconnect !", "English Language", "You are not Connected !", "Users list", "You are in the user management area", "History", "Username",
    "Password", "Add a user", "Modify", "Are you sure you want to modify ?", "Are you sure you want to delete ?", "Are you sure you want to add ?", "sucessfully deleted !", "successfully added !", "successfully updated !",
    "Client area", "Lightbulbs management", "User Management", "Bulb entry", "Floor", "Price", "Left side", "Right side", "Bottom", "Add a Lightbulb change", "Elements per page",
    "Next page", "Previous page"
)
);
session_start();
if(isset($_GET["disconnect"])){
    if($_GET["disconnect"] == "1"){
        unset($_SESSION["user"]);
                //echo "Utilisateur déconnecté !";
        $disconnected = true;
    }
}
if(isset($_GET["lang"]))
{
    $_SESSION["lang"] = $_GET["lang"];
}
else if(!isset($_SESSION["lang"])){
    $_SESSION["lang"] = 0;
}
if(isset($_GET['sh'])){
    $nb_elements =  intval($_GET["sh"]); 
 }
 else{
     $nb_elements = 20;//nombre d'elements à afficher
 }
if(isset($_SESSION['user'])){
    $x = $_SESSION['lang'] == "1"? "0" : "1";
    //echo '<meta http-equiv="refresh" content="durée;URL=adresse-de-destination">';
    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }
    else{
        $page = 0;
    }
    echo "<nav>";
    echo "<div id='bienvenue'>" . $lang[$_SESSION['lang']][4] ." <strong>" . ucfirst($_SESSION['user']) . "</strong> ! </div>";
    echo '<a href="?disconnect=1">' . $lang[$_SESSION["lang"]][12] .'</a>';
    echo '<a href="?lang='.$x.'&sh='.$nb_elements.'&page='.$page.'">' . $lang[$_SESSION["lang"]][13] .' </a>';
}
else{
    if($_SERVER["SCRIPT_NAME"] != "/bulb/index.php"){
        if(!$disconnected){
            header('Location: redirection.php?err="'.$lang[$_SESSION["lang"]][14].'"');      
            exit();      
        }
        else{
            header('Location: redirection.php?err="'.$lang[$_SESSION["lang"]][11].'"');      
            exit();
        }
    }
}