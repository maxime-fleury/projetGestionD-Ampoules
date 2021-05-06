<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="general.css" rel="stylesheet" type="text/css">
    <script src="script.js" charset="utf-8" > </script>
    <link href="toastbar.css" rel="stylesheet" type="text/css">
    <title>Client</title>
</head>
<body>
<?php
    require('config.php');
    ?>
    <a href="histo.php?page=0"><?php echo $lang[$_SESSION['lang']][17]; ?></a></nav>
    <h1><?php echo $lang[$_SESSION['lang']][16]; ?></h1>
    <h3><?php echo $lang[$_SESSION['lang']][15]; ?></h3>
    <table id="list">
        <tr>
            <th class='up'>Id</th><th class='up'><?php echo $lang[$_SESSION['lang']][18]; ?></th><th class='up'><?php echo $lang[$_SESSION['lang']][19]; ?></th><th class='up'>Email</th><th class='up'></th><th class='up'></th>
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
                         echo "<div id='success'>" . $lang[$_SESSION['lang']][1] . " " . $lang[$_SESSION['lang']][25] . "</div>";
                    }
                }
                if(($_GET['action'] == 'add') && isset($_GET["user"]) && isset($_GET["email"]) && isset($_GET["pass"])){
                    $statement = "INSERT INTO users VALUES (NULL, '{$_GET['user']}', '{$_GET['pass']}', '1',  '{$_GET['email']}')";
                    $h = $conn->exec($statement);
                    echo "<div id='success'>" . $lang[$_SESSION['lang']][1] . " " . $lang[$_SESSION['lang']][26] . "</div>";
                }
                if(($_GET['action'] == 'edit') && isset($_GET["login"]) && isset($_GET["email"]) && isset($_GET["pass"])){
                    $id = $_GET['id'];
                    $pass = $_GET['pass'];
                    $email = $_GET['email'];
                    $login = $_GET['login']; 
                    $statement = "UPDATE users SET login = '{$login}', password = '{$pass}',  email = '{$email}' WHERE id = '{$id}'";
                    $h = $conn->exec($statement);
                    echo "<div id='success'>" . $lang[$_SESSION['lang']][1] . " " . $lang[$_SESSION['lang']][27] ."</div>";
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
                    echo "<td><input type='submit' onclick='return confirm(`{$lang[$_SESSION['lang']][22]}`)' value='{$lang[$_SESSION['lang']][21]}'/></td></form>";
                    echo "<td><a onclick='return confirm(`{$lang[$_SESSION['lang']][23]}`)' href='?action=delete&id={$users['id']}'><button>{$lang[$_SESSION['lang']][7]}</button></a></td>";
                echo "</tr>";
            }
        ?>
    </table>
    <h3><?php echo $lang[$_SESSION['lang']][20]; ?></h3>
    <table>
    <form action="?" method="GET">
        <input type="hidden" name="action" value='add'/><tr>
        <td class='green'><input type="text" placeholder="<?php echo $lang[$_SESSION['lang']][1]; ?>" value="<?php echo $lang[$_SESSION['lang']][1]; ?>" name="user"/></td>
        <td class='green'><input type="text" placeholder="<?php echo $lang[$_SESSION['lang']][19]; ?>" name="pass"/></td>
        <td class='green'><input type="email" placeholder="admin@gmail.com" name="email"/></td>
        <td class='green'><input type="submit" value='<?php echo $lang[$_SESSION['lang']][6];?>' onclick="return confirm('<?php echo $lang[$_SESSION['lang']][24]; ?>')"/></td>
        </tr>
    </form>
   </table>
</body>
</html>