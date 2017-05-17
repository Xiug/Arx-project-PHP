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
require_once'ppo.php';

// PPO_LOAD
load_option->inclusion();
load_option->basic();

// Vérification du Captcha
verif_option->captcha($captch, $captcha);

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

$cle = crypt_option->cle($pseudo);

echo "<br /><center><p> Etape 2 : Collecte des information</p></center>";

// Vérification des mots de passe
verif_option->mdp($password, $pass);

echo "<br /><center><p> Etape 3 : Mot de passe valide</p></center>";

// Sécurisation du mot de passe
$password = crypt_option->bcrypt($password);

echo "<br /><center><p> Etape 4 : Mot de passe sécuriser</p></center>";

// Vérification du nom utilisateur
verif_option->nom($pseudo, $connect);

echo "<br /><center><p> Etape 5 : Nom utilisateur valide</p></center>";

// Vérification de l'email
verif_option->mail($mail);

echo "<br /><center><p> Etape 6 : Adresse email valide </p></center>";

// Mise en forme et enrengistrement des informations
$creation = create_option->date_creation($date, $heure);

$naissance = create_option->date_naissance($jour, $mois, $annee);

$sql       = "SELECT valeur FROM inscription ORDER BY valeur DESC LIMIT 1";
$valeur    = mysql_option->tab($sql, $connect);
$valeur    = $valeur['valeur'];
$valeur    = $valeur + 1;
$ip        = get_ip();
$sql       = 'INSERT INTO `inscription`(`valeur`, `pseudo`, `mdp`, `ip`, `email`, `naissance`, `code`, `creation`) 
		VALUES ("'.$valeur.'", "'.$pseudo.'", "'.$password.'", "'.$ip.'", "'.$mail.'", "'.$naissance.'", "'.$cle.'", "'.$creation.'")';

//PhpMailer

// on envoie la requête
mysql_option->req($sql, $connect);
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