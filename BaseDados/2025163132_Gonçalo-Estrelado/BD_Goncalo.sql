DROP DATABASE IF EXISTS PAM;
CREATE DATABASE PAM;
USE PAM;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    nif CHAR(9),
    birthday DATE,
    gender ENUM('M', 'F', 'Other') DEFAULT 'Other',
    address VARCHAR(255),
    city VARCHAR(50),
    role ENUM('admin', 'customer', 'partner', 'volunteer', 'vet') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_users PRIMARY KEY (id),
    CONSTRAINT uq_users_email UNIQUE (email),
    CONSTRAINT uq_users_nif UNIQUE (nif)
) ENGINE=InnoDB;

CREATE TABLE volunteer_profiles (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    skills TEXT,
    availability_notes TEXT,
    join_date DATE DEFAULT (CURRENT_DATE),
    CONSTRAINT pk_volunteer_profiles PRIMARY KEY (id),
    CONSTRAINT fk_volunteer_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE veterinarians (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    license_number VARCHAR(50) NOT NULL,
    specialty VARCHAR(100),
    CONSTRAINT pk_veterinarians PRIMARY KEY (id),
    CONSTRAINT fk_vet_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE partners (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED,
    company_name VARCHAR(150) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    type_industry VARCHAR(50),
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_partners PRIMARY KEY (id),
    CONSTRAINT fk_partners_users FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE species (
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    CONSTRAINT pk_species PRIMARY KEY (id),
    CONSTRAINT uq_species_name UNIQUE (name)
) ENGINE=InnoDB;

CREATE TABLE breeds (
    id INT UNSIGNED AUTO_INCREMENT,
    species_id INT UNSIGNED NOT NULL,
    name VARCHAR(50) NOT NULL,
    CONSTRAINT pk_breeds PRIMARY KEY (id),
    CONSTRAINT fk_breeds_species FOREIGN KEY (species_id) REFERENCES species(id)
) ENGINE=InnoDB;

CREATE TABLE animals (
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    breed_id INT UNSIGNED NOT NULL,
    gender ENUM('M', 'F'),
    size ENUM('Small', 'Medium', 'Large', 'Giant'),
    image VARCHAR(255),
    birth_date DATE,
    description TEXT,
    status ENUM('available', 'adopted', 'in_process', 'deceased') NOT NULL DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_animals PRIMARY KEY (id),
    CONSTRAINT fk_animals_breeds FOREIGN KEY (breed_id) REFERENCES breeds(id)
) ENGINE=InnoDB;

CREATE TABLE adoption_processes (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    animal_id INT UNSIGNED NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'completed', 'cancelled') DEFAULT 'pending',
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP NULL,
    notes TEXT,
    CONSTRAINT pk_adoption_processes PRIMARY KEY (id),
    CONSTRAINT fk_adoption_users FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_adoption_animals FOREIGN KEY (animal_id) REFERENCES animals(id)
) ENGINE=InnoDB;

CREATE TABLE appointments (
    id INT UNSIGNED AUTO_INCREMENT,
    animal_id INT UNSIGNED NOT NULL,
    vet_id INT UNSIGNED NOT NULL,
    appointment_date DATETIME NOT NULL,
    reason VARCHAR(255) NOT NULL,
    status ENUM('scheduled', 'completed', 'cancelled') NOT NULL DEFAULT 'scheduled',
    CONSTRAINT pk_appointments PRIMARY KEY (id),
    CONSTRAINT fk_appointments_animals FOREIGN KEY (animal_id) REFERENCES animals(id),
    CONSTRAINT fk_appointments_vets FOREIGN KEY (vet_id) REFERENCES veterinarians(id)
) ENGINE=InnoDB;

CREATE TABLE medical_records (
    id INT UNSIGNED AUTO_INCREMENT,
    appointment_id INT UNSIGNED NOT NULL,
    diagnosis TEXT NOT NULL,
    height DECIMAL(5,2),
    weight DECIMAL(5,2),
    medications TEXT,
    treatment TEXT,
    is_vaccinated BOOLEAN DEFAULT FALSE,
    is_neutered BOOLEAN DEFAULT FALSE,
    has_diseases BOOLEAN DEFAULT FALSE,
    disease_notes TEXT,
    CONSTRAINT pk_medical_records PRIMARY KEY (id),
    CONSTRAINT fk_medical_records_app FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE events (
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    event_date DATETIME NOT NULL,
    end_date DATETIME NULL,
    location VARCHAR(150) NOT NULL,
    description TEXT,
    event_type ENUM('Caominhada') NOT NULL,
    status ENUM('scheduled', 'cancelled', 'postponed', 'completed') NOT NULL DEFAULT 'scheduled',
    capacity INT UNSIGNED NULL,
    organizer_id INT UNSIGNED NULL,
    CONSTRAINT pk_events PRIMARY KEY (id),
    CONSTRAINT fk_events_organizer FOREIGN KEY (organizer_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE event_registrations (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    event_id INT UNSIGNED NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('confirmed', 'pending', 'cancelled') NOT NULL DEFAULT 'pending',
    attended BOOLEAN DEFAULT FALSE,
    notes TEXT,
    CONSTRAINT pk_event_registrations PRIMARY KEY (id),
    CONSTRAINT uq_event_reg UNIQUE (user_id, event_id),
    CONSTRAINT fk_event_reg_users FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_event_reg_events FOREIGN KEY (event_id) REFERENCES events(id)
) ENGINE=InnoDB;

CREATE TABLE event_volunteers (
    id INT UNSIGNED AUTO_INCREMENT,
    event_id INT UNSIGNED NOT NULL,
    volunteer_id INT UNSIGNED NOT NULL,
    role VARCHAR(100),
    task_description TEXT,
    CONSTRAINT pk_event_volunteers PRIMARY KEY (id),
    CONSTRAINT uq_event_volunteer UNIQUE (event_id, volunteer_id),
    CONSTRAINT fk_ev_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    CONSTRAINT fk_ev_volunteer FOREIGN KEY (volunteer_id) REFERENCES volunteer_profiles(id)
) ENGINE=InnoDB;

CREATE TABLE event_animals (
    id INT UNSIGNED AUTO_INCREMENT,
    event_id INT UNSIGNED NOT NULL,
    animal_id INT UNSIGNED NOT NULL,
    notes TEXT,
    CONSTRAINT pk_event_animals PRIMARY KEY (id),
    CONSTRAINT uq_event_animal UNIQUE (event_id, animal_id),
    CONSTRAINT fk_ea_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    CONSTRAINT fk_ea_animal FOREIGN KEY (animal_id) REFERENCES animals(id)
) ENGINE=InnoDB;

CREATE TABLE volunteer_availability (
    id INT UNSIGNED AUTO_INCREMENT,
    volunteer_id INT UNSIGNED NOT NULL,
    day_of_week VARCHAR(20) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    CONSTRAINT pk_volunteer_availability PRIMARY KEY (id),
    CONSTRAINT fk_avail_volunteer FOREIGN KEY (volunteer_id) REFERENCES volunteer_profiles(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE volunteer_shifts (
    id INT UNSIGNED AUTO_INCREMENT,
    volunteer_id INT UNSIGNED NOT NULL,
    task_description TEXT NOT NULL,
    shift_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    CONSTRAINT pk_volunteer_shifts PRIMARY KEY (id),
    CONSTRAINT fk_shifts_volunteer FOREIGN KEY (volunteer_id) REFERENCES volunteer_profiles(id)
) ENGINE=InnoDB;

CREATE TABLE lost_animals (
    id INT UNSIGNED AUTO_INCREMENT,
    reporter_id INT UNSIGNED NOT NULL,
    animal_id INT UNSIGNED,
    animal_name VARCHAR(100) NOT NULL,
    city VARCHAR(50),
    last_seen_date DATE NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    details TEXT,
    photo VARCHAR(255),
    is_rescued BOOLEAN DEFAULT FALSE,
    CONSTRAINT pk_lost_animals PRIMARY KEY (id),
    CONSTRAINT fk_lost_reporter FOREIGN KEY (reporter_id) REFERENCES users(id),
    CONSTRAINT fk_lost_animal FOREIGN KEY (animal_id) REFERENCES animals(id)
) ENGINE=InnoDB;

CREATE TABLE donations (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED,
    amount DECIMAL(10,2) NOT NULL,
    donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50),
    notes TEXT,
    CONSTRAINT pk_donations PRIMARY KEY (id),
    CONSTRAINT fk_donations_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

INSERT INTO users (full_name, email, password, phone, nif, birthday, gender, address, city, role) VALUES
('Admin PAM Goncalo', 'admin.goncalo@pam.org', 'hashed_pass', '911100001', '110000001', '1980-01-01', 'M', 'Sede PAM, Porto', 'Porto', 'admin'),
('Bruno Almeida', 'bruno.almeida@pam.org', 'hashed_pass', '911100002', '110000002', '1991-02-10', 'M', 'Rua Nova 10, Lisboa', 'Lisboa', 'customer'),
('Ines Duarte', 'ines.duarte@pam.org', 'hashed_pass', '911100003', '110000003', '1993-07-24', 'F', 'Rua da Fonte 5, Braga', 'Braga', 'volunteer'),
('Miguel Fonseca', 'miguel.fonseca@pam.org', 'hashed_pass', '911100004', '110000004', '1987-11-03', 'M', 'Avenida Sul 22, Faro', 'Faro', 'customer'),
('Lara Neves', 'lara.neves@pam.org', 'hashed_pass', '911100005', '110000005', '1996-04-17', 'F', 'Praca Verde 9, Aveiro', 'Aveiro', 'volunteer'),
('Hugo Cardoso', 'hugo.cardoso@pam.org', 'hashed_pass', '911100006', '110000006', '1989-06-08', 'M', 'Rua do Sol 14, Porto', 'Porto', 'customer'),
('Rita Azevedo', 'rita.azevedo@pam.org', 'hashed_pass', '911100007', '110000007', '1994-01-19', 'F', 'Rua do Rio 3, Coimbra', 'Coimbra', 'customer'),
('Daniel Pires', 'daniel.pires@pam.org', 'hashed_pass', '911100008', '110000008', '1988-09-27', 'M', 'Travessa Alta 7, Viana', 'Viana', 'vet'),
('Beatriz Lopes', 'beatriz.lopes@pam.org', 'hashed_pass', '911100009', '110000009', '1992-12-05', 'F', 'Rua Central 2, Leiria', 'Leiria', 'customer'),
('Nuno Ribeiro', 'nuno.ribeiro@pam.org', 'hashed_pass', '911100010', '110000010', '1986-03-30', 'M', 'Rua da Serra 11, Guimaraes', 'Guimaraes', 'vet');

INSERT INTO volunteer_profiles (user_id, skills, availability_notes) VALUES
(3, 'acolhimento, passeio canino', 'fins de semana e feriados'),
(5, 'treino basico, logistica de eventos', 'tercas e quintas a tarde');

INSERT INTO veterinarians (user_id, license_number, specialty) VALUES
(8, 'VETG001', 'Medicina interna'),
(10, 'VETG002', 'Imagem e cirurgia');

INSERT INTO partners (company_name, contact_person, phone, email, type_industry) VALUES
('PetHub Atlatico', 'Carlos Tavares', '222210111', 'contacto@pethub-atl.pt', 'Retail'),
('Clinica Vet Aurora', 'Helena Morais', '222210112', 'geral@vetaurora.pt', 'Veterinaria'),
('NutriPets Norte', 'Paulo Goncalves', '222210113', NULL, 'Alimentacao'),
('Hotel Patas Urbanas', 'Raquel Dias', '222210114', 'reservas@patasurbanas.pt', 'Hospedagem'),
('ProtegePet Seguros', 'Bruno Mota', '222210115', 'apoio@protegepet.pt', 'Seguros');

INSERT INTO species (name) VALUES ('Canine'), ('Feline'), ('Lagomorph'), ('Psittacine'), ('Murine');

INSERT INTO breeds (species_id, name) VALUES
(1, 'Border Collie'), (1, 'Shiba Inu'), (1, 'Dalmatian'), (1, 'Corgi'), (1, 'Akita'),
(2, 'Sphynx'), (2, 'Norwegian Forest'), (2, 'British Shorthair'), (2, 'Scottish Fold'), (2, 'Turkish Angora');

INSERT INTO animals (name, breed_id, gender, size, description, status) VALUES
('Atlas', 1, 'M', 'Large', 'Ativo e obediente', 'available'),
('Kira', 7, 'F', 'Small', 'Tranquila e afetuosa', 'adopted'),
('Bolt', 1, 'M', 'Large', 'Energia alta para desporto', 'in_process'),
('Yumi', 6, 'F', 'Medium', 'Curiosa e muito brincalhona', 'available'),
('Echo', 2, 'M', 'Small', 'Adora passeios curtos', 'available'),
('Nala', 2, 'F', 'Small', 'Calma com criancas', 'available'),
('Orion', 8, 'M', 'Large', 'Sociavel com outros animais', 'adopted'),
('Zelda', 3, 'F', 'Medium', 'Atenta a comandos', 'available'),
('Paco', 4, 'M', 'Small', 'Companheiro para apartamento', 'available'),
('Iris', 1, 'F', 'Large', 'Excelente para familia ativa', 'available');

INSERT INTO adoption_processes (user_id, animal_id, status, notes) VALUES
(2, 1, 'pending', 'Moradia com patio e quintal'),
(4, 2, 'completed', 'Historico positivo com felinos'),
(6, 3, 'pending', 'Familia com disponibilidade diaria'),
(7, 7, 'completed', 'Ja concluiu adocao anterior'),
(9, 4, 'rejected', 'Horario semanal incompatível'),
(2, 5, 'pending', 'Primeiro processo no abrigo'),
(4, 6, 'pending', 'Entrevista presencial marcada'),
(6, 8, 'pending', 'Procura animal de energia media'),
(7, 10, 'approved', 'Referencias validadas pela equipa'),
(9, 9, 'pending', 'Tem espaco exterior vedado');

INSERT INTO appointments (animal_id, vet_id, appointment_date, reason, status) VALUES
(1, 1, '2026-06-03 09:00', 'Exame inicial completo', 'completed'),
(2, 1, '2026-06-04 11:00', 'Reforco vacinal', 'completed'),
(3, 2, '2026-06-05 14:30', 'Avaliacao pos-trauma', 'cancelled'),
(4, 1, '2026-06-07 10:15', 'Desparasitacao trimestral', 'scheduled'),
(5, 1, '2026-06-09 16:20', 'Dermatite ligeira', 'scheduled'),
(6, 2, '2026-06-12 09:40', 'Revisao nutricional', 'scheduled'),
(7, 1, '2026-06-14 13:30', 'Preparacao para esterilizacao', 'scheduled'),
(8, 2, '2026-06-18 15:00', 'Controlo de mobilidade', 'scheduled'),
(9, 1, '2026-06-20 11:10', 'Acompanhamento ortopedico', 'scheduled'),
(10, 2, '2026-06-22 12:25', 'Avaliacao oftalmologica', 'scheduled');

INSERT INTO medical_records (appointment_id, diagnosis, height, weight, medications, treatment, is_vaccinated, is_neutered, has_diseases) VALUES
(1, 'Estado geral excelente', 61.5, 31.1, NULL, NULL, TRUE, FALSE, FALSE),
(2, 'Vacinacao reforcada sem reacoes', 27.4, 4.6, NULL, NULL, TRUE, TRUE, FALSE),
(3, 'Recuperacao incompleta de entorse', 59.2, 29.8, 'Anti-inflamatorio', 'Repouso e gelo local', FALSE, FALSE, FALSE),
(4, 'Sem sinais de parasitas', 53.0, 4.3, NULL, 'Monitorizacao preventiva', TRUE, FALSE, FALSE),
(5, 'Dermatite controlada', 36.8, 7.7, 'Pomada topica', 'Higienizacao semanal', TRUE, TRUE, FALSE),
(6, 'Condicao corporal adequada', 24.5, 4.5, NULL, NULL, TRUE, TRUE, FALSE),
(7, 'Apto para procedimento cirurgico', 70.4, 30.0, NULL, 'Jejum pre-operatorio', TRUE, FALSE, FALSE),
(8, 'Melhoria de articulacoes posteriores', 39.0, 11.8, 'Condroprotetor', 'Fisioterapia leve', TRUE, FALSE, FALSE),
(9, 'Sem alteracoes relevantes', 21.0, 0.9, NULL, NULL, FALSE, FALSE, FALSE),
(10, 'Olho seco moderado', 67.2, 31.5, 'Lubrificante ocular', 'Reavaliar em 15 dias', TRUE, FALSE, TRUE);

INSERT INTO events (name, event_date, end_date, location, description, event_type, status, capacity, organizer_id) VALUES
('Rota Canina Norte', '2026-06-15 09:00', '2026-06-15 12:00', 'Parque Oriental', 'Caminhada de socializacao para caes e tutores', 'Caominhada', 'scheduled', 80, 1),
('Trilho Solidario Urbano', '2026-06-29 08:30', '2026-06-29 11:30', 'Marginal Atlântica', 'Percurso guiado com recolha de fundos', 'Caominhada', 'scheduled', 70, 3),
('Passeio da Primavera Tardia', '2026-07-06 10:00', '2026-07-06 13:00', 'Jardim das Oliveiras', 'Atividade para promover adocoes responsaveis', 'Caominhada', 'scheduled', 60, 5),
('Caminho Verde Animal', '2026-07-20 09:30', '2026-07-20 12:30', 'Parque da Serra', 'Evento de bem-estar e treino leve', 'Caominhada', 'scheduled', 50, 3),
('Volta Peluda Comunitaria', '2026-08-03 08:45', '2026-08-03 11:15', 'Zona Ribeirinha', 'Circuito de consciencializacao publica', 'Caominhada', 'scheduled', 90, 1),
('Marcha Patinhas Unidas', '2026-08-17 09:15', '2026-08-17 12:15', 'Avenida do Mar', 'Acao solidaria para apoio veterinario', 'Caominhada', 'scheduled', 75, 5),
('Circuito Canino Escolar', '2026-09-07 14:00', '2026-09-07 16:30', 'Complexo Escolar Sul', 'Sessao educativa para jovens tutores', 'Caominhada', 'scheduled', 45, 3),
('Caminhada Sunset Pets', '2026-09-21 18:00', '2026-09-21 20:00', 'Passeio da Cidade', 'Encontro ao fim da tarde com animais do abrigo', 'Caominhada', 'scheduled', 65, 1),
('Desafio 5K Patinhas', '2026-10-05 09:00', '2026-10-05 12:00', 'Ecopista Norte', 'Percurso de 5 km com equipas solidarias', 'Caominhada', 'scheduled', 120, 5),
('Caminhada de Encerramento', '2026-10-19 10:00', '2026-10-19 13:00', 'Parque Municipal', 'Fecho da epoca com adocoes no local', 'Caominhada', 'scheduled', 100, 3);

INSERT INTO event_registrations (user_id, event_id, status, attended) VALUES
(2, 1, 'confirmed', TRUE), (6, 1, 'pending', FALSE), (4, 2, 'confirmed', FALSE),
(7, 3, 'pending', FALSE), (9, 4, 'confirmed', FALSE), (2, 6, 'confirmed', FALSE),
(4, 7, 'pending', FALSE), (6, 8, 'confirmed', FALSE), (7, 9, 'confirmed', FALSE),
(9, 10, 'pending', FALSE);

INSERT INTO event_volunteers (event_id, volunteer_id, role, task_description) VALUES
(1, 1, 'Coordenacao local', 'Gestao de percurso e check-in dos participantes'),
(2, 2, 'Apoio logistico', 'Montagem de pontos de agua e material'),
(3, 2, 'Instrucao basica', 'Aquecimento e orientacao de conduta'),
(6, 1, 'Seguranca de percurso', 'Monitorizacao de cruzamentos e fluxo'),
(8, 1, 'Relacao com publico', 'Apoio a familias interessadas em adocao'),
(9, 2, 'Encerramento', 'Recolha de materiais e inventario final');

INSERT INTO event_animals (event_id, animal_id, notes) VALUES
(1, 1, 'Participa no circuito de apresentacao'),
(1, 3, 'Animal em destaque para familias ativas'),
(2, 5, 'Perfil adequado para apartamento'),
(3, 6, 'Animal calmo para primeiro tutor'),
(6, 2, 'Participacao em zona de socializacao'),
(8, 8, 'Acompanhamento por equipa de treino'),
(9, 9, 'Participacao em area de sensibilizacao'),
(10, 10, 'Apresentacao final de encerramento');

INSERT INTO volunteer_availability (volunteer_id, day_of_week, start_time, end_time) VALUES
(1, 'Segunda', '09:00', '13:00'), (1, 'Quarta', '09:00', '13:00'),
(2, 'Terca', '14:00', '18:00'), (2, 'Sexta', '14:00', '18:00');

INSERT INTO volunteer_shifts (volunteer_id, task_description, shift_date, start_time, end_time) VALUES
(1, 'Rececao e triagem de visitas', '2026-06-10', '09:00', '12:00'),
(2, 'Sessao de treino de socializacao', '2026-06-11', '14:00', '16:00'),
(1, 'Passeio de enriquecimento ambiental', '2026-06-12', '09:00', '11:00'),
(2, 'Apoio logistico em consulta externa', '2026-06-13', '08:00', '10:00'),
(1, 'Registo fotografico dos animais', '2026-06-14', '09:00', '11:00');

INSERT INTO lost_animals (reporter_id, animal_id, animal_name, city, last_seen_date, contact_phone, details, is_rescued) VALUES
(2, 1, 'Milo', 'Lisboa', '2026-06-01', '911100002', 'Desapareceu perto de casa', FALSE),
(4, NULL, 'Penny', 'Porto', '2026-06-02', '911100004', 'Gata cinzenta com coleira azul', FALSE),
(6, NULL, 'Duke', 'Faro', '2026-06-03', '911100006', 'Cao medio com mancha branca', FALSE),
(7, 7, 'Cleo', 'Coimbra', '2026-06-04', '911100007', 'Foi vista na zona universitária', TRUE),
(9, NULL, 'Rexa', 'Aveiro', '2026-06-05', '911100009', 'Tem chip e responde ao nome', FALSE);

INSERT INTO donations (user_id, amount, payment_method, notes) VALUES
(2, 45.00, 'MBWay', 'Contributo trimestral'),
(4, 35.00, 'Transferencia', 'Medicacao preventiva'),
(6, 120.00, 'Transferencia', 'Apoio a cirurgias'),
(NULL, 18.00, 'Numerario', 'Doacao anonima de balcão'),
(7, 42.50, 'MBWay', 'Campanha de verao'),
(9, 22.00, 'MBWay', 'Apoio regular mensal'),
(3, 12.00, 'Numerario', 'Voluntario contribui no evento'),
(2, 260.00, 'Transferencia', 'Patrocinio corporativo pontual'),
(4, 64.00, 'MBWay', 'Reforco para racao'),
(6, 31.50, 'Transferencia', 'Apoio a exames laboratoriais');

CREATE OR REPLACE VIEW vw_animals_shelter AS
SELECT
    a.id, a.name, s.name AS species, b.name AS breed,
    a.gender, a.size, a.status, a.birth_date,
    DATEDIFF(CURRENT_DATE, a.created_at) AS days_in_shelter
FROM animals a
JOIN breeds b ON a.breed_id = b.id
JOIN species s ON b.species_id = s.id
ORDER BY days_in_shelter DESC;

CREATE OR REPLACE VIEW vw_available_animals AS
SELECT
    a.id, a.name, s.name AS species, b.name AS breed,
    a.gender, a.size, a.birth_date, a.description,
    DATEDIFF(CURRENT_DATE, a.created_at) AS days_waiting
FROM animals a
JOIN breeds b ON a.breed_id = b.id
JOIN species s ON b.species_id = s.id
WHERE a.status IN ('available', 'in_process')
ORDER BY days_waiting DESC;

CREATE OR REPLACE VIEW vw_pending_adoptions AS
SELECT
    ap.id AS process_id, u.full_name AS applicant, u.phone AS applicant_phone,
    a.name AS animal_name, s.name AS species, ap.start_date,
    DATEDIFF(CURRENT_DATE, ap.start_date) AS waiting_days, ap.notes
FROM adoption_processes ap
JOIN users u ON ap.user_id = u.id
JOIN animals a ON ap.animal_id = a.id
JOIN breeds b ON a.breed_id = b.id
JOIN species s ON b.species_id = s.id
WHERE ap.status = 'pending'
ORDER BY waiting_days DESC;

CREATE OR REPLACE VIEW vw_species_population AS
SELECT
    s.name AS species_name,
    COUNT(a.id) AS total_animals,
    SUM(CASE WHEN a.status = 'available' THEN 1 ELSE 0 END) AS available,
    SUM(CASE WHEN a.status = 'adopted' THEN 1 ELSE 0 END) AS adopted,
    SUM(CASE WHEN a.status = 'in_process' THEN 1 ELSE 0 END) AS in_process
FROM species s
LEFT JOIN breeds b ON s.id = b.species_id
LEFT JOIN animals a ON b.id = a.breed_id
GROUP BY s.id, s.name;

CREATE OR REPLACE VIEW vw_upcoming_appointments AS
SELECT
    app.appointment_date, v_user.full_name AS vet_name, vet.specialty,
    a.name AS animal_name, s.name AS species, app.reason, app.status
FROM appointments app
JOIN veterinarians vet ON app.vet_id = vet.id
JOIN users v_user ON vet.user_id = v_user.id
JOIN animals a ON app.animal_id = a.id
JOIN breeds b ON a.breed_id = b.id
JOIN species s ON b.species_id = s.id
WHERE app.status = 'scheduled' AND app.appointment_date >= CURRENT_DATE
ORDER BY app.appointment_date ASC;

CREATE OR REPLACE VIEW vw_animal_health_records AS
SELECT
    a.name AS animal_name, s.name AS species, app.appointment_date,
    v_user.full_name AS vet_name, mr.diagnosis, mr.height, mr.weight,
    mr.medications, mr.treatment, mr.is_vaccinated, mr.is_neutered, mr.has_diseases
FROM medical_records mr
JOIN appointments app ON mr.appointment_id = app.id
JOIN animals a ON app.animal_id = a.id
JOIN breeds b ON a.breed_id = b.id
JOIN species s ON b.species_id = s.id
JOIN veterinarians vet ON app.vet_id = vet.id
JOIN users v_user ON vet.user_id = v_user.id
ORDER BY a.name ASC, app.appointment_date DESC;

CREATE OR REPLACE VIEW vw_vet_workload AS
SELECT
    u.full_name AS vet_name, vet.specialty, u.phone,
    COUNT(app.id) AS total_appointments,
    SUM(CASE WHEN app.status = 'scheduled' THEN 1 ELSE 0 END) AS upcoming,
    SUM(CASE WHEN app.status = 'completed' THEN 1 ELSE 0 END) AS completed,
    SUM(CASE WHEN app.status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled
FROM veterinarians vet
JOIN users u ON vet.user_id = u.id
LEFT JOIN appointments app ON vet.id = app.vet_id
GROUP BY vet.id, u.full_name, vet.specialty, u.phone;

CREATE OR REPLACE VIEW vw_events_timeline AS
SELECT
    e.name AS event_name, e.event_type, e.event_date, e.end_date, e.location,
    e.status, e.capacity, IFNULL(u.full_name, 'Sem organizador') AS organizer,
    CASE
        WHEN e.event_date < CURRENT_DATE THEN 'Concluído'
        WHEN DATE(e.event_date) = CURRENT_DATE THEN 'A decorrer hoje'
        ELSE 'Próximo'
    END AS timeline_status
FROM events e
LEFT JOIN users u ON e.organizer_id = u.id
ORDER BY e.event_date ASC;

CREATE OR REPLACE VIEW vw_event_attendance AS
SELECT
    e.name AS event_name, e.event_date, e.event_type, e.status AS event_status,
    e.capacity,
    COUNT(er.id) AS total_registrations,
    SUM(CASE WHEN er.status = 'confirmed' THEN 1 ELSE 0 END) AS confirmed,
    SUM(CASE WHEN er.status = 'pending' THEN 1 ELSE 0 END) AS pending,
    SUM(CASE WHEN er.attended = TRUE THEN 1 ELSE 0 END) AS attended,
    CASE
        WHEN e.capacity IS NULL THEN NULL
        ELSE e.capacity - COUNT(CASE WHEN er.status IN ('confirmed', 'pending') THEN 1 END)
    END AS slots_remaining
FROM events e
LEFT JOIN event_registrations er ON e.id = er.event_id
GROUP BY e.id, e.name, e.event_date, e.event_type, e.status, e.capacity;

CREATE OR REPLACE VIEW vw_upcoming_events AS
SELECT
    e.id, e.name AS event_name, e.event_type, e.event_date, e.end_date, e.location,
    e.capacity, IFNULL(u.full_name, 'Sem organizador') AS organizer,
    DATEDIFF(DATE(e.event_date), CURRENT_DATE) AS days_until,
    (SELECT COUNT(*) FROM event_registrations er WHERE er.event_id = e.id AND er.status IN ('confirmed', 'pending')) AS registrations,
    CASE
        WHEN e.capacity IS NULL THEN NULL
        ELSE e.capacity - (SELECT COUNT(*) FROM event_registrations er WHERE er.event_id = e.id AND er.status IN ('confirmed', 'pending'))
    END AS slots_remaining
FROM events e
LEFT JOIN users u ON e.organizer_id = u.id
WHERE e.status = 'scheduled' AND e.event_date >= CURRENT_DATE
ORDER BY e.event_date ASC;

CREATE OR REPLACE VIEW vw_event_volunteers AS
SELECT
    e.name AS event_name, e.event_date, e.event_type,
    u.full_name AS volunteer_name, u.phone,
    ev.role, ev.task_description
FROM event_volunteers ev
JOIN events e ON ev.event_id = e.id
JOIN volunteer_profiles vp ON ev.volunteer_id = vp.id
JOIN users u ON vp.user_id = u.id
ORDER BY e.event_date ASC, u.full_name ASC;

CREATE OR REPLACE VIEW vw_event_animals AS
SELECT
    e.name AS event_name, e.event_date, e.event_type,
    a.name AS animal_name, s.name AS species, b.name AS breed,
    a.gender, a.size, a.status AS animal_status, ea.notes
FROM event_animals ea
JOIN events e ON ea.event_id = e.id
JOIN animals a ON ea.animal_id = a.id
JOIN breeds b ON a.breed_id = b.id
JOIN species s ON b.species_id = s.id
ORDER BY e.event_date ASC, a.name ASC;

CREATE OR REPLACE VIEW vw_volunteer_overview AS
SELECT
    u.full_name, u.phone, u.city, vp.skills, vp.availability_notes,
    DATEDIFF(CURRENT_DATE, vp.join_date) AS days_as_volunteer,
    (SELECT COUNT(*) FROM volunteer_shifts vs WHERE vs.volunteer_id = vp.id) AS total_shifts
FROM volunteer_profiles vp
JOIN users u ON vp.user_id = u.id
ORDER BY days_as_volunteer DESC;

CREATE OR REPLACE VIEW vw_volunteer_schedule AS
SELECT
    vs.shift_date, vs.start_time, vs.end_time, vs.task_description,
    u.full_name AS volunteer, u.phone
FROM volunteer_shifts vs
JOIN volunteer_profiles vp ON vs.volunteer_id = vp.id
JOIN users u ON vp.user_id = u.id
ORDER BY vs.shift_date ASC, vs.start_time ASC;

CREATE OR REPLACE VIEW vw_volunteer_availability AS
SELECT
    u.full_name AS volunteer, u.city, va.day_of_week, va.start_time, va.end_time
FROM volunteer_availability va
JOIN volunteer_profiles vp ON va.volunteer_id = vp.id
JOIN users u ON vp.user_id = u.id
ORDER BY u.full_name, FIELD(va.day_of_week, 'Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo');

CREATE OR REPLACE VIEW vw_lost_animals_radar AS
SELECT
    la.animal_name, la.city, la.last_seen_date, la.contact_phone, la.details,
    u.full_name AS reporter, la.is_rescued,
    DATEDIFF(CURRENT_DATE, la.last_seen_date) AS days_missing
FROM lost_animals la
JOIN users u ON la.reporter_id = u.id
ORDER BY la.is_rescued ASC, days_missing DESC;

CREATE OR REPLACE VIEW vw_donations_summary AS
SELECT
    DATE_FORMAT(donation_date, '%Y-%m') AS month_year,
    payment_method,
    COUNT(id) AS total_count,
    SUM(amount) AS total_amount
FROM donations
GROUP BY DATE_FORMAT(donation_date, '%Y-%m'), payment_method
ORDER BY month_year DESC, total_amount DESC;

CREATE OR REPLACE VIEW vw_top_donors AS
SELECT
    IFNULL(u.full_name, 'Anónimo') AS donor_name,
    u.role,
    COUNT(d.id) AS times_donated,
    SUM(d.amount) AS total_donated
FROM donations d
LEFT JOIN users u ON d.user_id = u.id
GROUP BY d.user_id, u.full_name, u.role
ORDER BY total_donated DESC;

CREATE OR REPLACE VIEW vw_partners_directory AS
SELECT
    p.company_name, p.contact_person, p.phone,
    IFNULL(p.email, 'Sem email') AS email,
    p.type_industry,
    IFNULL(u.full_name, 'Sem conta') AS linked_user
FROM partners p
LEFT JOIN users u ON p.user_id = u.id
ORDER BY p.company_name ASC;

CREATE OR REPLACE VIEW vw_user_engagement AS
SELECT
    u.id, u.full_name, u.role, u.city,
    (SELECT COUNT(*) FROM adoption_processes ap WHERE ap.user_id = u.id) AS adoption_requests,
    (SELECT COUNT(*) FROM event_registrations er WHERE er.user_id = u.id) AS event_registrations,
    (SELECT COUNT(*) FROM donations d WHERE d.user_id = u.id) AS donation_count,
    CASE WHEN vp.id IS NOT NULL THEN 'Sim' ELSE 'Não' END AS is_volunteer
FROM users u
LEFT JOIN volunteer_profiles vp ON u.id = vp.user_id;
