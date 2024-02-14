<?php
    // Récupération de la variable depuis le corps de la requête POST
    $maVariablePHP = $_POST['variable'];

    // Utilisation de la variable dans le script PHP
    echo "La variable PHP reçue est : " . $maVariablePHP;
?>