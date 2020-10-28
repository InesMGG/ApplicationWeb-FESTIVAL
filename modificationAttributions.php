<?php
include ('_debut.inc.php');
include('_gestionBase.inc.php');
include ('_controlesEtGestionErreurs.inc.php');
include ('_fin.inc.php');

// CONNEXION AU SERVEUR MYSQL PUIS SELECTION DE LA BASE DE DONNES festival

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

// EFFECTUER OU MODIFIER LES ATTRIBUTIONS POUR L'ENSEMBLE DES ÉTABLISSEMENTS

// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ DE 2 LIGNES D'EN-TÊTE (LIGNE TITRE ET 
// LIGNE ÉTABLISSEMENTS) ET DU DÉTAIL DES ATTRIBUTIONS 
// UNE LÉGENDE FIGURE SOUS LE TABLEAU

// Recherche du nombre d'établissements offrant des chambres pour le 
// dimensionnement des colonnes
$nbEtabOffrantChambres = obtenirNbEtabOffrantChambres($connexion);
//$nb = $nbEtabOffrantChambres + 1;
// Détermination du pourcentage de largeur des colonnes "établissements"
$pourcCol = 50/$nbEtabOffrantChambres;

$action = $_REQUEST['action'];

// Si l'action est validerModifAttrib (cas où l'on vient de la page 
// donnerNbChambres.php) alors on effectue la mise à jour des attributions dans 
// la base 
if ($action == 'validerModifAttrib') 
{
	$idEtab = $_REQUEST['idEtab'];
	$idEquipe = $_REQUEST['idEquipe'];
	$nbChambres = $_REQUEST['nbChambres'];
	modifierAttribChamb($connexion,$idEtab,$idEquipe,$nbChambres);
}
echo "
<p> <a href=\"index.php\">Accueil </a> > <a href=\"consultationAttributions.php\">Consultation des attributions </a> > Modification des attributions</p>
<table width='80%' cellspacing='0' cellpadding='0' align='center'class='styled-table'>";
// AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE
echo "<thead>";
echo "<tr>";
echo "<td colspan=15><strong>Attributions</strong></td>";
echo "</tr>";
// AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE (ÉTABLISSEMENTS)
echo "<tr>";
echo "<td>&nbsp;</td>";
$req = obtenirReqEtablissementsOffrantChambres();
$rsEtab = $connexion->query($req);
$lgEtab = $rsEtab->fetchALL(PDO::FETCH_ASSOC);
foreach ($lgEtab as $row) 
{
	$idEtab = $row['idEtab'];
	$nom = $row['nomEtab'];
	$nbOffre=$row["nombreChambresOffertes"];
    $nbOccup=obtenirNbOccup($connexion, $idEtab);
    $nbChLib = $nbOffre - $nbOccup;

    echo "<td valign='top' width='$pourcCol%'>";
    echo "<i>Disponibilités : $nbChLib </i>";
    echo "<br> $nom </td>";
}
echo "<td>Total de chambres</td>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$req = obtenirReqIdNomEquipesAHeberger();
$rsEquipe = $connexion->query($req);
$lgEquipe = $rsEquipe->fetchALL(PDO::FETCH_ASSOC);
foreach ($lgEquipe as $row) 
{
	$idEquipe = $row['idEquipe'];
	$nom = $row['nomEquipe'];
	$idPays =$row['idPays'];
	$nomPays = obtenirNomPays($idPays,$connexion);
	$total = obtenirSommeAttrib($connexion,$idEquipe);
	echo "<tr>";
	echo "<td width = '25%'><strong>$nom ($nomPays)</strong></td>";
	$req = obtenirReqEtablissementsOffrantChambres();
	$rsEtab = $connexion->query($req);
	$lgEtab = $rsEtab->fetchALL(PDO::FETCH_ASSOC);
	foreach ($lgEtab as $row) 
	{
		$idEtab = $row['idEtab'];
		$nbOffre = $row['nombreChambresOffertes'];
		$nbOccup = obtenirNbOccup($connexion, $idEtab);
		// Calcul du nombre de chambres libres
		$nbChLib = $nbOffre - $nbOccup;
		// On recherche si des chambres ont déjà été attribuées à ce Equipe
        // dans cet établissement
		$nbOccupEquipe=obtenirNbOccupEquipe($connexion, $idEtab, $idEquipe);
		// Cas où des chambres ont déjà été attribuées à ce Equipe dans cet
        // établissement
		if ($nbOccupEquipe != 0)
		{
			// Le nombre de chambres maximum pouvant être demandées est la somme 
            // du nombre de chambres libres et du nombre de chambres actuellement 
            // attribuées au Equipe (ce nombre $nbmax sera transmis si on 
            // choisit de modifier le nombre de chambres)
			$nbMax = $nbChLib + $nbOccupEquipe;
			echo "<td class = 'reserve'>";
			echo "<a href='donnerNbChambres.php?idEtab&amp;idEquipe=$idEquipe&amp;nbChambres=$nbMax'>$nbOccupEquipe</a>";
			echo "</td>";
		}
		else
		{
			// Cas où il n'y a pas de chambres attribuées à ce Equipe dans cet 
            // établissement : on affiche un lien vers donnerNbChambres s'il y a 
            // des chambres libres sinon rien n'est affiché  	
			if ($nbChLib != 0) 
			{
				echo "<td class = 'reserveSiLien'>";
				echo "<a href='donnerNbChambres.php?idEtab=$idEtab&amp;idEquipe=$idEquipe&amp;nbChambres=$nbChLib'><img src='IMAGE/creation.png'weight='50' height='50'/></a>";
				echo "</td>";
			}
			else
			{
				echo "<td class = 'reserveSiLien'>&nbsp;</td>";
			}
		}
	}
	echo "<td>$total</td>";
	echo "</tr>";
}
echo "</tbody></table>";
echo "<table align='center' width='80%'>
   <tr>
      <td width='34%' align='left'><a href='consultationAttributions.php'>Retour</a>
      </td>
      <td class='reserveSiLien'>&nbsp;</td>
      <td width='30%' align='left'>Réservation possible si lien</td>
      <td class='reserve'>&nbsp;</td>
      <td width='30%' align='left'>Chambres réservées</td>
   </tr>
</table>";
?>
