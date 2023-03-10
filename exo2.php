<?php
require_once 'Connexion/connexion.php';
if(isset($_POST['btnAjout'])){
    if(!empty($_POST['id'])){
        $id = htmlspecialchars($_POST['id']);
    }
    else{
        $messageErreur['id'] ='L\'identifiant doit être renseigné';
    }
    if(!empty($_POST['marque'])){
        $marque = htmlspecialchars($_POST['marque']);
    }
    else{
        $messageErreur['marque'] ='La marque doit être renseignée';

    }
    if(!empty($_POST['modele'])){
        $modele = htmlspecialchars($_POST['modele']);
    }
    else{
        $messageErreur['modele'] ='Le modèle doit être renseigné';
    }
    if(!empty($_POST['carburant'])){
        $carburant = htmlspecialchars($_POST['carburant']);
    }
    else {
        $messageErreur['carburant'] =  'Le type de carburant doit être sélectionné';
    }
    var_dump($messageErreur);
    if(!isset($messageErreur)){
        $query ='INSERT INTO modeles (id_modele,marque,modele,carburant) VALUES (:id,:marque,:modele,:carburant);';
        $prep = $pdo->prepare($query);
        $prep->bindParam(':id',$id);
        $prep->bindParam(':marque',$marque);
        $prep->bindParam(':modele',$modele);
        $prep->bindParam(':carburant',$carburant);
        $prep->execute();

    }
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insérer un nouveau modèle</title>
    <link rel="stylesheet" href="style.css" media="screen">
</head>
<body>
    <form action="exo2.php" method="post">
        <fieldset>
            <legend>Ajouter un nouveau modèle</legend>
            <div>
                <label for="id">Identifiant*</label>
                <input type="text" id="id" name="id" value="<?=(isset($id))? $id : '' ?>"><span><?= (isset($messageErreur['id']))? $messageErreur['id'] : '' ?></span>
            </div>
            <div>
                <label for="marque">Marque*</label>
                <input type="text" id="marque" name="marque" value="<?=(isset($marque))? $marque : '' ?>"><span><?= (isset($messageErreur['marque']))? $messageErreur['marque'] : '' ?></span>
            </div>
            <div>
                <label for="modele">Modèle*</label>
                <input type="text" id="modele" name="modele" value="<?=(isset($modele))? $modele : '' ?>"><span><?= (isset($messageErreur['modele']))? $messageErreur['modele'] : '' ?></span>
            </div>
            <p>Type de carburant* :</p>
            <div>
                <input type="radio" id="essence" name="carburant" value="essence" >
                <label for="essence">Essence</label>
            </div>

            <div>
                <input type="radio" id="diesel" name="carburant" value="diesel">
                <label for="diesel">Diesel</label>
            </div>
            <div>
                <input type="radio" id="gpl" name="carburant" value="gpl">
                <label for="gpl">GPL</label>
            </div>
            <div>
                <input type="radio" id="electrique" name="carburant" value="electrique">
                <label for="electrique">Electrique</label>
            </div>
            <span><?= (isset($messageErreur['carburant']))? $messageErreur['carburant'] : '' ?></span>
            <br>
            <button name="btnAjout">Ajouter</button>
        </fieldset>
    </form>
</body>
</html>
