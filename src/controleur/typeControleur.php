<?php
function typeControleur($twig,$db){
    $form = array();
    $type = new Type($db);

    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ( $cocher as $id){
            $exec=$type->delete($id);
            if (!$exec){
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table type';
            }
        }
    }
    if(isset($_GET['id'])){
        $exec=$type->delete($_GET['id']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table type';
        }else{
            $form['valide'] = true;
            $form['message'] = 'type supprimé avec succès';
        }
    }
    $limite=5;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }
    else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }
    $r = $type->selectCount();
    $nb = $r['nb'];
    
    $liste = $type->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    $form['nopage'] = $nopage;
    echo $twig->render('type.html.twig', array('form'=>$form,'liste'=>$liste));

}

function typeAjoutControleur($twig, $db){
    $form = array();

    if(isset($_POST['btAjouter'])){
        $type = new Type($db);
        $libelle = $_POST['inputLibelle'];
        $exec = $type->insert($libelle);
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table type';
        }
        else{
            $form['valide'] = true;
            $form['message'] = 'Type ajouté avec succès';
        }
    }


    echo $twig->render('type-ajout.html.twig', array());
    
}

function typeModifControleur($twig, $db){
    $form = array();
    if(isset($_GET['id'])){
    $type = new Type($db);
    $unType = $type->selectById($_GET['id']); 
    if ($unType!=null){
        $form['type'] = $unType;
    }
    else{
        $form['message'] = 'Type incorrect';
    }
    }
    else{
        if(isset($_POST['btModifier'])){
            $id = $_POST['id'];
            $libelle = $_POST['inputLibelle'];
            if(empty($libelle)){
                $form['valide'] = false;
                $form['message'] = 'Le champ est vide';
            }
            else{
            $type = new Type($db);
            $exec=$type->update($id, $libelle);
            if(!$exec){
                $form['valide'] = false;
                $form['message'] = 'Echec de la modification';
            }else{
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
        }
    }
    }else{
        $form['message'] = 'Type non précisé';
    }
}
    echo $twig->render('type-modif.html.twig', array('form'=>$form));
   }


?>