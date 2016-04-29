/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <xuxiugx@gmail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Guillaume Durand
 * ----------------------------------------------------------------------------
 */
 
<?php
session_start();
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
?>