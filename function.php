/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */

<?php

// Inclusion 
require_once 'Bcrypt.php';
require_once 'phpmailer/class.phpmailer.php';
require_once 'mysqli_connect.php';

//Function Bcrypt
function bcrypt($password)
{
	$password = Bcrypt::hashPassword($password);
	return $password;
}

function bcrypt_verif($password, $hash)
{
	return Bcrypt::checkPassword($password, $hash);
}
// Function pour récuperer une vraie ip
function get_ip()
{
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}

// Function pour créer une clé grâce à un nom
function load_cle($name)
{
	$la  = 'abcdefghijklmnopqrstuvwxyz';
	$l1  = $la[mt_rand(0, strlen($la) - 1)];
	$l2  = $name;
	$l3  = $la[mt_rand(0, strlen($la) - 1)];
	$n1  = rand(1000000000,1500000000000);
	$n2  = rand(1,1000000000);
	$cle = $l1.$l2.$n1.$l3.$n2;
	$cle = Bcrypt::hashPassword($cle);
	return $cle;
}

// Function à charger en premiere pour un bon rendu de pages !
function load_base()
{
	date_default_timezone_set('Europe/Paris');
	echo "<meta content='text/html; charset=utf-8' http-equiv='content-type'>";
}

// Function de vérification des mots de passe
function mdp($pass, $password)
{
	if ($password != $pass)
	{
		$msg       = "Les deux mots de passe ne correspondent pas";
		echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
		exit();
	}
	if (strlen($password) < 8)
	{
		$msg       = "Mot de passe trop court (minimun 8 caractère)";
		echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
		exit();
	}
	if (strlen($password) > 30)
	{
		$msg       = "Mot de passe trop long (maximun 30 caractère)";
		echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
		exit();
	}
}

// Vérifcation du nom utilisateur
function verif_nom($pseudo, $connect)
{
	if (strlen($pseudo) < 3)
	{
		$msg     = "Nom utilisateur trop court minimun 3 caractère";
		echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
		exit();

	}
	if (strlen($pseudo) > 50)
	{
		$msg     = "Nom utilisateur trop long maximun 50 caractère";
		echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
		exit();

	}
	$sql         = 'SELECT pseudo FROM inscription WHERE pseudo LIKE"'.$pseudo.'"';
	$name        = tab_mysqli_connect($sql, $connect);
	$nom         = strtolower($pseudo);
	$utilisateur = strtolower($name['pseudo']);
	if ($nom ==  $utilisateur)
	{
		return $stock = 1;
	}
	return $stock = 0;
}

// Vérification d'email
function verif_mail()
{
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
}

?>