/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */

<?php
require_once 'captch/captch.php';
echo'
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css.css">
      <title>site</title>
   </head>
	 <body>
		<br />
		<form method="post" action="register.php" enctype="multipart/form-data">
				<input type="text" placeholder="Nom utilisateur" name="user" id="user" required="1"><br />
				<input type="password" placeholder="Mot de passe" name="password" id="password" required="1"><br />
				<input type="password" placeholder="Confirmé le mot de passe" name="pass" id="pass" required="1"><br />
				<input type="text" placeholder="Adresse email" name="email" id="email" required="1"><br />
				<span>Date de naissance</span><br />
				<input name="jour" id="jour" required="1" type="number" min="1" max="31"></input>
				<input name="mois" id="mois" required="1" type="number" min="1" max="12"></input>
				<input name="annee" id="annee" required="1" type="number" min="1800" max="2200"></input><br/>
				<input type="text" placeholder="Retaper le code" name="code" id="code" required="1"><br />
				<img src="captch/captch.png" alt="Code"><br />
				<span>Je confirme avoir pris connaissance du <a href="#"target="_blank"> réglement </a><span>
				<input  name="rules" id="rules" required="1" type="checkbox"></input>
				<input  type="submit" value="S\'enrengistrer"></form>
	</body>';
?>