<?php require_once('./classes/Session.php'); ?>
<?php require_once('./template/_header.php'); ?>
<?php
    $session = new Session();

    if(!$session->get('user'))
    {
        header('Location: connexion.php');
    }
    //var_dump($_SESSION, $session->get('user'));
    $user = $session->get('user');
?>


<link rel="stylesheet" href="../style/moncompte.css"> 
    <title>Mon compte</title>
</head>
<body>
    <div class="container">
        <nav class="nav flex-column">
            <?php require_once('./template/_navbar.php');  ?>
        </nav>
    </div>

<?php require_once('./template/_footer.php'); ?>