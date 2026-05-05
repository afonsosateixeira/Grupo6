INSERT INTO users(name, email, password) VALUES(
    'Admin Account',
    'admin@gmail.com',
    SHA2('123',512)
), (
    'Afonso Teixeira',
    'afonso@gmail.com',
    SHA2('123',512)
), (
    'Diogo Azevedo',
    'diogo@gmail.com',
    SHA2('123',512)
), (
    'Francisco Martins',
    'francisco@gmail.com',
    SHA2('123',512)
), (
    'Gonçalo Estrelado',
    'goncalo@gmail.com',
    SHA2('123',512)
), (
    'Hugo Giroto',
    'hugo@gmail.com',
    SHA2('123',512)
), (
    'Rúben Reis',
    'ruben@gmail.com',
    SHA2('123',512)
), (
    'Partner Account',
    'partner@gmail.com',
    SHA2('123',512)
), (
    'Veterinarian Account',
    'veterinarian@gmail.com',
    SHA2('123',512)
), (
    'Volunteer Account',
    'volunteer@gmail.com',
    SHA2('123',512)
);

INSERT INTO addresses(users_id, country, city, street, number, zip) VALUES(
    1,
    'Portugal',
    'Leiria',
    'Rua da PAM',
    'nº 1',
    '2500-901'
), (
    2,
    'Portugal',
    'Torres Novas',
    'Rua do Afonso',
    'nº 2',
    '2500-902'
), (
    3,
    'Portugal',
    'Leiria',
    'Rua do Diogo',
    'nº 3',
    '2500-903'
), (
    4,
    'Portugal',
    'Leiria',
    'Rua do Francisco',
    'nº 4',
    '2500-904'
), (
    5,
    'Portugal',
    'Leiria',
    'Rua do Goncalo',
    'nº 5',
    '2500-905'
), (
    6,
    'Portugal',
    'Leiria',
    'Rua do Hugo',
    'nº 6',
    '2500-906'
), (
    7,
    'Portugal',
    'Leiria',
    'Rua do Ruben',
    'nº 7',
    '2500-907'
), (
    8,
    'Portugal',
    'Leiria',
    'Rua do Parceiro',
    'nº 8',
    '2500-908'
), (
    9,
    'Portugal',
    'Leiria',
    'Rua do Veterinário',
    'nº 9',
    '2500-909'
), (
    10,
    'Portugal',
    'Leiria',
    'Rua do Voluntário',
    'nº 10',
    '2500-910'
);

INSERT INTO phones(users_id, number, is_primary) VALUES(
    1,
    '+351 900000001',
    TRUE
), (
    2,
    '+351 900000002',
    TRUE
), (
    3,
    '+351 900000003',
    TRUE
), (
    4,
    '+351 900000004',
    TRUE
), (
    5,
    '+351 900000005',
    TRUE
), (
    6,
    '+351 900000006',
    TRUE
), (
    7,
    '+351 900000007',
    TRUE
), (
    8,
    '+351 900000008',
    TRUE
), (
    9,
    '+351 900000009',
    TRUE
), (
    10,
    '+351 900000010',
    TRUE
), (
    1,
    '+351 900000002',
    FALSE
);

INSERT INTO admins(users_id) VALUES(
    1
), (
    2
), (
    3
), (
    4
), (
    5
), (
    6
), (
    7
);

INSERT INTO partners(users_id) VALUES(
    8
);

INSERT INTO veterinarians(users_id) VALUES(
    9
);

INSERT INTO volunteers(users_id) VALUES(
    10
);

INSERT INTO donations(users_id, name, nif, amount, notes)  VALUES(
    1,
    'Admin Account',
    200000001,
    50,
    NULL
), (
    NULL,
    NULL,
    NULL,
    70,
    'Espero que utilizem para aumentar a ração dos animais no abrigo.'
), (
    NULL,
    NULL,
    NULL,
    40,
    'Espero que ajude a garantir os cuidados dos animais no abrigo.'
), (
    NULL,
    'António',
    200000002,
    20,
    NULL
), (
	8,
	NULL,
	200000008,
	50,
	NULL
), (
	NULL,
	NULL,
	NULL,
	0.50,
	'Não posso dar muito mas espero que ajude'
), (
	NULL,
	NULL,
	NULL,
	5,
	'Não posso dar muito mas espero que ajude'
), (
	NULL,
	NULL,
	200000015,
	2.50,
	'Não posso dar muito mas espero que ajude'
), (
	NULL,
	NULL,
	200000016,
	0.50,
	NULL
), (
	NULL,
	'Miguel',
	200000017,
	10.50,
	NULL
);

INSERT INTO species(name) VALUES(
	'Cão'
), (
	'Gato'
);

INSERT INTO breeds(species_id,name) VALUES(
	1,
	'Labrador Retriever'
), (
	1,
	'Pastor Alemão'
), (
	1,
	'Bulldog Francês'
), (
	1,
	'Poodle'
), (
	1,
	'Golden Retriever'
), (
	2,
	'Siamês'
), (
	2,
	'Persa'
), (
	2,
	'Maine Coon'
), (
	2,
	'Bengal'
), (
	2,
	'Sphynx'
);

INSERT INTO animals(species_id, name, birthday) VALUES(
	1,
	'Rex',
	'2018-03-12'
), (
	2,
	'Luna',
	'2022-02-14'
), (
	1,
	'Bolt',
	'2020-07-25'
), (
	2,
	'Mia',
	'2020-09-09'
), (
	1,
	'Max',
	'2017-11-05'
), (
	2,
	'Nala',
	'2019-12-22'
), (
	1,
	'Simba',
	'2019-01-30'
), (
	2,
	'Chico',
	'2018-05-03'
), (
	1,
	'Toby',
	'2021-06-18'
), (
	2,
	'Oliver',
	'2021-10-11'
);

INSERT INTO shift_volunteers(volunteers_id, date, hour_start, hour_end, notes) VALUES(
	1,
	'2026-04-02',
	'09:00:00',
	'12:00:00',
	NULL
), (
	1,
	'2026-04-04',
	'14:00:00',
	'17:00:00',
	NULL
), (
	1,
	'2026-04-07',
	'08:00:00',
	'11:00:00',
	NULL
), (
	1,
	'2026-04-10',
	'16:00:00',
	'19:00:00',
	NULL
), (
	1,
	'2026-04-12',
	'11:00:00',
	'14:00:00',
	NULL
), (
	1,
	'2026-04-15',
	'13:00:00',
	'16:00:00',
	NULL
), (
	1,
	'2026-04-18',
	'17:00:00',
	'20:00:00',
	NULL
), (
	1,
	'2026-04-21',
	'10:00:00',
	'13:00:00',
	NULL
), (
	1,
	'2026-04-25',
	'15:00:00',
	'18:00:00',
	NULL
), (
	1,
	'2026-04-28',
	'12:00:00',
	'15:00:00',
	NULL
);

INSERT INTO shifts(hour_start, hour_end) VALUES(
	'08:00:00',
	'16:00:00'
), (
	'09:00:00',
	'17:00:00'
), (
	'10:00:00',
	'18:00:00'
), (
	'12:00:00',
	'20:00:00'
), (
	'14:00:00',
	'22:00:00'
), (
	'20:00:00',
	'08:00:00'
), (
	'22:00:00',
	'08:00:00'
), (
	'08:00:00',
	'12:00:00'
), (
	'16:00:00',
	'20:00:00'
), (
	'08:00:00',
	'20:00:00'
);