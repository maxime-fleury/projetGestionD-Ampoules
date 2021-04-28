<?php
    require('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace client</title>
</head>
<body>
    <br>
    <h1>Vous dans dans l'espace de gestion</h1>
    <a href="histo.php?page=0">Historique</a><br>
    <h3>Liste des utilisateurs</h3>
    <table id="list">
        <tr>
            <td>Id</td><td>Nom d'utilisateur</td><td>Mot de passe</td><td>Email</td>
        </tr>
        <?php
            try
            {
                $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
            catch (Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
            if(isset($_GET["action"])){
                if(($_GET["action"] == "delete") && isset($_GET["id"])){
                    if($_GET['id'] != ""){
                        $id = $_GET['id'];
                         $statement = "DELETE FROM users WHERE id = '" . $id . "'";
                         $h = $conn->exec($statement);
                         echo "Utilisateur supprimé !";
                    }
                }
                if(($_GET['action'] == 'add') && isset($_GET["user"]) && isset($_GET["email"]) && isset($_GET["pass"])){
                    $statement = "INSERT INTO users VALUES (NULL, '{$_GET['user']}', '{$_GET['pass']}', '1',  '{$_GET['email']}')";
                    $h = $conn->exec($statement);
                    echo "Utilisateur ajouté !";
                }
                if(($_GET['action'] == 'edit') && isset($_GET["login"]) && isset($_GET["email"]) && isset($_GET["pass"])){
                    $id = $_GET['id'];
                    $pass = $_GET['pass'];
                    $email = $_GET['email'];
                    $login = $_GET['login']; 
                    $statement = "UPDATE users SET login = '{$login}', password = '{$pass}',  email = '{$email}' WHERE id = '{$id}'";
                    $h = $conn->exec($statement);
                    echo "Utilisateur modifié !";
                }
            }
            $t = $conn->query("SELECT * FROM users ORDER BY id ASC");
            while ($users = $t->fetch()) {
                echo "<tr><form action='?' method='GET'>";
                    echo "<input type='hidden' name='action' value='edit'/>";
                    echo "<input type='hidden' name='id' value='{$users['id']}'/>";
                    echo "<td>{$users['id']}</td>";
                    echo "<td><input type='text' value='{$users['login']}' name='login'/></td>";
                    echo "<td><input type='text' value='{$users['password']}' name='pass'/></td>";
                    echo "<td><input type='text' value='{$users['email']}' name='email'/></td>";
                    echo "<td><input type='submit' onclick='return confirm(`Êtes vous sûr de vouloir modifier ?`)' value='Modifier'/></td></form>";
                    echo "<td><a onclick='return confirm(`Êtes vous sûr de vouloir supprimer ?`)' href='?action=delete&id={$users['id']}'><button>Supprimer</button></a></td>";
                echo "</tr>";
            }
        ?>
    </table>
    <h3>Ajout d'un utilisateur</h3>
    <form action="?" method="GET">
        <input type="hidden" name="action" value='add'/>
        <input type="text" placeholder="Utilisateur" value="Utilisateur" name="user"/>
        <input type="text" placeholder="Mot de passe" name="pass"/>
        <input type="email" placeholder="admin@gmail.com" name="email"/>
        <input type="submit" onclick="return confirm('Êtes vous sûr de vouloir créer cette utilisateur ?')"/>
    </form>

</body>
</html>