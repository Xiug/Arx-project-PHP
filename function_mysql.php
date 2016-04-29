/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */
 
<?php

// Enrengistrement des information de la requêtes dans un tableau
function tab_mysqli_connect($sql, $connect)
{
	$req = $connect->query($sql) or die('<center>Erreur SQL !</center>'.mysqli_error()); 
	$tab = mysqli_fetch_array($req);  
	mysqli_free_result ($req);
	return $tab;
}

// Simple connexion pour requêtes qui demande pas d'information
function mysqli_cox($sql, $connect)
{
	$req = $connect->query($sql) or die('<center>Erreur SQL !</center>'.mysqli_error());
}

// Connexion au serveur
function mysqli_open($host, $user, $database, $password)
{
	$connect = mysqli_connect($host, $user, $password, $database);
    if (mysqli_connect_errno())
    {
    	echo "La connexion au serveur MySQL n'a pas abouti : " . mysqli_connect_error();
    }
    return $connect;
}

?>