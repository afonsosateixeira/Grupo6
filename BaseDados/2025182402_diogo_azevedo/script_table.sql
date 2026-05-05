create database adoption;


#tabelas
CREATE TABLE volunteers (
	id INT AUTO_INCREMENT,
	name VARCHAR(51) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	city VARCHAR(100) NOT NULL,
	CONSTRAINT pk_volunteers PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE horary (
	id INT AUTO_INCREMENT,
	id_volunteers INT NOT NULL,
	day_week VARCHAR(20) NOT NULL,
	start_time TIME NOT NULL,
	end_time TIME NOT NULL,
	CONSTRAINT pk_horary PRIMARY KEY (id),
	CONSTRAINT fk_volunteers_horary FOREIGN KEY (id_volunteers) REFERENCES volunteers(id)
) ENGINE = InnoDB;

create table participants(
	id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    CONSTRAINT pk_participants PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE events (
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    event_date DATETIME NOT NULL,
    id_volunteers INT,
    id_participants INT,
    CONSTRAINT pk_events PRIMARY KEY (id),
    CONSTRAINT fk_events_volunteers 
        FOREIGN KEY (id_volunteers) REFERENCES volunteers(id), 
        CONSTRAINT fk_events_participants
        FOREIGN KEY (id_participants) REFERENCES participants(id)
) ENGINE = InnoDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    CONSTRAINT pk_users PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE species (
    id INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    CONSTRAINT pk_species PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE breeds (
    id INT AUTO_INCREMENT,
    id_species INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    CONSTRAINT pk_breeds PRIMARY KEY (id),
    CONSTRAINT fk_breeds_species FOREIGN KEY (id_species) REFERENCES species(id)
) ENGINE = InnoDB;

CREATE TABLE partners (
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50),
    contact VARCHAR(50),
    CONSTRAINT pk_partners PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE veterinarians (
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    license_number VARCHAR(50),
    phone VARCHAR(20),
    CONSTRAINT pk_veterinarians PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE animals (
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    id_breed INT NOT NULL,
    age INT,
    status ENUM('disponível', 'adotado', 'perdido') DEFAULT 'disponível',
    CONSTRAINT pk_animals PRIMARY KEY (id),
    CONSTRAINT fk_animals_breeds FOREIGN KEY (id_breed) REFERENCES breeds(id)
) ENGINE = InnoDB;

CREATE TABLE lost_animals (
    id INT AUTO_INCREMENT,
    id_animal INT NOT NULL,
    last_seen_location VARCHAR(255),
    lost_date DATE,
    contact_phone VARCHAR(20),
    CONSTRAINT pk_lost_animals PRIMARY KEY (id),
    CONSTRAINT fk_lost_animals_animal FOREIGN KEY (id_animal) REFERENCES animals(id)
) ENGINE = InnoDB;

CREATE TABLE checkups (
    id INT AUTO_INCREMENT,
    id_animal INT NOT NULL,
    id_vet INT NOT NULL,
    checkup_date DATETIME,
    notes TEXT,
    CONSTRAINT pk_checkups PRIMARY KEY (id),
    CONSTRAINT fk_checkups_animal FOREIGN KEY (id_animal) REFERENCES animals(id),
    CONSTRAINT fk_checkups_vet FOREIGN KEY (id_vet) REFERENCES veterinarians(id)
) ENGINE = InnoDB;

CREATE TABLE results (
    id INT AUTO_INCREMENT,
    id_checkup INT NOT NULL,
    diagnosis TEXT,
    treatment VARCHAR(255),
    CONSTRAINT pk_results PRIMARY KEY (id),
    CONSTRAINT fk_results_checkup FOREIGN KEY (id_checkup) REFERENCES checkups(id)
) ENGINE = InnoDB;

CREATE TABLE adoption_process (
    id INT AUTO_INCREMENT,
    id_animal INT NOT NULL,
    id_user INT NOT NULL,
    request_date DATETIME,
    status ENUM('pendente', 'aprovado', 'rejeitado') DEFAULT 'pendente',
    CONSTRAINT pk_adoption_process PRIMARY KEY (id),
    CONSTRAINT fk_adoption_animal FOREIGN KEY (id_animal) REFERENCES animals(id),
    CONSTRAINT fk_adoption_user FOREIGN KEY (id_user) REFERENCES users(id)
) ENGINE = InnoDB;

CREATE TABLE donations (
    id INT AUTO_INCREMENT,
    id_user INT,
    amount DECIMAL(10,2) NOT NULL,
    donation_date DATETIME,
    CONSTRAINT pk_donations PRIMARY KEY (id),
    CONSTRAINT fk_donations_user FOREIGN KEY (id_user) REFERENCES users(id)
) ENGINE = InnoDB;


#dados
INSERT INTO users (id, username, password, email, role) VALUES 
(1, 'admin', 'senha123', 'admin@adocao.pt', 'admin'),
(2, 'maria_silva', 'maria2026', 'maria@email.com', 'user'),
(3, 'joao_pinto', 'joao123', 'joao@email.com', 'user'),
(4, 'pedro_nunes', 'p123', 'pedro@email.pt', 'user'),
(5, 'ana_clara', 'ac2026', 'clara@email.pt', 'user'),
(6, 'rui_vitoria', 'rv88', 'rui@email.pt', 'user'),
(7, 'sofia_m', 'sm99', 'sofia@email.pt', 'user'),
(8, 'tiago_almeida', 'tiago123', 'tiago@adocao.pt', 'user'),
(9, 'carla_p', 'cp77', 'carla@email.pt', 'user'),
(10, 'andre_l', 'al10', 'andre@email.pt', 'user');

INSERT INTO species (id, name) VALUES 
(1, 'Cão'), (2, 'Gato');


INSERT INTO breeds (id, id_species, name) VALUES 
(1, 1, 'Labrador'), 
(2, 1, 'Pastor Alemão'), 
(3, 2, 'Siamês'), 
(4, 2, 'Persa'),
(5, 1, 'Beagle'), 
(6, 1, 'Golden Retriever'), 
(7, 1, 'Chihuahua'),
(8, 2, 'Maine Coon'),
(9, 2, 'Bengala'),
(10, 2, 'Angorá');

INSERT INTO animals (id, name, id_breed, age, status) VALUES 
(1, 'Bobby', 1, 3, 'disponível'),
(2, 'Luna', 3, 2, 'disponível'),
(3, 'Rex', 2, 5, 'perdido'),
(4, 'Max', 1, 4, 'disponível'),
(5, 'Simba', 5, 1, 'disponível'),
(6, 'Pipoca', 4, 2, 'disponível'),
(7, 'Thor', 2, 6, 'adotado'),
(8, 'Mel', 1, 1, 'disponível'),
(9, 'Snoopy', 3, 10, 'disponível'),
(10, 'Bolinha', 6, 3, 'disponível');


INSERT INTO veterinarians (id, name, license_number, phone) VALUES 
(1, 'Dr. Carlos', 'VET12345', '912345678'),
(2, 'Dra. Ana', 'VET98765', '933445566'),
(3, 'Dr. Manuel', 'VET11111', '910000001'),
(4, 'Dra. Marta', 'VET22222', '910000002'),
(5, 'Dr. José', 'VET33333', '910000003'),
(6, 'Dra. Sandra', 'VET44444', '910000004'),
(7, 'Dr. Nuno', 'VET55555', '910000005'),
(8, 'Dra. Filipa', 'VET66666', '910000006'),
(9, 'Dr. Paulo', 'VET77777', '910000007'),
(10, 'Dra. Luísa', 'VET88888', '910000008');

INSERT INTO volunteers (id, name, phone, city) VALUES 
(1, 'Ricardo Jorge', '966778899', 'Leiria'),
(2, 'Beatriz Antunes', '922334455', 'Lisboa'),
(3, 'Daniela Vaz', '919887766', 'Porto'),
(4, 'Bruno Lima', '933221100', 'Coimbra'),
(5, 'Cátia Reis', '966554433', 'Braga'),
(6, 'Hugo Silva', '922883377', 'Faro'),
(7, 'Inês Gil', '911992288', 'Aveiro'),
(8, 'Jorge Marques', '933441122', 'Évora'),
(9, 'Luís Felix', '966112233', 'Santarém'),
(10, 'Marta Teixeira', '922445566', 'Viseu');

INSERT INTO horary (id_volunteers, day_week, start_time, end_time) VALUES 
(1, 'Segunda-feira', '09:00:00', '13:00:00'),
(2, 'Sábado', '14:00:00', '18:00:00'),
(3, 'Terça-feira', '10:00:00', '14:00:00'),
(4, 'Quarta-feira', '09:00:00', '12:00:00'),
(5, 'Quinta-feira', '15:00:00', '19:00:00'),
(6, 'Sexta-feira', '08:00:00', '12:00:00'),
(7, 'Sábado', '09:00:00', '18:00:00'),
(8, 'Domingo', '10:00:00', '13:00:00'),
(9, 'Segunda-feira', '14:00:00', '18:00:00'),
(10, 'Terça-feira', '09:00:00', '13:00:00');

INSERT INTO participants (id, user_id, name) VALUES 
(1, 1001, 'Tiago Ferreira'), 
(2, 1002, 'Sara Santos'), 
(3, 1003, 'Carlos Antunes'), 
(4, 1004, 'Margarida Pereira'), 
(5, 1005, 'João Gonçalves'), 
(6, 1006, 'Bárbara Santos'), 
(7, 1007, 'Fernando Cardoso'), 
(8, 1008, 'Diana Rita'), 
(9, 1009, 'Miguel Veloso'), 
(10, 1010, 'Cláudia Lima');

INSERT INTO events (name, event_date, id_volunteers, id_participants) VALUES 
('Caminhada Solidária', '2026-05-15 10:00:00', 1, 1),
('Feira de Adoção', '2026-06-20 14:30:00', 2, 2),
('Workshop Banho', '2026-07-05 10:00:00', 3, 3),
('Recolha Alimentos', '2026-07-12 09:00:00', 4, 4),
('Cão-festa Verão', '2026-08-01 16:00:00', 5, 5),
('Aula de Treino', '2026-08-15 11:00:00', 6, 6),
('Palestra Bem-estar', '2026-09-02 18:30:00', 7, 7),
('Dia do Gato', '2026-09-10 14:00:00', 8, 8),
('Vacinação Canina', '2026-10-05 09:00:00', 9, 9),
('Jantar Beneficente', '2026-11-20 20:00:00', 10, 10);

INSERT INTO checkups (id_animal, id_vet, checkup_date, notes) VALUES 
(1, 1, '2026-04-20 11:00:00', 'Rotina'), 
(2, 2, '2026-04-21 15:00:00', 'Desparasitação'),
(3, 3, '2026-04-22 09:30:00', 'Ferida'), 
(4, 4, '2026-04-22 14:00:00', 'Febre'),
(5, 5, '2026-04-23 10:00:00', 'Dentes'), 
(6, 6, '2026-04-23 16:00:00', 'Análises'),
(7, 7, '2026-04-24 11:00:00', 'Pele'), 
(8, 8, '2026-04-24 15:00:00', 'Peso'),
(9, 1, '2026-04-25 09:00:00', 'Vacina'), 
(10, 2, '2026-04-25 14:00:00', 'Ouvidos');


INSERT INTO results (id_checkup, diagnosis, treatment) VALUES 
(1, 'Saudável', 'Vacina raiva'), 
(2, 'Saudável', 'Nenhum'),
(3, 'Corte', 'Desinfetar'), 
(4, 'Gripe', 'Antibiótico'),
(5, 'Tártaro', 'Limpeza'), 
(6, 'Anemia', 'Vitaminas'),
(7, 'Alergia', 'Ração especial'), 
(8, 'Obesidade', 'Dieta'),
(9, 'Tudo ok', 'Nenhum'), 
(10, 'Otosclerose', 'Gotas');


INSERT INTO adoption_process (id_animal, id_user, request_date, status) VALUES 
(2, 2, '2026-04-25 09:00:00', 'pendente'), 
(1, 1, '2026-04-25 10:00:00', 'pendente'),
(4, 3, '2026-04-25 11:00:00', 'aprovado'), 
(5, 4, '2026-04-26 14:00:00', 'pendente'),
(6, 5, '2026-04-26 15:30:00', 'rejeitado'), 
(7, 6, '2026-04-26 16:00:00', 'pendente'),
(8, 7, '2026-04-27 09:00:00', 'aprovado'), 
(9, 8, '2026-04-27 10:00:00', 'pendente'),
(10, 9, '2026-04-27 11:30:00', 'pendente'), 
(3, 10, '2026-04-27 12:00:00', 'aprovado');


INSERT INTO lost_animals (id_animal, last_seen_location, lost_date, contact_phone) VALUES 
(3, 'Lisboa', '2026-04-24', '911223344'), 
(1, 'Leiria', '2026-04-20', '912345678'),
(4, 'Coimbra', '2026-04-21', '933000111'), 
(5, 'Porto', '2026-04-22', '966111222'),
(6, 'Guimarães', '2026-04-22', '922333444'), 
(7, 'Sintra', '2026-04-23', '911444555'),
(8, 'Cascais', '2026-04-23', '933555666'), 
(9, 'Portimão', '2026-04-24', '966666777'),
(10, 'Vila Real', '2026-04-24', '922777888'),
(2, 'Bragança', '2026-04-25', '911888999');


INSERT INTO partners (id, name, type, contact) VALUES 
(1, 'PetShop Central', 'Fornecedor', '911'), 
(2, 'VetSaúde', 'Clínica', '922'),
(3, 'Royal Canin', 'Patrocinador', '933'),
(4, 'CM Leiria', 'Apoio', '944'),
(5, 'Seguros Pet', 'Seguradora', '955'), 
(6, 'Transportes R.', 'Logística', '966'),
(7, 'Gráfica L.', 'Publicidade', '977'), 
(8, 'Limpezas T.', 'Manutenção', '988'),
(9, 'Hotel Canino', 'Hospedagem', '999'), 
(10, 'Amigos ONG', 'Parceiro', '900');


INSERT INTO donations (id_user, amount, donation_date) VALUES 
(3, 50.00, '2026-04-26 10:00:00'), 
(1, 20.00, '2026-04-26 11:00:00'),
(2, 100.00, '2026-04-26 15:00:00'), 
(4, 15.50, '2026-04-26 16:30:00'),
(5, 200.00, '2026-04-27 09:00:00'), 
(6, 10.00, '2026-04-27 10:45:00'),
(7, 75.00, '2026-04-27 14:00:00'), 
(8, 30.00, '2026-04-27 15:30:00'),
(9, 5.00, '2026-04-27 17:00:00'), 
(10, 150.00, '2026-04-27 18:00:00');

#vistas
CREATE OR REPLACE VIEW v_animais_detalhes AS
SELECT a.id, a.name AS nome_animal, b.name AS raca, s.name AS especie, a.age, a.status
FROM animals a
JOIN breeds b ON a.id_breed = b.id
JOIN species s ON b.id_species = s.id;

CREATE OR REPLACE VIEW v_historico_saude AS
SELECT c.checkup_date, a.name AS animal, v.name AS veterinario, r.diagnosis, r.treatment
FROM checkups c
JOIN animals a ON c.id_animal = a.id
JOIN veterinarians v ON c.id_vet = v.id
JOIN results r ON r.id_checkup = c.id;

CREATE OR REPLACE VIEW v_adocoes_pendentes AS
SELECT ap.request_date, u.username, a.name AS animal, ap.status
FROM adoption_process ap
JOIN users u ON ap.id_user = u.id
JOIN animals a ON ap.id_animal = a.id
WHERE u.role != 'admin';

CREATE OR REPLACE VIEW v_escala_voluntarios AS
SELECT v.name AS voluntario, h.day_week, h.start_time, h.end_time, v.city
FROM volunteers v
JOIN horary h ON v.id = h.id_volunteers;

CREATE OR REPLACE VIEW v_doacoes_detalhes AS
SELECT u.username, d.amount, d.donation_date, u.email
FROM donations d
JOIN users u ON d.id_user = u.id;