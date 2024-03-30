<?php
session_start();

include("connexion.php");//Connect base des données.

if (isset($_SESSION['$a'])) {
    echo '<script>alert("Connetez vous d\'abord, svp");</script>';
    session_destroy();
 } //mdrtch else psQ rani baghih exucuté touts.

if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
    echo '<script>alert("'.$_SESSION['msg'].'");</script>';
    unset($_SESSION['msg']);
}

if (isset($_POST['submit'])){

    $_SESSION['email'] = $_POST['email']; 
    $_SESSION['password'] = $_POST['mdp'];

    $email = $_POST['email'];
    $password = $_POST['mdp'];

    if (isset($_POST['genre'])) {

       if ($_POST['genre'] == "Locataire") {
        $sql_client = "SELECT * FROM locataire WHERE email_l = '$email' AND mdp_l = '$password' ";
        $result_client = $conect->query($sql_client);
        
        if ($result_client->num_rows  > 0){
            header('location: client.php');
            
        }else{
            $_SESSION['msg'] = "Les coordonnées sont incorrect.";
        }
    }elseif ($_POST['genre'] == "Proprietaire") {
        $sql = "SELECT * FROM proprietaires WHERE email_p = '$email' AND mdp_p = '$password' ";
        $result = $conect->query($sql);
        
        if ($result->num_rows  > 0){
            header('location: owner.php');
            
        }else{
            $_SESSION['msg'] = "Les coordonnées sont incorrect.";
        }
    }

    }
}
?>

<!DOCTYPE html>
<html>

    <body>
        <form action="login.php" method="post">
                <input type="radio" value="Locataire" name="genre">Locataire
                <input type="radio" value="Proprietaire" name="genre">Propriétaire
            <br>
            <input class="mdf" name="email" type="email" required placeholder="Email*">
            <br>
            <input class="mdf" name="mdp" type="password" required placeholder="Mot de passe*">
            <br> <br>
            <input id="sub" type="submit" name="submit" value=" Se connecter ">
            <p><a href="sign.php">Créer un nouveau compte</a></p>
        </form>
        <style>

            .copy{font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                display: flex;
                justify-content: end;
                text-align:end;
            }
            </style>
        <p class="copy">&copy;ABDESSAMED_AHMED</p>
    </body>
</html>