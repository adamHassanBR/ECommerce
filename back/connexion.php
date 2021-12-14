<?php require_once('./classes/Bdd.php'); ?>
<?php require_once('./classes/Session.php'); ?>
<?php require_once('./template/_header.php'); ?>

<?php

 //**************************** Connexion utilisateur établie ****************************//
 
 $error= null;
 if(isset($_POST['ConnexionB'])) 
 {
    $mailconnect = $_POST['mail'];
    $mdpconnect = $_POST['mdp'];

    if($mailconnect !== "" && $mdpconnect !== "")
    {
        $bdd = new Bdd();
        
        $sql = "SELECT * FROM user WHERE email = :mailconnect";
        $user = $bdd->fetch($sql, array(
            ':mailconnect' => $mailconnect
        ));

        if($user && password_verify($mdpconnect, $user['password']))
        {
            $session = new Session();
            $session->set('user', $user);
            // var_dump($_SESSION);
            header('Location: moncompte.php');
        }
        else
        {
            $error="<p class='msgErreure'>Mauvais login ou mot de passe. </p>";
        }
    }
     
 }

$leMailInscription=$_GET['mail'];

 /*************************************************************************************/
?>


<link rel="stylesheet" href="../style/connexions.css"> 
    <title>connexion</title>
</head>
<body>

<form  class="formulaire_connexion" name="Connexion" method="POST">
    <center>
        <?php
        if($error)
        {
            echo $error;
        }
        ?>
        <br>
        <h4> Se Connecter </h4>
        <br>
        <h5> Gestion e-comerce </h5>
        <p>
            -   Gestion des articles
            <br>
            -   Gestion des utilisateurs
        </p>
        <br>
        <input style="width : 200px" class="form-control mr-sm-2" name="mail" type="text" required="required" placeholder="Mail" value="<?php echo $leMailInscription; ?>"/>
        <br>
        <input style="width : 200px" class="form-control mr-sm-2" name="mdp" type="password" required="required" placeholder="Mot de Passe"/>
        <br>
        <input class="btn btn-success" name="ConnexionB" type="submit" value="Se Connecter"/>
        <br>
        <br>
        <a href="inscription.php" class="link-secondary">s'inscrire </a>    
        <br><br>

        
    </center>
</form>
<?php require_once('./template/_footer.php'); ?>
