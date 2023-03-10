<?php
session_start();
require_once 'Connexion/connexion.php';
$accesOk = false;

//PARTIE CONNEXION------------------------------------------------------------------------------------------------------
if(isset($_POST['btnCnx'])){
    if(empty($_POST['id'])){
        $messageErreurCnx['id'] ='L\'identifiant doit être renseigné';
    }
    else{
        $id= filter_var($_POST['id'],FILTER_VALIDATE_INT);
    }
    if(empty($_POST['nom'])){
        $messageErreurCnx['nom'] ='Le nom doit être renseigné';
    }
    else{
        $nom = htmlspecialchars($_POST['nom']);
    }

    if(!isset($messageErreurCnx)){
        $queryCnx ='SELECT * FROM proprietaires WHERE id_pers=:id AND nom=:nom ;';
        $prep = $pdo->prepare($queryCnx);
        $prep->bindValue(':id',$id);
        $prep->bindValue(':nom',$nom);
        $prep->execute();
        $array=$prep->fetch();

        if(empty($array)){
            $messageErreurCnx['userInconnu']='L\'utilisateur n\'existe pas';
            //header permet de faire des redirections en php => header('Location : url ou page de redirection'); exit; à la fin pour éviter d'executer le reste du code

        }
        else{
            $accesOk = true;
            $idRecup =$array['id_pers'];
            $nomRecup = $array['nom'];
            $prenom = $array['prenom'];
            $adresse = $array['adresse'];
            $ville = $array['ville'];
            $cp = $array['codepostal'];
            $_SESSION['id'] = $idRecup;
            $_SESSION['nom'] = $nomRecup;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['adresse'] = $adresse;
            $_SESSION['ville'] = $ville;
            $_SESSION['cp'] = $cp;
        }
    }
}
//PARTIE MODIFICATION---------------------------------------------------------------------------------------------------
if(isset($_POST['btnEnrg'])){
    if(empty($_POST['nom'])){
        $messageErreurEnrg['nom'] ='Le nom doit être renseigné';
    }
    else{
        $nomModif = htmlspecialchars($_POST['nom']);
    }
    if(empty($_POST['prenom'])){
        $messageErreurEnrg['prenom'] ='Le prenom doit être renseigné';
    }
    else{
        $prenomModif = htmlspecialchars($_POST['prenom']);
    }
    if(empty($_POST['adresse'])){
        $messageErreurEnrg['adresse'] ='L\'adresse doit être renseigné';
    }
    else{
        $adresseModif = htmlspecialchars($_POST['adresse']);
    }
    if(empty($_POST['cp'])){
        $messageErreurEnrg['cp'] ='Le code postal doit être renseigné';
    }
    else{
        $cpModif = htmlspecialchars($_POST['cp']);
    }
    if(empty($_POST['ville'])){
        $messageErreurEnrg['ville'] ='La ville doit être renseignée';
    }
    else{
        $villeModif = htmlspecialchars($_POST['ville']);
    }

    if(!isset($messageErreurEnrg)){
        $queryEnrg = 'UPDATE proprietaires SET nom=:nom, prenom=:prenom, adresse=:adresse, codepostal=:cp, ville=:ville WHERE id_pers=:id';
        $prep = $pdo->prepare($queryEnrg);
        $prep->bindValue(':nom',$nomModif);
        $prep->bindValue(':prenom',$prenomModif);
        $prep->bindValue(':adresse',$adresseModif);
        $prep->bindValue(':cp',$cpModif);
        $prep->bindValue(':ville',$villeModif);
        $prep->bindValue(':id',$_SESSION['id']);
        $prep->execute();


        $_SESSION['nom'] = $nomModif;
        $_SESSION['prenom'] = $prenomModif;
        $_SESSION['adresse'] = $adresseModif;
        $_SESSION['ville'] = $villeModif;
        $_SESSION['cp'] = $cpModif;
        $accesOk = true;
        $messageOK ='Vos modifications ont bien été prise en compte';
    }
    else{
        $accesOk = true;
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
    <title>Changement des informations</title>
    <link rel="stylesheet" href="style.css" media="screen">
</head>
<body>
    <form action="exo3.php" method="post">
        <fieldset>
            <legend>Accédez à vos informations</legend>
            <p><?= (isset($messageErreurCnx['userInconnu']))? $messageErreurCnx['userInconnu'] :'' ?></p>
            <div>
                <label for="id">Numéro d'identification</label>
                <input type="number" id="id" name="id">
                <span><?= (isset($messageErreurCnx['id']))?$messageErreurCnx['id'] :'' ?></span>
            </div>
            <div>
                <label for="nom">Nom de famille</label>
                <input type="text" id="nom" name="nom">
                <span><?=(isset($messageErreurCnx['nom']))?$messageErreurCnx['nom'] : '' ?></span>
            </div>
            <button name="btnCnx">Connexion</button>
        </fieldset>
    </form>
    <br>

    <p <?= (!$accesOk)? 'hidden =hidden':''  ?>><?=(isset($_SESSION['nom']) &&isset($_SESSION['prenom']))? 'Bonjour '.$_SESSION['nom'].' '.$_SESSION['prenom'] : '' ?></p>

    <br>
    <form action="exo3.php" method="post" <?= (!$accesOk)? 'hidden =hidden':''  ?>>
        <fieldset>

            <legend>Modification de vos informations</legend>
            <div>
                 <span><?= (isset($messageErreurEnrg['id']))? $messageErreurEnrg['id'] : ''?></span>
                <label for="nom">Nom de famille</label>
                <input type="text" id="nom" name="nom" value="<?=(isset($_SESSION['nom']))? $_SESSION['nom']:'' ?>">
                <span><?=(isset($messageErreurEnrg['nom']))? $messageErreurEnrg['nom'] : '' ?></span>
            </div>
                <div>
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?=(isset($_SESSION['prenom']))? $_SESSION['prenom']:'' ?>">
                <span><?= (isset($messageErreurEnrg['prenom']))? $messageErreurEnrg['prenom'] : ''?></span>
            </div>
            <div>
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse" value="<?=(isset($_SESSION['adresse']))? $_SESSION['adresse']:'' ?>">
                <span><?= (isset($messageErreurEnrg['adresse']))? $messageErreurEnrg['adresse'] : ''?></span>
            </div>
            <div>
                <label for="cp">Code Postal</label>
                <input type="text" id="cp" name="cp" value="<?=(isset($_SESSION['cp']))?$_SESSION['cp']:'' ?>">
                <span><?=(isset($messageErreurEnrg['cp']))? $messageErreurEnrg['cp'] : '' ?></span>
            </div>
            <div>
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville" value="<?=(isset($_SESSION['ville']))? $_SESSION['ville']:'' ?>">
                <span><?=(isset($messageErreurEnrg['ville']))? $messageErreurEnrg['ville'] : '' ?></span>
            </div>
            <button name="btnEnrg">Enregistrer</button><span><?=(isset($messageOK))? $messageOK : '' ?></span>
        </fieldset>
    </form>
</body>
</html>
