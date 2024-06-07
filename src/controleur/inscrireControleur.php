<?php 
function inscrireControleur($twig, $db){
    $form = array();
    if (isset($_POST['btInscrire'])){
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 =$_POST['inputPassword2'];
        $nom = $_POST['inputNom'];
        $prenom =$_POST['inputPrenom'];
        $role = 2;
        $form['valide'] = true;;
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&.])[A-Za-z\d@$!%?&.]{12,}$/';

        if (!preg_match($pattern, $inputPassword)) {
            $form['valide'] = false;
            $form['message'] = 'Le mot de passe doit contenir au moins 12 caractères, un chiffre, une minuscule, une majuscule et un caractère spécial.';
        }
        else {
            if ($inputPassword!=$inputPassword2){
                $form['valide'] = false;
                $form['message'] = 'Les mots de passe sont differents';
            }else {
                $utilisateur = new Utilisateur($db);
                $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), $role, $nom, $prenom);
                if (!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Problème d\'insertion dans la table utilisateur';
                }
            }
        }
        $form['email'] = $inputEmail;
        $form['role'] = $role;
    }
    echo $twig->render('inscrire.html.twig', array('form'=>$form));
   }
?>