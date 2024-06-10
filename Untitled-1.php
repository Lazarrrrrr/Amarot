<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $projet = $_POST['projet'];

    $to = 'votre-email@example.com'; // Changez ceci par votre adresse e-mail
    $subject = 'Nouvelle soumission de formulaire';
    $message = "Prénom: $prenom\nNom: $nom\nE-mail: $email\nTéléphone: $telephone\nProjet: $projet";
    $headers = 'From: webmaster@example.com'; // Adaptez selon votre configuration

    mail($to, $subject, $message, $headers);
    echo 'Merci de nous avoir contacté!';
}
?>
