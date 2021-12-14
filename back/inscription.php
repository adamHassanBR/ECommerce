<?php require_once('./classes/Bdd.php'); ?>

<?php require_once('./template/_header.php'); ?>
<link rel="stylesheet" href="../style/inscriptions.css"> 
    <title>Incription</title>
</head>
<body>
    <form action="inscription.php" class="formulaire_inscription" method="POST">
        
        <h4> Crée votre compte </h4>
        <br>
        <br>
        <center>
            <table>
                <tr>
                    <td> <input style="width : 200px" class="form-control mr-sm-2" name="nom" type="text" required="required" placeholder="Votre nom"/></td>
                    <td> <input style="width : 200px" class="form-control mr-sm-2" name="prenom" type="text" required="required" placeholder="Votre prénom"/></td>
                </tr>

            </table>
            <br>
            <input style="width : 400px" class="form-control mr-sm-2" name="mail" type="email" required="required" placeholder="Mail"/>
            <br>
            <input style="width : 400px" class="form-control mr-sm-2" name="mdp" type="password" required="required" placeholder="Mot De Passe"/>
        </center>
        <br>
        <input class="btn btn-outline-success" name="CreerCompte" type="submit" value="S'inscrire"/>
        <br>
        <br>
        <a href="connexion.php" class="link-secondary">se connecter </a>     
    </form>    

<?php require_once('./template/_footer.php'); ?>

<?php

$CreerCompte = $_POST['CreerCompte'];
if(isset($CreerCompte))
{
    $nom    = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail   = $_POST['mail'];
    $mdp    = $_POST['mdp'];
    
    if($mail !== "" && $mdp !== "" && $nom !== "" && $prenom !== "")
    {
        $sql = "INSERT INTO user (email, password, name_user, fName_user) VALUES (:mail, :mdp, :nom, :prenom);";
        $bdd = new Bdd();
        $bdd->execute($sql, array(
            ':mail'    => $mail,
            ':mdp'     => password_hash($mdp, PASSWORD_BCRYPT),
            ':nom'     => $nom,
            ':prenom'  => $prenom
        ));
        header("Location: connexion.php?mail=$mail");
    }
}
?>