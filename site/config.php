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
            'events',
            'forbidden',
            'home',
            'login',
            'missing_animals',
            'notifications',
            'perfis_voluntario',
            'privacy',
            'regist',
            'sobrenos',
            'termos',
            'vetProfile'
        ],

        # Páginas de Back Office
        1 => [
            'adoptionProcess',
            'animalList',
            'appointmentList',
            'dashboard',
            'donationList',
            'eventsList',
            'listagemvoluntarios',
            'missing_animals',
            'medicalHistory',
            'user_list',
            'vetList'
        ]
    ]);