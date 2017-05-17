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
require_once 'mysqli_connect.php';

class mysql_option
{

// Enrengistrement des information de la requêtes dans un tableau
	public function tab($sql, $connect)
	{
		$req = $connect->query($sql) or die('<center>Erreur SQL !</center>'.mysqli_error()); 
		$tab = mysqli_fetch_array($req);  
		mysqli_free_result ($req);
		return $tab;
	}

// Simple connexion pour requêtes qui demande pas d'information
	public function req($sql, $connect)
	{
		$req = $connect->query($sql) or die('<center>Erreur SQL !</center>'.mysqli_error());
	}

// Connexion au serveur
	public function connect($host, $user, $database, $password)
	{
		$connect = mysqli_connect($host, $user, $password, $database);
    	if (mysqli_connect_errno())
    	{
    		echo "La connexion au serveur MySQL n'a pas abouti : " . mysqli_connect_error();
   		}
    return $connect;
	}

}

$mysql_option = new mysql_option;

?>