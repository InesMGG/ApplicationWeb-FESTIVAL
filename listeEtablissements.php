<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");
include ("_fin.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion=Connect();
if (!$connexion)
{
   ajouterErreur("Echec de la connexion au serveur MySql");
   afficherErreurs();
   exit();
}
if (!selectBase($connexion))
{
   ajouterErreur("La base de données festival est inexistante ou non accessible");
   afficherErreurs();
   exit();
}

// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

echo "
<p> <a href=\"index.php\">Accueil </a> > Liste des établissements </p>
<table width='60%' cellspacing='0' cellpadding='0' align='center' class='styled-table'>
   <thead>
      <tr>
         <td colspan='6'>Etablissements</td>
      </tr>
   </thead> 
   <tbody>";

   $req = obtenirReqEtablissements();
   $rsEtab = $connexion->query($req);
   $lgEtab = $rsEtab->fetchALL(PDO::FETCH_ASSOC);

   // BOUCLE SUR LES ÉTABLISSEMENTS
   foreach ($lgEtab as $row) 
   {
      $nom = $row['nomEtab'];
      $id = $row['idEtab'];
      $nbOffre=$row['nombreChambresOffertes'];
      echo "<tr>";
      echo "<td width='52%'>".$nom."</td>";
      echo "<td width='16%' align='center'> ";
      echo "<a href='detailEtablissement.php?idEtab=".$id."'>";
      echo "<img src='IMAGE/voir.png'weight='50' height='50'/> </a></td>";
      echo "<td width='16%' align='center'>";
      echo "<a href='modificationEtablissement.php?action=demanderModifEtab&amp;id=".$id."'>";
      echo "<img src='IMAGE/modifier.png'weight='50' height='50'/> </a></td>";
      $nbattrib = obtenirNbOccup($connexion,$id);
      echo "<td width='16%'> <img src='IMAGE/attributions.png'weight='50' height='50'/>".$nbattrib."/".$nbOffre."</td>";
      if ($nbOffre == $nbattrib) 
      {
         echo "<td width='16%' align='center'>";
         echo "Complet";
         echo "</td>";
      }
      else if ($nbattrib != 0)
      {
         echo "<td width='16%' align='center'>";
         echo "Non Complet";
         echo "</td>";
      }
      else{
         echo "<td width='16%' align='center'>";
         echo "Pas de réservation";
         echo "</td>";
      }
      if (!existeAttributionsEtab($connexion, $id)) 
      {
         echo "<td width='16%' align='center'>";
         echo "<a href='suppressionEtablissement.php?action=demanderSupprEtab&amp;id=".$id."'>";
         echo "<img src='IMAGE/supprimer.png'weight='50' height='50'/> </a></td>";
      }
      else
      {
         echo "<td width='16%'>&nbsp; </td>";
      }
   }
   echo "</tr>";
   echo "<tr>";
   echo "<td colspan='6'><a href='creationEtablissement.php?action=demanderCreEtab'><img src='IMAGE/creation.png'weight='50' height='50'/></a ></td>";
      echo "</tr>";
      echo "</tbody>";
   echo "</table>";


   /*while ($lgEtab!=FALSE)
   {
      $id=$lgEtab['idEtab'];
      $nom=$lgEtab['nomEtab'];
      echo "
      <tr class='ligneTabNonQuad'>
         <td width='52%'>$nom</td>
         
         <td width='16%' align='center'> 
         <a href='detailEtablissement.php?idEtab=$id'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='modificationEtablissement.php?action=demanderModifEtab&amp;idEtab=$id'>
         Modifier</a></td>";
         
         // S'il existe déjà des attributions pour l'établissement, il faudra
         // d'abord les supprimer avant de pouvoir supprimer l'établissement
         if (!existeAttributionsEtab($connexion, $id))
         {
            echo "
            <td width='16%' align='center'> 
            <a href='suppressionEtablissement.php?action=demanderSupprEtab&amp;idEtab=$id'>
            Supprimer</a></td>";
         }
         else
         {
            echo "
            <td width='16%'>&nbsp; </td>";          
         }
         echo "
      </tr>";
      $lgEtab=mysqli_fetch_array($rsEtab);
   }   
   echo "
   <tr class='ligneTabNonQuad'>
      <td colspan='4'><a href='creationEtablissement.php?action=demanderCreEtab'>
      Création d'un établissement</a ></td>
  </tr>
</table>";*/

?>