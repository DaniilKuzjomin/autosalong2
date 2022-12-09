<?php

$kasutaja='kuzjomin'; // d113365_daniil
$server='localhost'; // d113365.mysql.zonevs.eu
$andmebaas='kuzjomin'; // d113365_baas
$salasyna='123456';

//teeme käsk mis ühendab andmebaasiga
$yhendus= new mysqli($server,$kasutaja,$salasyna,$andmebaas);
$yhendus -> set_charset('UTF8');

/*
CREATE TABLE loomad(
    id int PRIMARY key AUTO_INCREMENT,
    loomanimi varchar(15) UNIQUE,
    vanus int,
    pilt text)
 */


?>
