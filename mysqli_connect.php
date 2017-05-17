/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */

<?php

//Inclussion 
	require_once  'ppo_mysql.php';
	
    $host       = "host";  // Nom de l'hôte 
    $database   = "database"; // Nom de base de données
    $user       = "user"; // Utilisateur
    $password   = "password"; // Mot de passe 

    $connect = mysql_option->connect($host, $user, $database, $password);

?>
