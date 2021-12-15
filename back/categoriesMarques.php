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
    $sql = "SELECT * FROM marque";
    $sql2 = "SELECT * FROM categorie";
/*****************************************************************************Traitement de la recherche marque*****************************************************************************/
$RechercheBM = $_POST['RechercheBM'];
if($RechercheBM)
{
    $RechercheMarque = $_POST['RechercheMarque'];
    if($RechercheMarque == NULL)
    {
        $sql = "SELECT * FROM marque";
    }                  
    else
    {
        $sql = "SELECT * FROM marque WHERE nom_marque LIKE '%$RechercheMarque%'";
    }
}
/*************************************************************************************************************************************************************************************/
/*****************************************************************************Traitement de la recherche categorie*****************************************************************************/
$RechercheBC = $_POST['RechercheBC'];
if($RechercheBC)
{
    $RechercheCat = $_POST['RechercheCat'];
    if($RechercheCat == NULL)
    {
        $sql2 = "SELECT * FROM categorie";
    }                  
    else
    {
        $sql2 = "SELECT * FROM categorie WHERE des_cat LIKE '%$RechercheCat%'";
    }
}
/*************************************************************************************************************************************************************************************/

/*****************************************************************************Traitement de la Modification*****************************************************************************/

////////// recuperation des datas à modifier//////////
             
$ValidformulaireModifM = $_POST['ValidformulaireModifM'];
if ($ValidformulaireModifM)
{ 
    $id_marque = $_POST['id_marque'];
    $nom_marque = $_POST['nom_marque'];

    $sql7 = "UPDATE marque SET nom_marque = :nom_marque WHERE id_marque = :id_marque";

    $bdd->execute($sql7, array(
        ':nom_marque'   => $nom_marque,
        ':id_marque'    => $id_marque
    ));
                                    
}
///////////////////////////////////////////////////////////////////////////////////////
/*****************************************************************************Traitement de la Modification*****************************************************************************/

////////// recuperation des datas à modifier//////////
             
$ValidformulaireModifC = $_POST['ValidformulaireModifC'];
if ($ValidformulaireModifC)
{ 
    $id_cat = $_POST['id_cat'];
    $des_cat = $_POST['des_cat'];

    $sql13 = "UPDATE categorie SET des_cat = :des_cat WHERE id_cat = :id_cat";

    $bdd->execute($sql13, array(
        ':des_cat'   => $des_cat,
        ':id_cat'    => $id_cat
    ));                          
}
///////////////////////////////////////////////////////////////////////////////////////


$ValiderCreerCategorie = $_POST['ValiderCreerCategorie'];
if($ValiderCreerCategorie)
{
    $LibCat = $_POST['LibCat'];
    $sql14 = "INSERT INTO categorie (des_cat) VALUES (:LibCat)";

    $bdd->execute($sql14, array(
        ':LibCat'   => $LibCat,
    ));    
}

$ValiderCreerMarque = $_POST['ValiderCreerMarque'];
if($ValiderCreerMarque)
{
    $LibMarque = $_POST['LibMarque'];
    $sql15 = "INSERT INTO marque (nom_marque) VALUES (:LibMarque)";

    $bdd->execute($sql15, array(
        ':LibMarque'   => $LibMarque,
    ));    
}



$categorie = $bdd->fetchAll($sql2);
$marque = $bdd->fetchAll($sql);

 ?>


<link rel="stylesheet" href="../style/categoriesMarque.css"> 
    <title>Catégories et Marques</title>
</head>
<body>
    <nav class="nav flex-column">
        <?php require_once('./template/_navbar.php');  ?>
    </nav>
    <div class="row" style="padding:50px;">
        <div class="tout col">
            <br>
            <div class="row">
                <div class="col">
                    <h4 class="titretable"> &nbsp;&nbsp; Catégories &nbsp;&nbsp;</h4>
                </div>
                <div class="col">
                    <div class="table_add2 col-md-4">
                        <form class="RechercheC" id="RechercheC" name="RechercheC" method="post">
                            <table>
                                <tr>
                                    <td>
                                        <input style="width: 150px" class="form-control mr-sm-2" name="RechercheCat" type="text" placeholder="Recherche..."/>
                                    </td>
                                    <td>
                                    <input class="btn btn-outline-secondary" name="RechercheBC" type="submit" value="Recherche" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <div class="scroling">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">Libelle </th>
                            <th scope="col">Modifier</th>
                            <th scope="col">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $Y=0;
                        foreach($categorie as $categorieA)
                            {
                                $tableauC[$Y] = $categorieA['id_cat'];  //Tableau qui repertorie les IDs
                                $tableauCM[$Y] = $categorieA['id_cat'];  //Tableau qui repertorie les IDs
                                $tableaunomCat[$Y] = $categorieA['des_cat'];  //Tableau qui repertorie les Nom
                                ?>
                                    <tr>
                                        <td class="userTableau">
                                        <?php echo $categorieA['des_cat']; ?>
                                        </td>
                                        <td>
                                            <form id="ModifierC" name="ModifierC" method="POST">
                                                <input class="btn btn-outline-info" name="<?= $tableauCM[$Y] ?>" type="submit" value=" Modifier " />
                                            </form>
                                        </td>
                                        <td>
                                            <form id="SupprimerC" name="SupprimerC" method="POST">
                                            <?php
                                                if($tableauC[$Y] == 5)
                                                {
                                                    ?>
                                                    <input  class="btn btn-outline-danger"  name="<?= $tableauC[$Y] ?>" type="submit" value=" Supprimer " disabled/>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <input  class="btn btn-outline-danger"  name="<?= $tableauC[$Y] ?>" type="submit" value=" Supprimer " />
                                                    <?php
                                                }
                                                ?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                $Y++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="tout col">
            <br>
            <div class="row">
                <div class="col">
                    <h4 class="titretable"> &nbsp;&nbsp; Marques &nbsp;&nbsp;</h4>
                </div>
                <div class="col">
                    <div class="table_add2 col-md-4">
                        <form class="RechercheM" id="RechercheM" name="RechercheM" method="post">
                            <table>
                                <tr>
                                    <td>
                                        <input style="width: 150px" class="form-control mr-sm-2" name="RechercheMarque" type="text" placeholder="Recherche..."/>
                                    </td>
                                    <td>
                                    <input class="btn btn-outline-secondary" name="RechercheBM" type="submit" value="Recherche" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <div class="scroling">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">Libelle </th>
                            <th scope="col">Modifier</th>
                            <th scope="col">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $X=0;
                        foreach($marque as $marqueA)
                            {
                                $tableauM[$X] = $marqueA['id_marque'];  //Tableau qui repertorie les IDs
                                $tableauMM[$X] = $marqueA['id_marque'];  //Tableau qui repertorie les IDs
                                $tableaunomMarque[$X] = $marqueA['nom_marque'];  //Tableau qui repertorie les Nom
                                ?>
                                    <tr>
                                        <td class="userTableau">
                                        <?php echo $marqueA['nom_marque']; ?>
                                        </td>
                                        <td>
                                            <form id="ModifierM" name="ModifierM" method="POST">
                                                <input class="btn btn-outline-info" name="<?= $tableauMM[$X] ?>" type="submit" value="Modifier" />
                                            </form>
                                        </td>
                                        <td>
                                            <form id="SupprimerM" name="SupprimerM" method="POST">
                                            <?php
                                                if($tableauM[$X] == 5)
                                                {
                                                    ?>
                                                    <input  class="btn btn-outline-danger"  name="<?= $tableauM[$X] ?>" type="submit" value="Supprimer" disabled/>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <input  class="btn btn-outline-danger"  name="<?= $tableauM[$X] ?>" type="submit" value="Supprimer" />
                                                    <?php
                                                }
                                                ?>
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
        </div>  
    </div>
    <div class="row">
        <div class="col">
            <button class="btn btn-primary" name="buttonAjoutCat" type="button" value="Ajouter une Catégorie" data-toggle="modal" data-target="#exampleModalAddCat">
                Ajouter une Catégorie
            </button>
        </div>
        <div class="col">
            <button class="btn btn-primary" name="buttonAjoutMarque" type="button" value="Ajouter une Marque" data-toggle="modal" data-target="#exampleModalAddMarque">
                Ajouter une Marque
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalAddCat">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="ajout_competence">
                    <div class="modal-body">
                        <center>
                            <table>
                                <tr>
                                    <td style="width : 300px;">
                                        <small id="emailHelp" class="form-text text-muted">Libelle de la catégorie</small>
                                        <input class="form-control mr-sm-2" id="LibCat" name="LibCat" type="text"/>
                                    </td>
                                    </tr>
                            </table>
                            </center>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="ValiderCreerCategorie" class="add btn btn-outline-success" value="Ajouter">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalAddMarque">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="ajout_competence">
                    <div class="modal-body">
                        <center>
                            <table>
                                <tr>
                                    <td style="width : 300px;">
                                        <small id="emailHelp" class="form-text text-muted">Libelle de la Marque</small>
                                        <input class="form-control mr-sm-2" id="LibMarque" name="LibMarque" type="text"/>
                                    </td>
                                    </tr>
                            </table>
                            </center>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="ValiderCreerMarque" class="add btn btn-outline-success" value="Ajouter">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once('./template/_footer.php'); ?>
<?php
/*****************************************************************************Supression/Modification*****************************************************************************/

////////// Requette permetant de savoir combien il y a d'element dans la table des marques//////////
    $sql3 = "select count(*) AS nbM from marque";
    $nbLigne = $bdd->fetch($sql3);
    $nbMArque = $nbLigne['nbM'];

///////////////////////////////////////////////////////////////////////////////////////

////////// Parcoup pour savoir quel boutton à ete activer//////////
    $i=0;
    while ($i < $nbMArque) 
    { 
        $supprimer = $_POST["$tableauM[$i]"]; //recuperation de l'id
        $modifier = $_POST["$tableauMM[$i]"]; //recuperation de l'id
        $nomMarque = $tableaunomMarque[$i]; //recuperation de l'id
        
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
                       Voulez-vous vraiment supprimer définitivement la marque "<?php echo $nomMarque;?>" ?
                   </div>
                   <div class="modal-footer">
                       <form id="validerlaSupprimerform" name="validerlaSupprimerform" method="post">
                       <input class="btn btn-danger"  name="idsuprimer" type="text" value="<?=$tableauM[$i]?>" style="display:none;"/>
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
        //Sinon c'est un bouton de Modification qui est selectionner par l'utilisateur //
        if($modifier == "Modifier")
        {
            //traitement de la modification// 
            $sql4 = "SELECT * FROM marque WHERE id_marque='$tableauMM[$i]'";
            $reqmodifafficheMarque = $bdd->fetch($sql4);
            ?>
            <div class="modal fade bd-example-modal-lg" id="ModificationPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       <form id="validerlaSupprimerform" name="validerlaSupprimerform" method="post" enctype='multipart/form-data'>
                           <div class="modal-body">
                               <input type="text" class="form-control" name="nom_marque" value="<?php echo $reqmodifafficheMarque['nom_marque'];?>">
                           </div>
                           <div class="modal-footer">
                               <input class="btn btn-danger"  name="id_marque" type="text" value="<?=$reqmodifafficheMarque['id_marque'];?>" style="display:none;"/>
                               <input class="btn btn-success" name="ValidformulaireModifM" type="submit" value="Valider la Modification" />
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
        $validerlaSupprimer = $_POST['validerlaSupprimer'];
        $idsuprimer = $_POST['idsuprimer'];
        if($validerlaSupprimer == "Supprimer")
        {
            $sql5 = "DELETE FROM marque WHERE id_marque='$idsuprimer'";
            $reqSuprimer = $bdd->execute($sql5);
            
            $sql6 = "UPDATE product WHERE id_marque ='$idsuprimer' SET id_marque = '5'";
            $reqModifSuprimer = $bdd->execute($sql6);

            ?>
            <meta http-equiv="refresh" content="0.01" />
            <?php
        }
        
        $i++;
    }

////////// Requette permetant de savoir combien il y a d'element dans la table des categorie//////////
$sql8 = "select count(*) AS nbC from categorie";
$nbLigneC = $bdd->fetch($sql8);
$nbCat = $nbLigneC['nbC'];

///////////////////////////////////////////////////////////////////////////////////////

////////// Parcoup pour savoir quel boutton à ete activer//////////
$j=0;
while ($j < $nbCat) 
{ 
    $supprimerC = $_POST["$tableauC[$j]"]; //recuperation de l'id
    $modifierC = $_POST["$tableauCM[$j]"]; //recuperation de l'id
    $nomCategorie = $tableaunomCat[$j]; //recuperation de l'id
    
    if($supprimerC == " Supprimer ")
    {
        ?>
        <!-- Modal -->
        <div class="modal fade" id="SuppressionPopUpC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   Voulez-vous vraiment supprimer définitivement la categorie "<?php echo $nomCategorie;?>" ?
               </div>
               <div class="modal-footer">
                   <form id="validerlaSupprimerform" name="validerlaSupprimerform" method="post">
                   <input class="btn btn-danger"  name="idsuprimerC" type="text" value="<?=$tableauC[$j]?>" style="display:none;"/>
                   <input class="btn btn-danger"  name="validerlaSupprimerC" type="submit" value="Supprimer" />
                   </form>
               </div>
               </div>
           </div>
       </div>
           <script>
               $('#SuppressionPopUpC').modal('show');
           </script>
    <?php              
        
    }
    //Sinon c'est un bouton de Modification qui est selectionner par l'utilisateur //
    if($modifierC == " Modifier ")
    {
        //traitement de la modification// 
        $sql9 = "SELECT * FROM categorie WHERE id_cat='$tableauCM[$j]'";
        $reqmodifafficheCategorie = $bdd->fetch($sql9);
        ?>
        <div class="modal fade bd-example-modal-lg" id="ModificationPopUpC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <form id="validerlaSupprimerform" name="validerlaSupprimerform" method="post" enctype='multipart/form-data'>
                       <div class="modal-body">
                           <input type="text" class="form-control" name="des_cat" value="<?php echo $reqmodifafficheCategorie['des_cat'];?>">
                       </div>
                       <div class="modal-footer">
                           <input class="btn btn-danger"  name="id_cat" type="text" value="<?=$reqmodifafficheCategorie['id_cat'];?>" style="display:none;"/>
                           <input class="btn btn-success" name="ValidformulaireModifC" type="submit" value="Valider la Modification" />
                       </div>
                   </form>
              </div>
          </div>
      </div>
      <script>
              $('#ModificationPopUpC').modal('show');
       </script>

       <?php
     
    }
    ////
    $validerlaSupprimerC = $_POST['validerlaSupprimerC'];
    $idsuprimerC = $_POST['idsuprimerC'];
    if($validerlaSupprimerC == "Supprimer")
    {
        $sql10 = "DELETE FROM categorie WHERE id_cat='$idsuprimerC'";
        $reqSuprimer = $bdd->execute($sql10);
        
        $sql11 = "UPDATE product WHERE id_cat='$idsuprimerC' SET id_cat = '5'";
        $reqModifSuprimer = $bdd->execute($sql11);

        ?>
        <meta http-equiv="refresh" content="0.01" />
        <?php
    }
    
    
    $j++;
}
?>