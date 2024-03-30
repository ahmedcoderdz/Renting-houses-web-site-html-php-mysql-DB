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

if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
    echo '<script>alert("'.$_SESSION['msg'].'");</script>';
    unset($_SESSION['msg']);
}

if (isset($_GET['idpostc'])) {
    $idp = $_GET['idpostc'];

    $select = "SELECT * FROM propriete WHERE idpropriete='$idp' ";
    if ($post = $conect->query($select)) {
        $infopost = $post->fetch_assoc();

?>

<!doctype html>
<html>
    
    <head>
        <title>à louer</title>
        
        <a href="sortir.php"><button>Déconnecter</button></a>
        
        <h1><?php echo $infopost['titre']; ?></h1>
        
        <a href="client.php"><button>Accueil</button></a>
</head>
<hr>
<body>
  
 <table>
     <p>Pour louer saisir votre coordonnées ici:</p>    
     <form action="savecmd.php?idpostc=<?php echo $idp; ?>" method="post">
        
     <label>Date arrivée*</label><input type="date" name="date" placeholder="">
     <br><input type="number" name="tel_1" required placeholder="Votre numéro*">
     <br><input type="number" name="tel_2" placeholder="deuxiéme numéro">
     <br><input type="number" name="duree" placeholder="durée de location(/jour)">
     <br><input type="submit" name = "location" value="Réserver">
     
    </form>
</table>
        <br><br>

    <?php 
    $sqlimg = $conect->query("SELECT * FROM image WHERE idpropriete='$idp' ");
    echo '<table> <tr>';
    $tr = 1;
    while($img = $sqlimg->fetch_assoc()){
        echo '<td><img src="'.$img['img'].'" alt="Post"  height ="400px" width="400px"></td>'; 
    if ($tr >= 3) {//limiter les colonne du tableau
    $tr = 1;
    echo '</tr>';
    }
    $tr++;
}
echo '<table>';
echo '<p>Disponibilité: '.$infopost['cas'].'</p>';
echo '<hr>';
echo '<p>prix: '.$infopost['prix'].' da(/nuit)</p>';
    echo '<p>Type du proprieté: '.$infopost['type'].'</p>';
    echo '<p>Discription: '.$infopost['discription'].'</p>';
    //localisation
    echo '<h4>Localité:</h4>';
    echo '<table><tr>';
    echo '<td>'.$infopost['pay_propriete'].'</td>';
    echo '<td> ,'.$infopost['wilaya_propriete'].'</td>';
    echo '<td> ,'.$infopost['commune_propriete'].'</td>';
    echo '<td> ,N°:'.$infopost['num_propriete'].'</td></tr>';
    echo '</table>';
 ?>
 
</body>
</html>

<?php
}else {
    echo '<h2>Dzl, erreur d\'afficher l\'annonce</h2>';
}

}
}
?>