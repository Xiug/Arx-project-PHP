/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */
  
<?php 
require_once'function.php';
load_base();
$cle = htmlspecialchars($_GET['cle']);
$nom = htmlspecialchars($_GET['nom']);
$sql = "SELECT code FROM inscription WHERE pseudo = '".$nom."'";
$new = tab_mysqli_connect($sql, $connect);
$sql = "SELECT pseudo FROM connexion WHERE pseudo = '".$nom."'";
$name = tab_mysqli_connect($sql, $connect);
$sql = "SELECT mdp FROM inscription WHERE pseudo = '".$nom."'";
$mdp = tab_mysqli_connect($sql, $connect);
if ($name['pseudo'] == $nom)
{
	echo '<center><p>Votre compte à déjà été activé.</p></center>';
	exit();
}
if ($new['code'] != $cle)
{
	echo '<center><p>Erreur sur la pages !</p></center>';
	exit();
}
else
{
	$sql = "SELECT valeur FROM inscription WHERE pseudo='".$nom."'";
	$valeur = tab_mysqli_connect($sql, $connect);
	$sql = "INSERT INTO connexion(valeur, pseudo, mdp) VALUES ('".$valeur['valeur']."', '".$nom."', '".$mdp['mdp']."')";
	mysqli_cox($sql, $connect);
	echo '<center><p> Votre compte est activé, vous pouvez vous connecter maintenant.</p></center>';
}
?>