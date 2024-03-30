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
        
        <h1>Historique de location</h1>
        
        <a href="client.php"><button>Accueil</button></a>
</head>
<hr>
<body>
  
<?php
$sql = $conect->query("SELECT * FROM command WHERE id_l='$id' ");
while ($cmd = $sql->fetch_assoc()) {
    $idannc = $cmd['idpropriete'];
    $annc = $conect->query("SELECT * FROM propriete WHERE idpropriete='$idannc' ");//besoin au lien d'annonce
    $post = $annc->fetch_assoc();

    echo '<table><tr bgcolor="LightGray"><td>
        <p>Id commande: '.$cmd['idcmd'].'</p>
        <p>Prix: '.$post['prix'].' DA(/nuit)</p>
        <p>Date arrivée: '.$cmd['date_depart'].'</p>
        <p>Numéro de téléphone: '.$cmd['tel1'].' - '.$cmd['tel2'].'</p>';
        if (strlen($post['titre']) <= 23) {
            echo '<p>Lien d\'annonce: <a href="clientannc.php?idpostc='.$post['idpropriete'].'">'.$post['titre'].'</a></p>';
        }else {
            echo '<p>Lien d\'annonce: <a href="clientannc.php?idpostc='.$post['idpropriete'].'">'.substr($post['titre'], 0, 23).'...</a></p>';
        }
        echo '</td></tr></table><hr>';
        
}

 ?>
</body>
</html>

<?php
}
?>