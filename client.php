<?php
    session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) { //pour sucurisé, il faut s'inscrir pour entre à cette page.
    $a = 1;
    $_SESSION['$a']=$a;
    header('location: login.php');
}else {
    
include("connexion.php"); //connecté avec base des données.
$email = $_SESSION['email'];

$r = $conect->query("SELECT id_l, pre_l, nom_l FROM locataire WHERE email_l='$email'");
$id = $r->fetch_assoc();
$_SESSION['$id'] = $id['id_l']; //pour garder id.
$noml = $id['nom_l'];
$prel  = $id['pre_l'];
?>

<!doctype html>
<html>

<head>
	<title>à louer</title>
    <a href="sortir.php"><button>Déconnecter</button></a>
    <h1>Page d'accueil</h1>

    <h3><?php echo 'Bienvenue '.$noml.' '.$prel; ?></h3>
    <h3>Bénificier des bons occasions avec nous!</h3>

    <a href="historiq.php" name="cmd">Historique</a>
</head>
<hr>
<body>
<br><br>
	<?php
    $result = $conect->query("SELECT * FROM propriete ");
    if($result->num_rows > 0 ){
        echo '<table> <tr bgcolor="LightGray">';
        $tr = 0;
        while ($annc = $result->fetch_assoc()) {

            $idp = $annc['idpropriete'];
            $img = $conect->query("SELECT * FROM image WHERE idpropriete='$idp' ");
            $imag = $img->fetch_assoc();
            echo '<td><a href="clientannc.php?idpostc='.$idp.'"><img src="'.$imag['img'].'" alt="Post" height ="250px" width="250px"></a>'; //ndirha fi <a>..
            if (strlen($annc['titre']) <= 23 ) { //pour ... aprés titre
            echo '<a href="clientannc.php?idpostc='.$idp.'"><p>'.$annc['titre'].'</p></a>';//ndirah fi <a> + nzidah limit caractére
            }else {
            echo '<a href="clientannc.php?idpostc='.$idp.'"><p>'.substr($annc['titre'],0,23).'...</p></a>';//ndirah fi <a> + nzidah limit caractére
            }
            echo '<p>'.$annc['cas'].'</p>';
            echo '<p>'.$annc['prix'].' da(/nuit)</p>';
            echo '<a href="clientannc.php?idpostc='.$idp.'"><button>Réserver</button></a></td>';
            if ($tr >= 2) {
                $tr = 0;
                echo '</tr>';
            }
         $tr ++;   
        }
            
      
    }else{
        echo "Aucun annonce!";
    }
    ?>
	
</body>
    
</html>

<?php } ?>