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
require_once 'ppo_mysql';

class crypt_option
{

//Function pour crypter ses mots de passe
	public function bcrypt($password)
	{
		$password = Bcrypt::hashPassword($password);
		return $password;
	}

// Function pour comparer les mots de passe si il on à un crypter avec bcrypt
	public function bcrypt_verif($password, $hash)
	{
		return Bcrypt::checkPassword($password, $hash);
	}


// Function pour créer une clé grâce à un nom
	public function cle($name)
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

}

class verif_option
{

// Function pour récuperer une vraie ip
	public function ip()
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
		else 
		{
			return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		}
	}

// Function de vérification des mots de passe
	public function mdp($pass, $password)
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
	public function nom($pseudo, $connect)
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
		$name 		 = mysql_option->tab($sql, $connect);
		$nom         = strtolower($pseudo);
		$utilisateur = strtolower($name['pseudo']);
		if ($nom ==  $utilisateur)
		{
			$msg     = "Nom utilisateur déjà utilisé";
			echo "<br /><center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>"; 
			exit();
		}
	}

// Vérification d'email
	public function mail($mail)
	{
		$sql         = 'SELECT email FROM inscription WHERE email LIKE"'.$mail.'"';
		$name        = mysql_option->tab($sql, $connect);
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

// Vérification de captcha
	public function captcha($captch, $captcha)
	{
		if ($captch != $captcha)
		{
			$msg     = "Le captcha ne correspondent pas";
			echo "<center><p>$msg<br/><a href='../register.php'>Retour</a></p></center>";
			exit();
		}
	}

}

class load_option
{

// Function à charger en premiere pour un bon rendu de pages !
	public function basic()
	{
		date_default_timezone_set('Europe/Paris');
		echo "<meta content='text/html; charset=utf-8' http-equiv='content-type'>";
	}

// Inclusion basique 
	public function inclusion()
	{
		require_once 'ppo_mysql.php';
		require_once 'phpmailer/class.phpmailer.php';

	}
}

class create_option
{

	//Captcha 
	public function captcha()
	{
		$la = 'abcdefghijklmnpqrstuvwxyz';
		$l1 = $la[mt_rand(0, strlen($la) - 1)];
		$l2 = $la[mt_rand(0, strlen($la) - 1)];
		$l3 = $la[mt_rand(0, strlen($la) - 1)];
		$n1 = rand(1000,15000);
		$n2 = rand(1,1000);
		$captch = $l1.$l2.$n1.$l3.$n2;
		$image = imagecreate(125,50);
		$c = imagecolorallocate($image, 0, 0, 0);
		$c1 = imagecolorallocate($image, 225, 225, 225);
		imagestring($image, 20, 20, 20, "$captch", $c1);
		imagecolortransparent($image, $c);
		imagepng($image, "captch/captch.png");
		$_SESSION['captch'] = $captch;
	}

	public function date_creation($date, $heure)
	{
		$creation = $date.' à '.$heure;
		return $creation;
	}

	public function date_naissance($jour, $mois, $annee)
	{
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
		return $naissance;
	}
}

$crypt_option = new crypt_option;
$verif_option = new verif_option;
$load_option = new load_option;
$create_option = new create_option;

?>
