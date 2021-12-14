<?php require_once('./classes/Bdd.php'); ?>
<?php require_once('./classes/Session.php'); ?>
<?php require_once('./template/_header.php'); ?>
<?php

    $session = new Session();

    if(!$session->get('user'))
    {
        header('Location connexion.php');
    }

    // var_dump($_SESSION, $session->get('user'));
    $user = $session->get('user');

    $bdd = new Bdd();
 
/*****************************************************************************Traitement du filtrage et de la recherche*****************************************************************************/
$sql = "SELECT * FROM product";
    $Vfiltre = $_POST['FiltreB'];
    if($Vfiltre)
    {
        $categorieF = $_POST['categorieF'];
        $marqueF = $_POST['marqueF'];

        if(($marqueF == "all")&&($categorieF == "all"))
        {
            $sql= "SELECT * FROM product";
        }
        else if($marqueF == "all")
        {
            $sql = "SELECT * FROM product WHERE id_cat='$categorieF'";
        }
        else if($categorieF == "all")
        {
            $sql = "SELECT * FROM product WHERE id_marque ='$marqueF'";
        }
        else
        {
            
            $sql = "SELECT * FROM product WHERE id_cat='$categorieF' AND id_marque ='$marqueF'";
        }
    }

    $VRecherche = $_POST['RechercheB'];
    
    if($VRecherche)
    {
        $Larecherche = $_POST['Recherche'];
        if($Larecherche == NULL)
        {
            $sql = "SELECT * FROM product";
        }                  
        else
        {
            $sql = "SELECT * FROM product WHERE des_prod LIKE '%$Larecherche%' OR price LIKE '%$Larecherche%'";
        }
    }
/***************************************************************************************************************************************************************************************/
/*****************************************************************************Traitement de la Modification*****************************************************************************/

////////// recuperation des datas à modifier//////////
             
$ValidformulaireModif = $_POST['ValidformulaireModif'];
if ($ValidformulaireModif)
{ 
    $id_product = $_POST['id_product'];
    $des_prod = $_POST['des_prod'];
    $price = $_POST['price'];
    $nomPhoto = $_POST['nomPhoto'];
    $id_cat = $_POST['categorieModif'];
    $id_marque = $_POST['marqueModif'];

    $info = pathinfo($_FILES['userFile']['name']);
    //$ext = $info['extension'];
    //$newname = $info['basename']; 
    //$target = '../image/'.$nomPhoto;
    $targets = '../api/images/'.$nomPhoto;

    //var_dump($info);
    //move_uploaded_file( $_FILES['userFile']['tmp_name'], $target);
    move_uploaded_file( $_FILES['userFile']['tmp_name'], $targets);
    $sql4 = "UPDATE product SET des_prod = :des_prod , price = :price , id_cat = :id_cat , id_marque = :id_marque WHERE id_product = :id_product";

    $bdd->execute($sql4, array(
        ':des_prod'     => $des_prod,
        ':price'        => $price,
        ':id_cat'       => $id_cat,
        ':id_marque'    => $id_marque,
        ':id_product'   => $id_product
    ));
                                    
}
///////////////////////////////////////////////////////////////////////////////////////

////////// Recuperation des donnée saisie//////////
                    
$Valider = $_POST['buttonValideradd']; // recupere la valeur envoyer par le formulaire
if($Valider)
{
    $priceadd = $_POST['priceadd'];
    $des_prodadd = $_POST['des_prodadd'];
    $categorieAdd = $_POST['categorieAdd'];
    $marqueADD = $_POST['marqueADD'];
    $userFileadd = $_POST['userFileadd'];


    $infoo = pathinfo($_FILES['userFileadd']['name']);
    $newnameP = $infoo['basename'];
    //$target = '../image/'.$newnameP;
    $targets = '../api/images/'.$newnameP;
    
    //var_dump($infoo);
    //move_uploaded_file( $_FILES['userFileadd']['tmp_name'], $target);
    move_uploaded_file( $_FILES['userFileadd']['tmp_name'], $targets);
    $sql5 = "INSERT INTO product (des_prod, price, picture, id_cat, id_marque) VALUES (:des_prodadd, :priceadd, :newnameP, :categorieAdd, :marqueADD)";                              
    
    $bdd->execute($sql5, array(
        ':des_prodadd'      => $des_prodadd,
        ':priceadd'         => $priceadd,
        ':newnameP'         => $newnameP,
        ':categorieAdd'     => $categorieAdd,
        ':marqueADD'        => $marqueADD
    ));
}

///////////////////////////////////////////////////////////////////////////////////////
    
    $products = $bdd->fetchAll($sql);
    //var_dump($products);
?>


<link rel="stylesheet" href="../style/produit.css"> 
    <title>Produit</title>
</head>
<body>
    <nav class="nav flex-column">
        <?php require_once('./template/_navbar.php');  ?>
    </nav>
    <main>
        <h1> liste des produits </h1>
        <br>
        <center>        
            <div class="row align-items-center">            
                <form class="col Filtretab" id="Filtretab" name="Filtretab" method="post">
                    <div class="row align-items-center">
                        <div class="col-4"></div>
                        <div class="col-md-auto">
                            <select style="width: 150px" class="form-control form-control-sm" name="categorieF" id="categorieF">
                                <option value="all">catégories</option>
                                <?php
                                    $sql10= "SELECT * FROM categorie";
                                    $catselect = $bdd->fetchAll($sql10);
                                    foreach($catselect as $catsel)
                                    {
                                        ?>
                                                <option value="<?php echo $catsel['id_cat']; ?>"> <?php echo $catsel['des_cat']; ?></option>
                                        <?php
                                    }
                                        ?>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <select style="width: 150px" class="form-control form-control-sm" name="marqueF" id="marqueF">
                                <option value="all">Marque</option>
                                <?php
                                    $sql11= "SELECT * FROM marque";
                                    $marqueselect = $bdd->fetchAll($sql11);
                                    foreach($marqueselect as $marquesel)
                                    {
                                        ?>
                                                <option value="<?php echo $marquesel['id_marque']; ?>"> <?php echo $marquesel['nom_marque']; ?></option>
                                        <?php
                                    }
                                        ?>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <input class="btn btn-info" name="FiltreB" type="submit" value="Filtrer" />
                        </div>
                    </div>
                </form>
                <form class="col" id="Recherche" name="Recherche" method="post">
                    <div class="row">
                        <div class="col-3">

                        </div>
                        <div class="col-md-auto">
                            <input style="width: 150px" class="form-control mr-sm-2" name="Recherche" type="search" placeholder="recherche..."/>
                        </div>
                        <div class="col-md-auto">
                            <input class="btn btn-outline-secondary" name="RechercheB" type="submit" value="Recherche" />
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="scroling">
                <table class="afficheTab">
                    <tr>
                        <th>id</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    <tbody>
                        <?php 
                            $X=0;
                            foreach($products as $product)
                            {
                                $tableauId[$X] = $product['id_product'];  //Tableau qui repertorie les IDs
                                $tableauIdM[$X] = $product['id_product'];  //Tableau qui repertorie les IDs
                                $tableaunom[$X] = $product['des_prod'];
                                ?>
                                    <tr>
                                        <td class="userTableau">
                                            <?php echo $product['id_product']; ?>
                                        </td>
                                        <td class="userTableau">
                                            <?php echo $product['des_prod']; ?>
                                        </td>
                                        <td class="userTableau">
                                            <?php echo $product['price']; ?> €
                                        </td>
                                        <td class="userTableau">
                                            <form id="Modifier" name="Modifier" method="POST">
                                                <input class="btn btn-outline-info" name="<?= $tableauIdM[$X] ?>" type="submit" value="Modifier" />
                                            </form>
                                        </td>
                                        <td class="userTableau">
                                            <form id="Supprimer" name="Supprimer" method="POST">
                                                <input class="btn btn-outline-danger"  name="<?= $tableauId[$X] ?>" type="submit" value="Supprimer" />
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                $X++;
                            }
                        ?>    
                    </tbody>
                </table>
            </div>
        </center>
        <br>

        <button  class="button_ajout btn btn-primary" name="buttonAjout" type="button"  data-toggle="modal" data-target="#ModalAdd">
            Ajouter un produit
        </button>

        <div class="modal fade" id="ModalAdd">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalAddLabel">Ajouter un produit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formAdd" name="formAdd" method="post" enctype='multipart/form-data'> 
                        <div class="modal-body">
                            <div class="row">
                                <input class="form-control form-control-sm" style="padding:20px;" type="file" name="userFileadd" id="userFileadd">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <small id="emailHelp" class="form-text text-muted">Nom du produit</small>
                                    <input class="form-control" name="des_prodadd" type="text"/>
                                </div>
                                <div class="col">
                                    <small id="emailHelp" class="form-text text-muted">Prix du produit</small>
                                    <input class="form-control" name="priceadd" type="text"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <small id="emailHelp" class="form-text text-muted">catégorie</small>
                                    <select class="form-control form-control-sm" name="categorieAdd" id="categorieAdd">
                                        <?php
                                            $sql6= "SELECT * FROM categorie";
                                            $catselect = $bdd->fetchAll($sql6);
                                            foreach($catselect as $catsel)
                                            {
                                                ?>
                                                        <option value="<?php echo $catsel['id_cat']; ?>"> <?php echo $catsel['des_cat']; ?></option>
                                                <?php
                                            }
                                                ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <small id="emailHelp" class="form-text text-muted">Marque</small>
                                    <select class="form-control form-control-sm" name="marqueADD" id="marqueADD">
                                        <?php
                                            $sql9= "SELECT * FROM marque";
                                            $marqueselect = $bdd->fetchAll($sql9);
                                            foreach($marqueselect as $marquesel)
                                            {
                                                ?>
                                                        <option value="<?php echo $marquesel['id_marque']; ?>"> <?php echo $marquesel['nom_marque']; ?></option>
                                                <?php
                                            }
                                                ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                        <input class="btn btn-success" name="buttonValideradd" type="submit" value="Valider" />
                        </div>
                    </form>
                </div>
            </div>
        </div>





<?php require_once('./template/_footer.php'); ?>

<?php
/*****************************************************************************Supression/Modification*****************************************************************************/

////////// Requette permetant de savoir combien il y a d'element dans la table//////////
    $sql2 = "select count(*) AS nb from product";
    $nbLigne = $bdd->fetch($sql2);
    $nbProduct = $nbLigne['nb'];

///////////////////////////////////////////////////////////////////////////////////////

////////// Parcoup pour savoir quel boutton à ete activer//////////
    $i=0;
    while ($i < $nbProduct) 
    { 
        $supprimer = $_POST["$tableauId[$i]"]; //recuperation de l'id
        $modifier = $_POST["$tableauIdM[$i]"]; //recuperation de l'id
        $nomproduct = $tableaunom[$i]; //recuperation de l'id
        

        if($supprimer == "Supprimer")
        {
            ?>
            <!-- Modal -->
            <div class="modal fade" id="SuppressionPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       Voulez-vous vraiment supprimer définitivement "<?php echo $nomproduct;?>" ?
                   </div>
                   <div class="modal-footer">
                       <form id="validerlaSupprimerform" name="validerlaSupprimerform" method="post">
                       <input class="btn btn-danger"  name="idsuprimer" type="text" value="<?=$tableauId[$i]?>" style="display:none;"/>
                       <input class="btn btn-danger"  name="validerlaSupprimer" type="submit" value="Supprimer" />
                       </form>
                   </div>
                   </div>
               </div>
           </div>
               <script>
                   $('#SuppressionPopUp').modal('show');
               </script>
        <?php                      
        }

        $validerlaSupprimer = $_POST['validerlaSupprimer'];
        $idsuprimer = $_POST['idsuprimer'];
        if($validerlaSupprimer == "Supprimer")
        {
            $sql3 = "DELETE FROM product WHERE id_product='$idsuprimer'";
            $reqSuprimer = $bdd->execute($sql3);
            ?>
            <meta http-equiv="refresh" content="0.01" />
            <?php
        }

         //Sinon c'est un bouton de Modification qui est selectionner par l'utilisateur //
         if($modifier == "Modifier")
         {
             //traitement de la modification// 
             $sql4 = "SELECT * FROM product WHERE id_product='$tableauIdM[$i]'";
             $reqmodifaffiche = $bdd->fetch($sql4);
             ?>
             <div class="modal fade bd-example-modal-lg" id="ModificationPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modifications</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="validerlaSupprimerform" name="validerlaSupprimerform" method="post" enctype='multipart/form-data'>
                            <div class="modal-body">
                                <div class="row">
                                    <img src="../api/images/<?php echo $reqmodifaffiche['picture'];?>" alt="">
                                </div>
                                <br>
                                <div class="row">
                                    <input class="form-control form-control-sm" type="file" name="userFile" id="userFile" value ="<?php echo $reqmodifaffiche['picture'];?>">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <small id="emailHelp" class="form-text text-muted">Nom du produit</small>
                                        <input class="form-control" name="des_prod" type="text" value="<?= $reqmodifaffiche['des_prod']; ?>"/>
                                    </div>
                                    <div class="col">
                                        <small id="emailHelp" class="form-text text-muted">Prix du produit</small>
                                        <input class="form-control" name="price" type="text" value="<?= $reqmodifaffiche['price']; ?>"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <small id="emailHelp" class="form-text text-muted">Catégorie</small>
                                        <?php
                                            $categorieafiche = $reqmodifaffiche['id_cat'];
                                            $sql7 = "SELECT * FROM categorie WHERE id_cat='$categorieafiche'";
                                            $reqmodifaffichecat = $bdd->fetch($sql7);
                                        ?>
                                        <select class="form-control form-control-sm" name="categorieModif" id="categorieModif">
                                        <option value="<?php echo $reqmodifaffiche['id_cat']; ?>"> <?php echo $reqmodifaffichecat['des_cat']; ?></option>
                                    <?php
                                        $sql6= "SELECT * FROM categorie";
                                        $catselect = $bdd->fetchAll($sql6);
                                        foreach($catselect as $catsel)
                                        {
                                            ?>
                                                    <option value="<?php echo $catsel['id_cat']; ?>"> <?php echo $catsel['des_cat']; ?></option>
                                            <?php
                                        }
                                            ?>
                                </select>
                                    </div>
                                    <div class="col">
                                        <small id="emailHelp" class="form-text text-muted">Marque</small>
                                        <?php
                                            $marqueafiche = $reqmodifaffiche['id_marque'];
                                            $sql8 = "SELECT * FROM marque WHERE id_marque='$marqueafiche'";
                                            $marqueafichemarque = $bdd->fetch($sql8);
                                        ?>
                                        <select class="form-control form-control-sm" name="marqueModif" id="marqueModif">
                                        <option value="<?php echo $reqmodifaffiche['id_marque']; ?>"> <?php echo $marqueafichemarque['nom_marque']; ?></option>
                                    <?php
                                        $sql9= "SELECT * FROM marque";
                                        $marqueselect = $bdd->fetchAll($sql9);
                                        foreach($marqueselect as $marquesel)
                                        {
                                            ?>
                                                    <option value="<?php echo $marquesel['id_marque']; ?>"> <?php echo $marquesel['nom_marque']; ?></option>
                                            <?php
                                        }
                                            ?>
                                </select>
                                    </div>
                                </div>
                                    <br>
                            </div>
                            <div class="modal-footer">
                                <input class="btn btn-danger"  name="id_product" type="text" value="<?=$reqmodifaffiche['id_product'];?>" style="display:none;"/>
                                <input class="btn btn-danger"  name="nomPhoto" type="text" value="<?=$reqmodifaffiche['picture'];?>" style="display:none;">
                                <input class="btn btn-success" name="ValidformulaireModif" type="submit" value="Valider la Modification" />
                            </div>
                        </form>
                   </div>
               </div>
           </div>
           <script>
                   $('#ModificationPopUp').modal('show');
            </script>
 
            <?php
          
         }
         ////

        $i++;
    }


?>

