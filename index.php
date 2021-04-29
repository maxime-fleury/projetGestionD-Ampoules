<?php
    require('config.php');
    $err = "<div id='err'>";
    $success = "<div id='success'>";
    $successRedirect = false;
    if(isset($_POST["user"]) && isset($_POST['pass'])){
        if($_POST["user"] != ""){
            if($_POST["pass"] != ""){
                try
                {
                    $user = $_POST["user"];
                    $pass = $_POST["pass"];

                    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                    $t = $conn->query("SELECT login,password, COUNT(login) as succs FROM users WHERE login ='{$user}' AND password = '{$pass}' ");//tout selection sur historique 

                    while ($histo = $t->fetch()) {
                        if($histo['succs'] != 0){
                            $_SESSION['user'] = $histo['login'];//connexion réussi
                            $success .= "Connexion réussi en attente de redirection !</div>";
                            //redirection vers client.php
                            $successRedirect = true;
                        }
                        else{
                            $err .= "Mot de passe ou Nom d'Utilisateur incorrect !<br>";
                        }
                    }

                }
                catch (Exception $e)
                {
                       
                }
            }
            else $err .= "Erreur mot de passe vide !<br>";
        }
        else $err .= "Erreur nom d'utilisateur vide !<br>";
    }


?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="toastbar.css" rel="stylesheet" type="text/css">
        <script src="script.js" charset="utf-8" > </script>
        <title>Page D'accueil</title>
    </head>
    <body>
    <?php
    if(!$successRedirect){//Pas connecté !
        if(isset($_GET["err"]))//existe {
            if(!empty($_GET["err"]))//non vide
            {
                $err .= $_GET["err"];
        }
        $err.= "</div>";
        if(strcmp($err, "<div id='err'><div>") !== 0)
            echo $err;
        ?>
        <form action="?" method="post" autocomplete="off">
            <div id="login_container">
                <div id="input_container">
                    <label for="user">Utilisateur : </label>
                    <input type="text" name="user" placeholder="Utilisateur">
                    <label for="pass">Mot de passe : </label>
                    <input type="password" placeholder="************" name="pass">
                </div>
                <input type="submit">
            </div>
        </form>
        <?php 
        }
        else  
        {      
            echo $success;
            echo '<meta http-equiv="refresh" content="3;URL=client.php">';
        }?>
    </body>
</html>

