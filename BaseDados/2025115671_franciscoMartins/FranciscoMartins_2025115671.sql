DROP DATABASE IF EXISTS pam;
CREATE DATABASE pam;
USE pam;

CREATE TABLE Users (
    id_user int unsigned auto_increment,
    name varchar(100) not null,
    phone varchar(15) not null,
    email varchar(150) not null,
    nif char(9),
    birthday date not null,
    pass varchar(256) not null,
    address varchar(255) not null,
    type enum('Admin', 'Customer', 'Partner', 'Volunteer', 'Vet') not null,
    gender enum('F', 'M', 'Other') default 'Other',
    constraint pk_users primary key (id_user),
    constraint uk_users_email unique (email),
    constraint uk_users_nif unique (nif)
) ENGINE=innoDB;

CREATE TABLE Species (
    id_species int unsigned auto_increment,
    name_species varchar(30) not null,
    constraint pk_species primary key (id_species),
    constraint uk_species_name unique (name_species)
) ENGINE=innoDB;

CREATE TABLE Admin (
    id_admin int unsigned,
    user_id int unsigned,
    constraint pk_admin primary key (id_admin),
    constraint fk_admin_user foreign key (user_id) references Users(id_user) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Partners (
    id_partner int unsigned auto_increment,
    user_id int unsigned not null,
    type_industry varchar(50),
    data_regist datetime default current_timestamp,
    constraint pk_partners primary key (id_partner),
    constraint fk_partners_user foreign key (user_id) references Users(id_user)
) ENGINE=innoDB;

CREATE TABLE Volunteers (
    id_volunteer int unsigned auto_increment,
    user_id int unsigned not null, 
    city varchar(50),
    availability_notes text,
    constraint pk_volunteers primary key (id_volunteer),
    constraint fk_volunteers_user foreign key (user_id) references Users(id_user) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Veterinarians (
    id_vet int unsigned auto_increment,
    user_id int unsigned not null,
    constraint pk_vets primary key (id_vet),
    constraint fk_vets_user foreign key (user_id) references Users(id_user) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Customers (
    id_customer int unsigned auto_increment,
    id_user int unsigned not null,
    city varchar(50),
    constraint pk_customers primary key (id_customer),
    constraint fk_customers_user foreign key (id_user) references Users(id_user) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Breeds (
    id_breed int unsigned auto_increment,
    name_breed varchar(40) not null,
    id_species int unsigned not null,
    constraint pk_breeds primary key (id_breed),
    constraint fk_breeds_species foreign key (id_species) references Species(id_species)
) ENGINE=innoDB;

CREATE TABLE Horary (
    id_horary int unsigned auto_increment,
    id_volunteer int unsigned not null, 
    day_week varchar(20) not null,
    start_time time not null,
    end_time time not null,
    constraint pk_horary primary key (id_horary),
    constraint fk_horary_volunteer foreign key (id_volunteer) references Volunteers(id_volunteer) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Pets (
    id_pet int unsigned auto_increment,
    name varchar(30) not null,
    gender enum ('F','M') not null default 'M',
    id_breed int unsigned not null,
    size enum('Small', 'Medium', 'Large', 'Giant') default 'Medium',
    description text,
    status enum('Active', 'Inactive', 'Deceased') default 'Active',
    birth_date DATE,
    id_owner int unsigned not null,
    constraint pk_pets primary key(id_pet),
    constraint fk_pets_owner foreign key (id_owner) references Customers(id_customer),
    constraint fk_pets_breed foreign key (id_breed) references Breeds(id_breed)
) ENGINE=innoDB;

CREATE TABLE Appointments (
    id_appointment int unsigned auto_increment,
    id_pet int unsigned not null,
    id_vet int unsigned not null, 
    appointment_date datetime not null,
    shift enum('10:00', '14:00', '16:00') not null,
    status enum('Scheduled', 'Completed', 'Cancelled') default 'Scheduled',
    constraint pk_appointments primary key(id_appointment),
    constraint fk_appointments_vet foreign key (id_vet) references Veterinarians(id_vet),
    constraint fk_appointments_pet foreign key(id_pet) references Pets(id_pet) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Results (
    id_result int unsigned auto_increment,
    id_appointment int unsigned not null, 
    height decimal(5,2),
    weight decimal(5,2),
    diagnosis text,
    consultation_details text,
    is_vaccinated boolean default false,
    is_neutered boolean default false,
    is_sterilized boolean default false,
    has_diseases boolean default false,
    disease_notes text,
    constraint pk_results primary key (id_result),
    constraint fk_results_appointment foreign key (id_appointment) references Appointments(id_appointment) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Donations_table (
    id_donation int unsigned auto_increment,
    user_id int unsigned,
    amount decimal(10,2) not null,
    text_donation text,
    data_donation datetime default current_timestamp not null,
    constraint pk_donations primary key (id_donation),
    constraint fk_donations_user foreign key (user_id) references Users(id_user)
) ENGINE=innoDB;

CREATE TABLE Participants (
    id_participant int unsigned auto_increment,
    user_id int unsigned not null,
    constraint pk_participants primary key (id_participant),
    constraint fk_participants_user foreign key (user_id) references Users(id_user)
) ENGINE=innoDB;

CREATE TABLE Events (
    id_event int unsigned auto_increment,
    event_name varchar(100) not null,
    event_date date not null,
    description text,
    id_volunteer int unsigned, 
    id_participant int unsigned, 
    constraint pk_events primary key (id_event),
    constraint fk_events_volunteer foreign key (id_volunteer) references Volunteers(id_volunteer),
    constraint fk_events_participant foreign key (id_participant) references Participants(id_participant)
) ENGINE=innoDB;

CREATE TABLE Adoption_processes (
    id_adoption int unsigned auto_increment,
    adopter_id int unsigned not null, 
    animal_id int unsigned not null, 
    status varchar(30) default 'Pendente' not null,
    start_date date not null,
    end_date date,
    notes text,
    constraint pk_adoption_processes primary key (id_adoption),
    constraint fk_adopters foreign key(adopter_id) references Customers(id_customer) on delete cascade,
    constraint fk_animals_adoption foreign key(animal_id) references Pets(id_pet) on delete cascade
) ENGINE=innoDB;

CREATE TABLE Lost_animals (
    id_lost int unsigned auto_increment,
    id_pet int unsigned not null,
    city varchar(50) not null,
    date_lost date not null,
    details text,
    id_owner int unsigned not null,
    is_rescued boolean default false,
    constraint pk_lost_animals primary key (id_lost),
    constraint fk_lost_pet foreign key (id_pet) references Pets(id_pet),
    constraint fk_lost_owner foreign key (id_owner) references Customers(id_customer)
) ENGINE=innoDB;

INSERT INTO Users (name, phone, email, nif, birthday, pass, address, type, gender) VALUES
('Ana Silva', '912345678', 'ana@email.com', '123456789', '1990-05-15', 'hash123', 'Rua A, Lisboa', 'Admin', 'F'),
('João Santos', '922345678', 'joao@email.com', '223456789', '1985-10-20', 'hash123', 'Rua B, Porto', 'Customer', 'M'),
('Maria Costa', '932345678', 'maria@email.com', '323456789', '1992-03-12', 'hash123', 'Rua C, Coimbra', 'Volunteer', 'F'),
('Pedro Rocha', '962345678', 'pedro@email.com', '423456789', '1988-07-30', 'hash123', 'Rua D, Braga', 'Vet', 'M'),
('Lúcia Mendes', '910000001', 'lucia@email.com', '523456789', '1995-12-01', 'hash123', 'Rua E, Faro', 'Partner', 'F'),
('Carlos Vale', '910000002', 'carlos@email.com', '623456789', '1980-01-25', 'hash123', 'Rua F, Aveiro', 'Customer', 'M'),
('Sofia Paiva', '910000003', 'sofia@email.com', '723456789', '1993-06-14', 'hash123', 'Rua G, Setúbal', 'Volunteer', 'F'),
('Rui Bento', '910000004', 'rui@email.com', '823456789', '1987-09-09', 'hash123', 'Rua H, Évora', 'Vet', 'M'),
('Marta Cruz', '910000005', 'marta@email.com', '923456789', '1991-11-22', 'hash123', 'Rua I, Viseu', 'Customer', 'F'),
('Tiago Lima', '910000006', 'tiago@email.com', '103456789', '1989-04-05', 'hash123', 'Rua J, Leiria', 'Customer', 'M');

INSERT INTO Species (name_species) VALUES ('Dog'), ('Cat');

INSERT INTO Admin (id_admin, user_id) VALUES (1, 1);

INSERT INTO Partners (user_id, type_industry) VALUES (5, 'Pet Food');

INSERT INTO Volunteers (user_id, city, availability_notes) VALUES (3, 'Coimbra', 'Fins de semana'), (7, 'Setúbal', 'Manhãs');

INSERT INTO Veterinarians (user_id) VALUES (4), (8);

INSERT INTO Customers (id_user, city) VALUES (2, 'Porto'), (6, 'Aveiro'), (9, 'Viseu'), (10, 'Leiria');

INSERT INTO Breeds (name_breed, id_species) VALUES 
('Labrador', 1), ('Poodle', 1), ('Beagle', 1), ('Bulldog', 1), ('Golden Retriever', 1),
('Persa', 2), ('Siamês', 2), ('Maine Coon', 2), ('Bengala', 2), ('Ragdoll', 2);

INSERT INTO Horary (id_volunteer, day_week, start_time, end_time) VALUES 
(1, 'Segunda', '09:00', '12:00'), (1, 'Terça', '09:00', '12:00'), (1, 'Quarta', '09:00', '12:00'),
(1, 'Quinta', '09:00', '12:00'), (1, 'Sexta', '09:00', '12:00'), (2, 'Sábado', '10:00', '18:00'),
(2, 'Domingo', '10:00', '18:00'), (1, 'Sábado', '09:00', '13:00'), (2, 'Segunda', '14:00', '18:00'),
(2, 'Quarta', '14:00', '18:00');

INSERT INTO Pets (name, gender, id_breed, size, description, id_owner) VALUES 
('Bobi', 'M', 1, 'Large', 'Muito dócil', 1),
('Tareco', 'M', 6, 'Small', 'Gosta de dormir', 1),
('Luna', 'F', 2, 'Medium', 'Energética', 2),
('Fofinha', 'F', 7, 'Small', 'Arisca', 2),
('Max', 'M', 3, 'Medium', 'Caçador', 3),
('Simba', 'M', 8, 'Large', 'Brincalhão', 3),
('Mel', 'F', 4, 'Small', 'Calma', 4),
('Kitty', 'F', 9, 'Medium', 'Elegante', 4),
('Rocky', 'M', 5, 'Large', 'Guarda', 1),
('Mia', 'F', 10, 'Medium', 'Sociável', 2);

INSERT INTO Appointments (id_pet, id_vet, appointment_date, shift) VALUES 
(1, 1, '2023-10-01 10:00:00', '10:00'), (2, 1, '2023-10-01 14:00:00', '14:00'),
(3, 2, '2023-10-02 10:00:00', '10:00'), (4, 2, '2023-10-02 16:00:00', '16:00'),
(5, 1, '2023-10-03 10:00:00', '10:00'), (6, 1, '2023-10-03 14:00:00', '14:00'),
(7, 2, '2023-10-04 10:00:00', '10:00'), (8, 2, '2023-10-04 16:00:00', '16:00'),
(9, 1, '2023-10-05 10:00:00', '10:00'), (10, 2, '2023-10-05 14:00:00', '14:00');

INSERT INTO Results (id_appointment, height, weight, diagnosis) VALUES 
(1, 60.5, 30.2, 'Saudável'), (2, 25.0, 4.5, 'Vacinação em dia'),
(3, 40.0, 12.0, 'Check-up anual'), (4, 22.0, 3.8, 'Desparasitação'),
(5, 45.0, 15.0, 'Otite leve'), (6, 70.0, 35.0, 'Saudável'),
(7, 30.0, 8.0, 'Alergia alimentar'), (8, 28.0, 5.0, 'Saudável'),
(9, 65.0, 32.0, 'Ferida na pata'), (10, 35.0, 7.5, 'Saudável');

INSERT INTO Donations_table (user_id, amount, text_donation) VALUES 
(2, 50.00, 'Ajuda mensal'), (6, 20.00, 'Para ração'), (9, 100.00, 'Donativo anónimo'),
(10, 10.00, 'Pequena ajuda'), (2, 30.00, 'Campanha inverno'), (6, 15.00, 'Doação'),
(3, 5.00, 'Voluntário ajuda'), (5, 500.00, 'Patrocínio Partner'), (1, 50.00, 'Admin contribuição'),
(9, 25.00, 'Apoio exames');

INSERT INTO Participants (user_id) VALUES (1), (2), (3), (4), (5), (6), (7), (8), (9), (10);

INSERT INTO Events (event_name, event_date, description, id_volunteer, id_participant) VALUES 
('Cãominhada', '2023-11-01', 'Passeio no parque', 1, 1),
('Workshop Gatos', '2023-11-05', 'Cuidados básicos', 1, 2),
('Feira de Adoção', '2023-11-10', 'Venha adotar', 2, 3),
('Recolha Alimentos', '2023-11-15', 'Supermercado X', 2, 4),
('Gala Solidária', '2023-12-01', 'Jantar beneficente', 1, 5),
('Vacinação Comunitária', '2023-12-05', 'Raiva', 2, 6),
('Aula de Treino', '2023-12-10', 'Obediência', 1, 7),
('Palestra Bem-estar', '2023-12-12', 'Auditório Municipal', 2, 8),
('Dia Aberto', '2023-12-15', 'Visita ao abrigo', 1, 9),
('Mercadinho Pet', '2023-12-20', 'Venda de produtos', 2, 10);

INSERT INTO Adoption_processes (adopter_id, animal_id, status, start_date) VALUES 
(1, 1, 'Concluído', '2023-01-01'), (2, 3, 'Pendente', '2023-09-01'),
(3, 5, 'Em Análise', '2023-09-05'), (4, 7, 'Concluído', '2023-02-10'),
(1, 9, 'Pendente', '2023-09-10'), (2, 10, 'Cancelado', '2023-08-01'),
(3, 2, 'Concluído', '2023-03-15'), (4, 4, 'Em Análise', '2023-09-12'),
(1, 6, 'Pendente', '2023-09-14'), (2, 8, 'Concluído', '2023-04-20');

INSERT INTO Lost_animals (id_pet, city, date_lost, details, id_owner) VALUES 
(1, 'Lisboa', '2023-08-01', 'Fugiu do quintal', 1),
(3, 'Porto', '2023-08-05', 'Assustou-se com foguetes', 2),
(5, 'Coimbra', '2023-08-10', 'Visto perto do rio', 3),
(7, 'Faro', '2023-08-12', 'Tem coleira azul', 4),
(2, 'Lisboa', '2023-08-15', 'Gato de interior', 1),
(4, 'Porto', '2023-08-20', 'Muito medrosa', 2),
(6, 'Aveiro', '2023-08-22', 'Porta ficou aberta', 3),
(8, 'Leiria', '2023-08-25', 'Responde pelo nome', 4),
(9, 'Lisboa', '2023-08-28', 'Chip ativo', 1),
(10, 'Porto', '2023-08-30', 'Recompensa-se', 2);

-- ==========================================
-- 3. VISTAS (VIEWS)
-- ==========================================

CREATE OR REPLACE VIEW v_detalhes_pets AS
SELECT 
    p.id_pet,
    p.name AS pet_name,
    s.name_species AS especie,
    b.name_breed AS raca,
    u.name AS dono_nome,
    p.status
FROM Pets p
JOIN Breeds b ON p.id_breed = b.id_breed
JOIN Species s ON b.id_species = s.id_species
JOIN Customers c ON p.id_owner = c.id_customer
JOIN Users u ON c.id_user = u.id_user;

CREATE OR REPLACE VIEW v_lista_veterinarios AS
SELECT 
    v.id_vet,
    u.name,
    u.email,
    u.phone
FROM Veterinarians v
JOIN Users u ON v.user_id = u.id_user
ORDER BY u.name;

CREATE OR REPLACE VIEW v_resumo_consultas AS
SELECT 
    a.appointment_date,
    a.shift,
    p.name AS pet_name,
    u.name AS vet_name,
    a.status
FROM Appointments a
JOIN Pets p ON a.id_pet = p.id_pet
JOIN Veterinarians v ON a.id_vet = v.id_vet
JOIN Users u ON v.user_id = u.id_user
ORDER BY a.appointment_date DESC;

CREATE OR REPLACE VIEW v_voluntarios_horarios AS
SELECT 
    u.name AS voluntario,
    h.day_week,
    h.start_time,
    h.end_time,
    v.city
FROM Volunteers v
JOIN Users u ON v.user_id = u.id_user
JOIN Horary h ON v.id_volunteer = h.id_volunteer;

CREATE OR REPLACE VIEW v_ranking_doacoes AS
SELECT 
    u.name AS doador,
    u.type AS tipo_utilizador,
    (d.id_donation) AS total_vezes_doou,
    (d.amount) AS total_montante
FROM Users u
JOIN Donations_table d ON u.id_user = d.user_id
GROUP BY u.id_user
ORDER BY total_montante DESC;

CREATE OR REPLACE VIEW v_detalhes_adocoes AS
SELECT 
    ap.id_adoption,
    u.name AS nome_adotante,
    p.name AS nome_animal,
    ap.status AS estado_processo,
    ap.start_date AS data_inicio,
    ap.notes
FROM Adoption_processes ap
JOIN Customers c ON ap.adopter_id = c.id_customer
JOIN Users u ON c.id_user = u.id_user
JOIN Pets p ON ap.animal_id = p.id_pet
ORDER BY ap.start_date DESC;