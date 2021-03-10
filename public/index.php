<?php

session_start();

if (!isset($_SESSION['load'])) {
    $_SESSION = [
        'load' => true,
        'authorize' => [
            'level1' => true,
            'level2' => false
        ]
    ];
}

require '../vendor/autoload.php';

require '../App/Router/routes.php';

/* WARNING Code non executé après l'appel à la route */
