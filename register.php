/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */

<?php
// Initialisation Session
session_start();


// Récupération Captcha
$captch      = strtolower($_SESSION['captch']);
$captcha     = strtolower(htmlspecialchars($_POST['code']));

// Inclussion de fichier
require_once'function.php';


// Chargement de base
load_base();
echo"<h1><center>Bienvenue ".htmlspecialchars($_POST['user']). " nous allons prendre en charge votre inscription </center></h1>";

// Vérification du Captcha
if ($captch != $captcha)
{
	$msg     = "Le captcha ne correspondent pas";
	echo "<center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>";
	exit();
}
echo"<center><p>Etape 1 : Code Correcte</p></center>";

// Récupération entier du formulaire et création de clé 
$date        = date("d-m-Y");
$heure       = date("H:i");
$pseudo      = htmlspecialchars($_POST['user']);
$password    = htmlspecialchars($_POST['password']);
$pass        = htmlspecialchars($_POST['pass']);
$mail        = htmlspecialchars($_POST['email']);
$jour        = htmlspecialchars($_POST['jour']);
$mois        = htmlspecialchars($_POST['mois']);
$annee       = htmlspecialchars($_POST['annee']);
$cle         = load_cle($pseudo);
echo "<br /><center><p> Etape 2 : Collecte des information</p></center>";

// Vérification des mots de passe
mdp($password, $pass);
echo "<br /><center><p> Etape 3 : Mot de passe valide</p></center>";

// Sécurisation du mot de passe
$password = bcrypt($password);   
echo "<br /><center><p> Etape 4 : Mot de passe sécuriser</p></center>";

// Vérification du nom utilisateur
$stock = verif_nom($pseudo, $connect);
if ($stock == 1)
{
	$msg     = "Nom utilisateur déjà utilisé";
	echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
	exit();
}
echo "<br /><center><p> Etape 5 : Nom utilisateur valide</p></center>";

// Vérification de l'email
$sql         = 'SELECT email FROM inscription WHERE email LIKE"'.$mail.'"';
$name        = tab_mysqli_connect($sql, $connect);
$email       = strtolower($mail);
$mail_a      = strtolower($name['email']);
if ($email ==  $mail_a)
{
	$msg     = "Email déjà utilisé !";
	echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
	mysqli_close();
	exit();
}
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
{
 	$msg     = "Adresse email non valide !";
	echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
	mysqli_close();
	exit();
}
echo "<br /><center><p> Etape 6 : Adresse email valide </p></center>";

// Mise en forme et enrengistration des informations
$creation = $date.' à '.$heure;
if($mois == "1")
	$mois = "Janvier";
if($mois == "2")
	$mois = "Février";
if($mois == "3")
	$mois = "Mars";
if($mois == "4")
	$mois = "Avril";
if($mois == "5")
	$mois = "Mai";
if($mois == "6")
	$mois = "Juin";
if($mois == "7")
	$mois = "Juillet";
if($mois == "8")
	$mois = "Août";
if($mois == "9")
	$mois = "Septembre";
if($mois == "10")
	$mois = "Octobre";
if($mois == "11")
	$mois = "Novembre";
if($mois == "12")
	$mois = "Décembre";
$naissance = 'le '.$jour.' '.$mois.' '.$annee;
$sql       = "SELECT valeur FROM inscription ORDER BY valeur DESC LIMIT 1";
$valeur    = tab_mysqli_connect($sql, $connect);
$valeur    = $valeur['valeur'];
$valeur    = $valeur + 1;
$ip        = get_ip();
$sql       = 'INSERT INTO `inscription`(`valeur`, `pseudo`, `mdp`, `ip`, `email`, `naissance`, `code`, `creation`) 
		VALUES ("'.$valeur.'", "'.$pseudo.'", "'.$password.'", "'.$ip.'", "'.$mail.'", "'.$naissance.'", "'.$cle.'", "'.$creation.'")';

//PhpMailer

// on envoie la requête
mysqli_cox($sql, $connect);
echo ' <br /><center><p> Etape 7 : Enrengistrement de vos données  </p></center>';

$send             = new PHPMailer();
$send->Host       = 'smtp.server.net';
$send->SMTPAuth   = FALSE;
$send->Port = 25; // Par défaut
 
// Authentification
$send->Username   = "user";
$send->Password   = "password";
 
// Expéditeur
$send->SetFrom('mail@mail.net', 'user');
// Destinataire
$send->AddAddress($mail, $pseudo);
// Objet
$send->Subject    = 'sujet';
$send->CharSet    = 'UTF-8';
 
// Votre message
$send->MsgHTML('texte');
 
// Envoi du mail avec gestion des erreurs
if(!$send->Send()) 
{
  echo '<br /><center>Erreur : ' . $send->ErrorInfo.' <br /> Veuillez contacter l\'administrateur avec votre email </center>';
} 
else 
{
  echo '><br /><center><h1>Veuillez vérifié votre adresse email pour terminée l\'inscription !</h1></center>';
}

// Fin de session 
session_destroy();
?>