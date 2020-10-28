<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");
include("_fin.inc.php");

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

$id=$_REQUEST['idEtab'];  

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgEtab=obtenirDetailEtablissement($connexion, $id);

$nom=$lgEtab['nomEtab'];
$adresseRue=$lgEtab['adresseRue'];
$codePostal=$lgEtab['codePostal'];
$ville=$lgEtab['ville'];
$tel=$lgEtab['tel'];
$adresseElectronique=$lgEtab['adresseElectronique'];
$type=$lgEtab['type'];
$civiliteResponsable=$lgEtab['civiliteResponsable'];
$nomResponsable=$lgEtab['nomResponsable'];
$prenomResponsable=$lgEtab['prenomResponsable'];
$nombreChambresOffertes=$lgEtab['nombreChambresOffertes'];

echo "
<p> <a href=\"index.php\">Accueil </a> > <a href=\"listeEtablissements.php\">Liste d'établissements </a> > Détail de l'établissement</p>
<table width='60%' cellspacing='0' cellpadding='0' align='center' 
class='styled-table'>
   <thead>
      <tr>
         <td colspan='3'>$nom</td>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td  width='20%'> Id: </td>
         <td>$id</td>
      </tr>
      <tr>
         <td> Adresse: </td>
         <td>$adresseRue</td>
      </tr>
      <tr>
         <td> Code postal: </td>
         <td>$codePostal</td>
      </tr>
      <tr>
         <td> Ville: </td>
         <td>$ville</td>
      </tr>
      <tr>
         <td> Téléphone: </td>
         <td>$tel</td>
      </tr>
      <tr>
         <td> E-mail: </td>
         <td>$adresseElectronique</td>
      </tr>
      <tr>
         <td> Type: </td>";
         if ($type==1)
         {
            echo "<td> Etablissement scolaire </td>";
         }
         else
         {
            echo "<td> Autre établissement </td>";
         }
      echo "
      </tr>
      <tr>
         <td> Responsable: </td>
         <td>$civiliteResponsable&nbsp; $nomResponsable&nbsp; $prenomResponsable
         </td>
      </tr> 
      <tr>
         <td> Offre: </td>
         <td>$nombreChambresOffertes&nbsp;chambre(s)</td>
      </tr>
      <tr>
         <td colspan='6' align='center'><a href='listeEtablissements.php'>Retour</a></td>
      </tr>   
   </tbody>
</table>";
?>
