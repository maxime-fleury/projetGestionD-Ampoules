<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="general.css" rel="stylesheet" type="text/css">
    <script src="script.js" charset="utf-8" > </script>
    <title>Historique</title>
</head>

<body>
    <?php
   
    require("config.php");
    $nb_elements = 20;//nombre d'elements à afficher
    echo "<br><a href='client.php'>Retour sur la page de gestion des utilisateur</a>";
    echo "<h1>Gestion des ampoules</h1>";
    if(isset($_GET["err"]) && $_GET["err"] != "" ){//si err existe afficher les erreurs
        if($_GET["err"]!="0");
            echo $_GET["err"];
    }   
    if(isset($_GET["delete"]) && $_GET["delete"] != "" ){//si err existe afficher les erreurs
        if($_GET["delete"]=="1")
            echo "<div id='success'>La supprésion s'est déroulée avec success !</div>";
        else{
            echo "<div id='err'>Une erreur s'est produite lors de la suppresion !</div>";
        }
    }
    if(isset($_GET["add"]) && $_GET["add"] != "" ){//si err existe afficher les erreurs
        if($_GET["add"]=="1")
            echo "<div id='success'>L'ajout s'est déroulée avec success !</div>";
        else{
            echo "<div id='err'>Une erreur s'est produite lors de l'ajout !</div>";
        }
    }
    if(isset($_GET["page"]) && $_GET["page"] != "" ){//on teste la page dans tout les cas car on peut afficher la page ET faire d'autres actions !!
        try
        {
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage());
        }
        $page = $_GET["page"];
        $start_from = $page*$nb_elements;//pour afficher $nb_elements element si page = 0 on affiche de 0 ç $nb_elements si page 1 de 30 à 60...

        $t = $conn->query("SELECT * FROM historique ORDER BY id ASC limit {$start_from},".$nb_elements);//tout selection sur historique 
        echo "<table> <tr><th cscope='col' class='id up'>id</th><th class='etage up' scope='col'>Etage</th><th class='prix up' scope='col'>Prix</th><th class='pos up' scope='col'>Position</th><th class='date up' scope='col'>date</th><th></th></tr>";
        $i = 0;
        while ($histo = $t->fetch()) {
            echo "<tr>";
            echo "<td class='id'>{$i}&nbsp;&nbsp;</td>";//Numero d'ampoule !=
            $i++;
            $real_id = $histo['id'];
            echo "<form action='update.php' method='get'>
            <input type='hidden' name='id' value='" . $real_id . "'>
            <input type='hidden' name='page' value='" . $_GET["page"] . "'>
            <td class='etage'><input type='number' name='etage' value='" .$histo["etage"]. "'>&nbsp;&nbsp;</td>
            <td class='prix'><input type='number' name='prix' value='" .$histo["prix"]. "'><span class='money_sign'>€</span></td>
            <td>
            <select name='position' id='pos'>";
            switch ($histo["position"]){
                case 0:
                    echo "<option value='0' selected='selected'>Coté Gauche</option>
                <option value='1'>Coté Droit</option>
                <option value='2'>Fond</option>";
                break;
                case 1:
                    echo "<option value='0'>Coté Gauche</option>
                <option value='1' selected='selected'>Coté Droit</option>
                <option value='2'>Fond</option>";
                break;
                case 2: 
                    echo "<option value='0' >Coté Gauche</option>
                <option value='1'>Coté Droit</option>
                <option value='2'selected='selected'>Fond</option>";
                break;
            }
            echo "</select>";
            echo "</td>";
            $date_val = explode(" ", $histo['date_amp'])[0];
            echo "<td class='date'> <input type='date' name='date' value='{$date_val}'/></td>
            <td class='submit'><input type='submit' class='btnx2' alt='update' value='Modifier' onclick='return confirm(`Êtes vous sûr de vouloir mettre à jour ?`)'>
            </form>
            <form action='delete.php' method='GET'>
            <input type='hidden' name='page' value='{$_GET['page']}'>
            <input type='hidden' name='id' value='{$histo['id']}'><hr>
            <input type='submit' class='btnx2' onclick='return confirm(`Êtes vous sûr de vouloir supprimer ?`)' value='Supprimer'/></td></form></tr>";
        }
        $t = $conn->query("SELECT COUNT(id) AS total FROM historique");
        $row = $t->fetch();
        $total_pages = ceil($row["total"] / $nb_elements);
        $t->closeCursor(); 
        echo "</table>";
        $date = date('Y-m-d');
        echo "<hr> Ajouter un changement d'ampoule
            <table>
            <tr><th scope='col' class='up'>id</th><th scope='col' class='up'>Etage</th><th scope='col' class='up'>Prix</th><th scope='col' class='up'>Position</th><th scope='col' class='up'>date</th><th></th></tr>
            <tr>
            <td>{$i}&nbsp;&nbsp;</td>
            <form action='add.php' method='get'>
                <input type='hidden' name='page' value='{$page}'/>
                <td><input type='number' placeholder='0' value='0' name='etage'/>&nbsp;&nbsp;</td>
                <td><input type='number' placeholder='5' value='5' name='prix'/>€</td>
                <td>
                    <select name='position' id='pos'>
                        <option value='0'>Coté Gauche</option>
                        <option value='1'>Coté Droit</option>
                        <option value='2'>Fond</option>
                    </select>
                </td>
                <td>  <input type='date' name='date' value='{$date}'/></td>
                <td><input type='submit' alt='Ajouter' value='Ajouter' onclick='return confirm(`Êtes vous sûr de vouloir ajouter ?`)'/></td>
            </form>
                </tr>
        </table>";
        $page_int = intval($page);

        if($page_int>0){
            echo "<a href='histo.php?page=".($page_int-1)."'>Page précedente</a>";
        }

        if($total_pages > ($page_int+1))//savoir si on peut afficher le boutton de page suivant comme des fois il n'ya pas de page suivante !
            echo "<a href='histo.php?page=".($page_int+1)."'>Page suivante</a>";
    }

?>
</body>

</html>