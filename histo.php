<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="general.css" rel="stylesheet" type="text/css">
    <link href="toastbar.css" rel="stylesheet" type="text/css">
    <script src="script.js" charset="utf-8" > </script>
    <title>Historique</title>
</head>

<body>
    <?php
   
    require("config.php");

    echo "<a href='client.php'>{$lang[$_SESSION['lang']][30]}</a></nav>";
    echo "<h1>{$lang[$_SESSION['lang']][29]}</h1>";
//////////////////////////////////////////TOASTBAR SUCCESS
    if(isset($_GET["delete"]) && $_GET["delete"] != "" ){//si err existe afficher les erreurs
        if($_GET["delete"]=="1")
            echo "<div id='success'>{$lang[$_SESSION['lang']][31]} {$lang[$_SESSION['lang']][25]}</div>";
    }
    if(isset($_GET["add"]) && $_GET["add"] != "" ){//si err existe afficher les erreurs
        if($_GET["add"]=="1")
            echo "<div id='success'>{$lang[$_SESSION['lang']][31]} {$lang[$_SESSION['lang']][26]}</div>";
    }
    if(isset($_GET["update"]) && $_GET["update"] != "" ){//si err existe afficher les erreurs
        if($_GET["update"]=="1")
            echo "<div id='success'>{$lang[$_SESSION['lang']][31]} {$lang[$_SESSION['lang']][27]}</div>";
    }
//////////////////////////////////////////////////
    if(isset($_GET["page"]) && $_GET["page"] != "" ){
        $page = $_GET["page"];
        
    }//on teste la page dans tout les cas car on peut afficher la page ET faire d'autres actions !!
    else{ $page=0;}
        try
        {
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (Exception $e)
        {

        }
        $start_from = $page*$nb_elements;//pour afficher $nb_elements element si page = 0 on affiche de 0 ç $nb_elements si page 1 de 30 à 60...

        $t = $conn->query("SELECT * FROM historique ORDER BY id ASC limit {$start_from},".$nb_elements);//tout selection sur historique 
        echo "<table> <tr><th cscope='col' class='id up'>id</th><th class='etage up' scope='col'>{$lang[$_SESSION['lang']][32]}</th><th class='prix up' scope='col'>{$lang[$_SESSION['lang']][33]}</th><th class='pos up' scope='col'>Position</th><th class='date up' scope='col'>Date</th><th></th></tr>";
        $i = 0;
        while ($histo = $t->fetch()) {
            echo "<tr>";
            echo "<td class='id'>{$i}&nbsp;&nbsp;</td>";//Numero d'ampoule !=
            $i++;
            $real_id = $histo['id'];
            echo "<form action='update.php' method='get'>
            <input type='hidden' name='id' value='" . $real_id . "'>
            <input type='hidden' name='page' value='" . $page . "'>
            <td class='etage'><input type='number' name='etage' value='" .$histo["etage"]. "'>&nbsp;&nbsp;</td>
            <td class='prix'><input type='number' name='prix' value='" .$histo["prix"]. "'><span class='money_sign'>€</span></td>
            <td>
            <select name='position' id='pos'>";
            switch ($histo["position"]){
                case 0:
                    echo "<option value='0' selected='selected'>{$lang[$_SESSION['lang']][34]}</option>
                <option value='1'>{$lang[$_SESSION['lang']][35]}</option>
                <option value='2'>{$lang[$_SESSION['lang']][36]}</option>";
                break;
                case 1:
                    echo "<option value='0'>{$lang[$_SESSION['lang']][34]}</option>
                <option value='1' selected='selected'>{$lang[$_SESSION['lang']][35]}</option>
                <option value='2'>{$lang[$_SESSION['lang']][36]}</option>";
                break;
                case 2: 
                    echo "<option value='0' >{$lang[$_SESSION['lang']][34]}</option>
                <option value='1'>{$lang[$_SESSION['lang']][35]}</option>
                <option value='2'selected='selected'>{$lang[$_SESSION['lang']][36]}</option>";
                break;
            }
            echo "</select>";
            echo "</td>";
            $date_val = explode(" ", $histo['date_amp'])[0];
            echo "<td class='date'> <input type='date' name='date' value='{$date_val}'/></td>
            <td class='submit'><input type='submit' class='btnx2' alt='update' onclick='return confirm(`{$lang[$_SESSION['lang']][22]}`)' value='{$lang[$_SESSION['lang']][21]}'>
            </form>
            <form action='delete.php' method='GET'>
            <input type='hidden' name='page' value='{$page}'>
            <input type='hidden' name='id' value='{$histo['id']}'><hr>
            <input type='submit' class='btnx2' onclick='return confirm(`{$lang[$_SESSION['lang']][23]}`)' value='{$lang[$_SESSION['lang']][7]}'/></td></form></tr>";
        }

        $t = $conn->query("SELECT COUNT(id) AS total FROM historique");
        $row = $t->fetch();
        $total_pages = ceil($row["total"] / $nb_elements);
        $t->closeCursor(); 
        echo "<div class='center'>";
        echo "<form method='get' action='?'> " . $lang[$_SESSION['lang']][38];
        echo ' : <input type="number" name="sh" value="'.$nb_elements.'"/>';
        echo '<input type="submit" value="' . $lang[$_SESSION["lang"]][5] .'"/>';
        echo '</form></div>';
        echo "</table>";
        $date = date('Y-m-d');
        echo "<hr> <h1>{$lang[$_SESSION['lang']][37]}</h1>
            <table>";
            echo "<table> <tr><th cscope='col' class='id up'>id</th><th class='etage up' scope='col'>{$lang[$_SESSION['lang']][32]}</th><th class='prix up' scope='col'>{$lang[$_SESSION['lang']][33]}</th><th class='pos up' scope='col'>Position</th><th class='date up' scope='col'>Date</th><th></th></tr>";
            echo "<tr>
            <td>{$i}&nbsp;&nbsp;</td>
            <form action='add.php' method='get'>
                <input type='hidden' name='page' value='{$page}'/>
                <td><input type='number' placeholder='0' value='0' name='{$lang[$_SESSION['lang']][32]}'/>&nbsp;&nbsp;</td>
                <td><input type='number' placeholder='5' value='5' name='prix'/>€</td>
                <td>
                    <select name='position' id='pos'>
                        <option value='0'>{$lang[$_SESSION['lang']][34]}</option>
                        <option value='1'>{$lang[$_SESSION['lang']][35]}</option>
                        <option value='2'>{$lang[$_SESSION['lang']][36]}</option>
                    </select>
                </td>
                <td>  <input type='date' name='date' value='{$date}'/></td>
                <td><input type='submit' alt='{$lang[$_SESSION['lang']][6]}' value='{$lang[$_SESSION['lang']][6]}' onclick='return confirm(`{$lang[$_SESSION['lang']][24]}`)'/></td>
            </form>
                </tr>
        </table>";
        $page_int = intval($page);
        $sh = "";
        if(isset($_GET["sh"]))
            $sh = "&sh=".$_GET["sh"];
        if($page_int>0){
            echo "<a id='previous' href='histo.php?page=".($page_int-1).$sh."'>{$lang[$_SESSION['lang']][40]}</a>";
        }

        if($total_pages > ($page_int+1))//savoir si on peut afficher le boutton de page suivant comme des fois il n'ya pas de page suivante !
            echo "<a id='next' href='histo.php?page=".($page_int+1).$sh."'>{$lang[$_SESSION['lang']][39]}</a>";
    

?>
</body>

</html>