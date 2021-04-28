<?php
    require('config.php');
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
                            echo "connexion réussi !";
                            //redirection vers client.php
                            echo '<meta http-equiv="refresh" content="3;URL=client.php">';
                        }
                        else{
                            echo "mot de passe ou nom d'utilisateur incorrect !";
                        }
                    }

                }
                catch (Exception $e)
                {
                        die('Erreur : ' . $e->getMessage());
                }
            }
            else echo "Erreur mot de passe vide !";
        }
        else echo "Erreur nom d'utilisateur vide !";
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <title>Page D'accueil</title>
    </head>
    <body>
        <?php
        if(isset($_GET["err"]))//existe {
            if(!empty($_GET["err"]))//non vide
            {
                echo "<div id='err'>";
                echo $_GET["err"];
                echo "</div>";
            }
        ?>
        <form action="?" method="post">
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
    </body>
</html>

