<?php
//require_once("Connect.php");
// FONCTIONS DE CONNEXION
function Connect()
{
   $user = 'festival'; 
   $pass = 'secret';
   $dsn = 'mysql:host=localhost;dbname=festival'; 
   try
   {
      $dbh= new PDO($dsn, $user, $pass);
      return $dbh;
   } catch (PDOException $e){ 
      print "Erreur ! :" . $e->getMessage() . "<br/>"; 
    die();
} 
 return null;
}

function SELECTBase($connexion)
{
   $query = "SET CHARACTER SET utf8";
   $rs = $connexion->query($query);
   $ok = $connexion->query("use festival");
   return $ok; 
   /*$bd="festival";
   $query="SET CHARACTER SET utf8";
   // Modification du jeu de caractères de la connexion
   mysqli_query($connexion,$query); 
   return mysqli_SELECT_db($connexion, $bd);*/
}

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirReqEtablissements()
{
   $req="SELECT idEtab, nomEtab,nombreChambresOffertes FROM Etablissement ORDER BY idEtab";
   return $req;
}

function obtenirReqEtablissementsOffrantChambres()
{
   $req="SELECT idEtab, nomEtab, nombreChambresOffertes from Etablissement where 
         nombreChambresOffertes!=0 order by idEtab";
   return $req;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $req="SELECT distinct e.idEtab, nomEtab, nombreChambresOffertes from Etablissement e, 
         Attribution a where e.idEtab = a.idEtab order by idEtab";
   return $req;
}


function obtenirDetailEtablissement($connexion, $id)
{
   $req = "SELECT * from Etablissement where idEtab='$id'";
   $rsEtab1 = $connexion->query($req);
   $rsEtab = $rsEtab1->fetch();
   return $rsEtab;
}

function supprimerEtablissement($connexion, $id)
{
   $req="DELETE from Etablissement where idEtab='$id'";
   $rsEtab=$connexion->exec($req);
   $rsEtab=null;
   //mysqli_query($connexion,$req);
}
 
function modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                               $ville, $tel, $adresseElectronique, $type, 
                               $civiliteResponsable, $nomResponsable, 
                               $prenomResponsable, $nombreChambresOffertes)
{  
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
  
   $req="UPDATE Etablissement set nomEtab='$nom',adresseRue='$adresseRue',
         codePostal='$codePostal',ville='$ville',tel='$tel',
         adresseElectronique='$adresseElectronique',type='$type',
         civiliteResponsable='$civiliteResponsable',nomResponsable=
         '$nomResponsable',prenomResponsable='$prenomResponsable',
         nombreChambresOffertes='$nombreChambresOffertes' where idEtab='$id'";
   
   $rsEtab=$connexion->exec($req);
   $rsEtab=null;
   //mysqli_query($connexion,$req);
}

function creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                            $ville, $tel, $adresseElectronique, $type, 
                            $civiliteResponsable, $nomResponsable, 
                            $prenomResponsable, $nombreChambresOffertes)
{ 
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
   
   $req="INSERT into Etablissement values ('$id', '$nom', '$adresseRue', 
         '$codePostal', '$ville', '$tel', '$adresseElectronique', '$type', 
         '$civiliteResponsable', '$nomResponsable', '$prenomResponsable',
         '$nombreChambresOffertes')";
   
   $rsEtab=$connexion->exec($req);
   //mysqli_query($connexion,$req);
}


function estUnIdEtablissement($connexion, $id)
{
   $req="SELECT * from Etablissement where idEtab='$id'";
   $rsEtab1=$connexion->query($req);
   $rsEtab=$rsEtab1->fetch();
   return $rsEtab;
}

function estUnNomEtablissement($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="SELECT * from Etablissement where nomEtab='$nom'";
   }
   else
   {
      $req="SELECT * from Etablissement where nomEtab='$nom' and idEtab!='$id'";
   }
   $rsEtab1=$connexion->query($req);
   $rsEtab=$rsEtab1->fetch();
   return $rsEtab;
   /*$rsEtab=mysqli_query($connexion,$req);
   return mysqli_fetch_array($rsEtab);*/
}

function obtenirNbEtab($connexion)
{
   $req="SELECT count(*) as nombreEtab from Etablissement";
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetch();
   return $lgEtab["nombreEtab"];
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $req="SELECT count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   $rsEtabOffrantChambres=$connexion->query($req);
   $lgEtabOffrantChambres=$rsEtabOffrantChambres->fetch();
   return $lgEtabOffrantChambres["nombreEtabOffrantChambres"];
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $nombreChambres)
{
   $nbOccup=obtenirNbOccup($connexion, $idEtab);
   return ($nombreChambres>=$nbOccup);
}

// FONCTIONS RELATIVES AUX EquipeS

function obtenirReqIdNomEquipesAHeberger()
{
   $req="SELECT idEquipe, nomEquipe, idPays from Equipe where hebergement='O' order by idEquipe";
   return $req;
}

function obtenirNomEquipe($connexion, $id)
{
   $req="SELECT nomEquipe from Equipe where idEquipe='$id'";
   $rsEquipe=$connexion->query($req);
   $lgEquipe=$rsEquipe->fetch();
   return $lgEquipe["nomEquipe"];
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id)
{
   $req = "SELECT * From Attribution where idEtab='$id'";
   $rsAttrib1 = $connexion->query($req);
   $rsAttrib = $rsAttrib1->fetch();
   return $rsAttrib;
   /*$req="SELECT * From Attribution where idEtab='$id'";
   $rsAttrib=mysqli_query($connexion,$req);
   return mysqli_fetch_array($rsAttrib);*/
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $id)
{
   $req="SELECT IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$id'";
   $rsOccup=$connexion->query($req);
   $lgOccup=$rsOccup->fetch();
   return $lgOccup["totalChambresOccup"];
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id Equipe transmis
function modifierAttribChamb($connexion, $idEtab, $idEquipe, $nbChambres)
{
   $req="SELECT count(*) as nombreAttribEquipe from Attribution where idEtab=
        '$idEtab' and idEquipe='$idEquipe'";
   $rsAttrib=$connexion->query($req);
   $lgAttrib=$rsAttrib->fetch();
   if ($nbChambres==0)
   {
      $req="DELETE from Attribution where idEtab='$idEtab' and idEquipe='$idEquipe'";
   } 
   else
   {
      if ($lgAttrib["nombreAttribEquipe"]!=0)
      {
         $req="UPDATE Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idEquipe='$idEquipe'";
      }  
      else
      {
         $req="INSERT into Attribution values('$idEtab','$idEquipe', $nbChambres)";
      }
   }
   $connexion->exec($req);
}


// Retourne la requête permettant d'obtenir les id et noms des Equipes affectés
// dans l'établissement transmis
function obtenirReqEquipesEtab($idEtab)
{
   $req="SELECT distinct Attribution.idEquipe, nomEquipe, idPays from Equipe, Attribution where Attribution.idEquipe=Equipe.idEquipe and idEtab='$idEtab'";
   return $req;
}
            
// Retourne le nombre de chambres occupées par le Equipe transmis pour l'id étab
// et l'id Equipe transmis
function obtenirNbOccupEquipe($connexion, $idEtab, $idEquipe)
{
   $req="SELECT nombreChambres From Attribution where idEtab='$idEtab'
        and idEquipe='$idEquipe'";
   $rsAttribEquipe=$connexion->query($req);
   if ($lgAttribEquipe=$rsAttribEquipe->fetch())
      return $lgAttribEquipe["nombreChambres"];
   else
      return 0;
}

function obtenirNomPays($idPays,$connexion)
{
   $req="SELECT nompays FROM pays where idPays ='$idPays'";
   $rsPays=$connexion->query($req);
   $lgPays=$rsPays->fetch();
   return $lgPays['nompays'];
}

function obtenirDrapeauPays($idPays,$connexion)
{
   $req="SELECT drapeau FROM pays where idPays ='$idPays'";
   $rsPays=$connexion->query($req);
   $lgPays=$rsPays->fetch();
   return $lgPays['drapeau'];
}

function obtenirSommeAttrib($connexion,$idEquipe)
{
	$req = "SELECT SUM(nombreChambres) as totalChambresAttrib FROM Attribution WHERE idEquipe='$idEquipe'";
	$rsAttrib = $connexion->query($req);
	$lgAttrib = $rsAttrib->fetch();
	return $lgAttrib['totalChambresAttrib'];
}
?>