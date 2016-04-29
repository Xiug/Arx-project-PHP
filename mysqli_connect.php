/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */

<?php
	require_once  'function_mysql.php';
    $host       = "host";
    $database   = "database";
    $user       = "user";
    $password   = "password";

    $connect = mysqli_open($host, $user, $database, $password);
?>
