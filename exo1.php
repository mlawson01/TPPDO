<?php
require_once './Connexion/connexion.php';
$query='SELECT * FROM modeles;';
 //prep est un PDOstatement

$stmt =$pdo->query($query);
$array =$stmt->fetchAll();
var_dump($array);

//foreach ($array as $article){
//    echo 'Article : '.$article ['libelle' ].' à '.$article [2].'€<br>' ;
//}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tableau de modèles</title>
    <link rel="stylesheet" href="style.css" media="screen">
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Identifiant</th>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Carburant</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($array as $modele) : ?>
        <tr>
            <td>
              <?=$modele['id_modele'] ?>  
            </td>
            <td>
                <?=$modele['marque'] ?>
            </td>
            <td>
                <?=$modele['modele'] ?>
            </td>
            <td>
                <?=$modele['carburant'] ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
    
</table>
</body>
</html>
