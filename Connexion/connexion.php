<?php
try{
    $dsn = 'mysql:host=localhost;dbname=voitures_BDD'; //adresse de connexion à la base de données
    $options =[PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"]; //définition de l'encodage
    $pdo = new PDO($dsn,'userCodePHP','j/GU6NRa/_R0uqUi',$options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // pour la gestion des exceptions
    echo'Je suis bien connectée !'.'<br>';

}catch(PDOException $e){
    echo'La connexion a échoué...:'.$e->getMessage();
}