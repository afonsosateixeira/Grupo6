<?php
    session_start();

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'PAM');

    define('PAGES', [
        # Páginas de Front Office
        0 => [
            '404',
            'accessibility',
            'adoptionGuide',
            'animal_care',
            'animalCatalog',
            'animalDetails',
            'appointment',
            'contactos',
            'cookies',
            'dia_voluntario',
            'forbidden',
            'home',
            'login',
            'privacy',
            'regist',
            'termos',
            'perfis_voluntario'
        ],

        # Páginas de Back Office
        1 => [
            'adoptionProcess',
            'animalList',
            'dashboard'
        ]
    ]);