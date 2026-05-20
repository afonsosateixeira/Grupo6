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
            'donations',
            'forbidden',
            'home',
            'login',
            'missing_animals',
            'perfis_voluntario',
            'privacy',
            'regist',
            'termos',
            'vetProfile'
        ],

        # Páginas de Back Office
        1 => [
            'adoptionProcess',
            'animalList',
            'dashboard',
            'missing_animals',
            'user_list'
            'appointmentList',
            'vetList',
            'donationList',
            'listagemvoluntarios'
        ]
    ]);