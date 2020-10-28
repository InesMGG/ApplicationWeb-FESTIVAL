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

// SÉLECTIONNER LE NOMBRE DE CHAMBRES SOUHAITÉES

$idEtab=$_REQUEST['idEtab'];
$idEquipe=$_REQUEST['idEquipe'];
$nbChambres=$_REQUEST['nbChambres'];

echo "
<p> <a href=\"index.php\">Accueil </a> > <a href=\"consultationAttributions.php\">Consultation des attributions </a> > <a href=\"modificationAttributions.php?action=demanderModifAttrib\">Modification des attributions </a> > Attributions des chambres</p>
<form method='POST' action='modificationAttributions.php'>
	<input type='hidden' value='validerModifAttrib' name='action'>
   <input type='hidden' value='$idEtab' name='idEtab'>
   <input type='hidden' value='$idEquipe' name='idEquipe'>";
   $nomEquipe=obtenirNomEquipe($connexion, $idEquipe);
   
   echo "
   <br><center><h5>Combien de chambres souhaitez-vous pour le 
   Equipe $nomEquipe dans cet établissement ?";
   
   echo "&nbsp;<select name='nbChambres'>";
   for ($i=0; $i<=$nbChambres; $i++)
   {
      echo "<option>$i</option>";
   }
   echo "
   </select></h5>
   <input type='submit' value='Valider' name='valider'>&nbsp&nbsp&nbsp&nbsp
   <input type='reset' value='Annuler' name='Annuler'><br><br>
   <a href='modificationAttributions.php?action=demanderModifAttrib'>Retour</a>
   </center>
</form>";

?>
