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
    <h2>Les commandes</h2>
    <a href="owner.php"><button>Accueil</button></a>


</head>
<hr>
<body>
<br><br>

	<?php
    echo '<table bgcolor="black">
    <tr bgcolor="Gray">
        <th> id commande </th>
        <th> Num tel1 </th>
        <th> Num tel2 </th>
        <th> Date d\'arrivée </th>
        <th> Durée(/jr) </th>
        <th> Lien d\'annonce </th>
    </tr>

    <tr bgcolor="LightGray">';

    $sql = "SELECT * FROM propriete WHERE idproprietaire='$id' ";
    if ($i = $conect->query($sql)) {

        while ($info = $i->fetch_assoc()) {
            $idp = $info['idpropriete'];
            $result = $conect->query("SELECT * FROM command WHERE idpropriete='$idp' ");
            if($result->num_rows > 0 ){//Ramner touts les commandes de chaque annonce.
        while ($cmd =$result->fetch_assoc() ) {
          echo '<td>'.$cmd['idcmd'].'</td>';
          echo '<td>'.$cmd['tel1'].'</td>';
          echo '<td>'.$cmd['tel2'].'</td>';
          echo '<td>'.$cmd['date_depart'].'</td>';
          echo '<td>'.$cmd['duree'].'</td>';
          if (strlen($info['titre']) < 23) {
            echo '<td> <a href="infoannc.php?idpost='.$idp.'">'.$info['titre'].'</a></td>';
          }else{
            echo '<td> <a href="infoannc.php?idpost='.$idp.'">'.substr($info['titre'], 0, 23).'...</a></td>';
          }
          echo '</tr>';
          
        }
    }

        }
        echo '</table>'; //fin table ici apres d'afficher touts les commandes.

    }else {
        echo '<h4>Dzl, erreur d\'affichage!</h4>';
    }
    ?>

</body>
    
</html>

<?php
}
?>