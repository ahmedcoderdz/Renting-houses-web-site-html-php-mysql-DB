<?php
    session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) { //pour sucurisé, il faut s'inscrir pour entre à cette page.
    $a = 1;
    $_SESSION['$a']=$a;
    header('location: login.php');
}else {
    
include("connexion.php"); //connecté avec base des données.
$email = $_SESSION['email'];
$id = $_SESSION['$id'];


?>

<!doctype html>
<html>

<head>
	<title>à louer</title>
    <a href="sortir.php"><button>Déconnecter</button></a>

    <h1>Tableau de bord</h1>
    <h2>Les annonces</h2>
    <a href="owner.php"><button>Accueil</button></a>

</head>
<hr>
<body>
<br><br>
 <a href="add.php"><button>Nouvelle annonce</button></a>
<br><br>
<?php

$sql = "SELECT * FROM propriete WHERE idproprietaire='$id' ";
if ($i = $conect->query($sql)) {
    if ($i->num_rows > 0) {
        echo '<table> <tr bgcolor="LightGray">';
        $j = 1; //counteur pour table <tr>
        while ($annc = $i->fetch_assoc()) {
            echo '<td>';
            $idannc = $annc['idpropriete'];
            $sqlimg = $conect->query("SELECT * FROM image WHERE idpropriete='$idannc' ");
            
            if ($sqlimg->num_rows > 0) {//ramner l'image d'annonce
                $img = $sqlimg->fetch_assoc();
                echo '<a href="infoannc.php?idpost='.$idannc.'"><img src="'.$img['img'].'" alt="Post" height ="250px" width="250px"></a>'; //ndirha fi <a>..
                if (strlen($annc['titre']) <= 23 ) { //pour (...) aprés titre
                    echo '<a href="infoannc.php?idpost='.$idannc.'"><p>'.$annc['titre'].'</p></a>';//ndirah fi <a> + nzidah limit caractére
                }else {
                    echo '<a href="infoannc.php?idpost='.$idannc.'"><p>'.substr($annc['titre'],0,23).'...</p></a>';//ndirah fi <a> + nzidah limit caractére
                }
                echo '<p>'.$annc['prix'].'da(/nuit)</p>';
                $countsql = $conect->query("SELECT COUNT(*) FROM command WHERE idpropriete='$idannc' ");//nbr des commands
                $count = $countsql->fetch_assoc();
                echo '<h6>'.$count['COUNT(*)'].' Cmnd(s)</h6>'; 
                ?>
                <a href="editannc.php?idpost=<?php echo $idannc; ?>"><button>Modifier</button></a>
                <a href="deletannc.php?idpost=<?php echo $idannc; ?>"><button>Supprimer</button></a>

                <?php
                //button modifier , button supprumé(nzid confimation du suprission)
            }
            echo '</td>';
            
            if ($j >= 3) { //pour limiter nbr des colonne.
                echo '</tr>';
                $j = 1;
            }
            $j++;

        }
        echo '</table>';//fin table aprés ramner touts les annonce

    } else {
        echo '<h4>Aucun annonce!</h4>';
    }
    
}else {
    echo '<h4>Dzl, erreur d\'affichage!</h4>';
}

?>

</body>
</html>

<?php
}
?>