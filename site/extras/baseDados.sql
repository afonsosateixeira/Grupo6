drop database if exists PAM;
create database PAM;
use PAM;

drop table if exists users;
create table users (
    id int auto_increment,
    full_name varchar(150) not null,
    email varchar(100) not null,
    password varchar(255) not null,
    phone varchar(20) not null,
    local varchar(50),
    street varchar(150),
    cp char(8),
    role enum('admin', 'n')  DEFAULT 'n' not null,
    constraint pk_users primary key (id),
    constraint uq_users_email unique (email)
) engine=innodb;

drop table if exists species;
create table species (
    id int auto_increment,
    name varchar(20) not null,
    constraint pk_species primary key (id)
) engine=innodb;

drop table if exists breeds;
create table breeds (
    id int auto_increment,
    specie_id int not null,
    name varchar(50) not null,
    constraint pk_breeds primary key (id),
    constraint fk_breeds_species foreign key (specie_id) references species(id)
) engine=innodb;

drop table if exists animals;
create table animals (
    id int auto_increment,
    name varchar(100) not null,
    specie_id int not null,
    breed_id int null,
    gender enum('Macho', 'Fêmea') not null,
    size enum('Pequeno', 'Médio', 'Grande'),
    image varchar(255),
    birth_date date,
    description text,
    status enum('Disponível', 'Adotado', 'Em processo') not null,
    created_at timestamp default current_timestamp,
    constraint pk_animals primary key (id),
    constraint fk_animals_breeds foreign key (breed_id) references breeds(id),
    constraint fk_animals_species foreign key (specie_id) references species(id)
) engine=innodb;

drop table if exists adoption_processes;
create table adoption_processes (
    id int auto_increment,
    user_id int not null,
    animal_id int not null,
    status enum('Pendente', 'Aprovado', 'Rejeitado') default 'Pendente',
    start_date timestamp default current_timestamp,
    end_date timestamp null,
    notes text,
    constraint pk_adoption_processes primary key (id),
    constraint fk_adoption_users foreign key (user_id) references users(id),
    constraint fk_adoption_animals foreign key (animal_id) references animals(id)
) engine=innodb;

drop table if exists veterinarians;
create table veterinarians (
    id int auto_increment,
    name varchar(150) not null,
    photo varchar(255),
    license_number varchar(50) not null,
    specialty varchar(100),
    phone varchar(20) not null,
    constraint pk_veterinarians primary key (id)
) engine=innodb;

drop table if exists appointments;
create table appointments (
    id int auto_increment,
    animal_id int not null,
    vet_id int not null,
    appointment_date datetime not null,
    reason varchar(255) not null,
    status enum('agendada', 'concluida', 'cancelada') not null,
    constraint pk_appointments primary key (id),
    constraint fk_appointments_animals foreign key (animal_id) references animals(id),
    constraint fk_appointments_vets foreign key (vet_id) references veterinarians(id)
) engine=innodb;

drop table if exists medical_history;
create table medical_history (
    id int auto_increment,
    appointment_id int not null,
    diagnosis text not null,
    weight decimal(5,2),
    medications text,
    treatment text,
    constraint pk_medical_history primary key (id),
    constraint fk_medical_history_app foreign key (appointment_id) references appointments(id)
) engine=innodb;

drop table if exists events;
create table events (
    id int auto_increment,
    name varchar(100) not null,
    event_date datetime not null,
    end_date datetime,
    location varchar(150) not null,
    description text,
    event_type enum('Cãominhada', 'Feira de Adoção', 'Workshop', 'Campanha Solidária', 'Sessão de Treino', 'Palestra', 'Visita Escolar', 'Angariação de Fundos') not null,
    status enum('scheduled', 'cancelled', 'postponed', 'completed') not null default 'scheduled',
    capacity int,
    organizer_id int,
    constraint pk_events primary key (id),
    constraint fk_events_organizer foreign key (organizer_id) references users(id)
) engine=innodb;

drop table if exists events_registrations;
create table events_registrations (
    id int auto_increment,
    user_id int not null,
    event_id int not null,
    registration_date timestamp default current_timestamp,
    status enum('confirmado', 'pendente') not null,
    constraint pk_events_registrations primary key (id),
    constraint fk_events_reg_users foreign key (user_id) references users(id),
    constraint fk_events_reg_events foreign key (event_id) references events(id)
) engine=innodb;

drop table if exists volunteer_profiles;
create table volunteer_profiles (
    id int auto_increment,
    user_id int not null,
	phone VARCHAR(20) NOT NULL,
	city VARCHAR(100) NOT NULL,
    constraint pk_volunteer_profiles primary key (id),
    constraint fk_volunteer_users foreign key (user_id) references users(id)
) engine=innodb;

drop table if exists volunteer_shifts;
create table volunteer_shifts (
    id int auto_increment,
    volunteer_id int not null,
	day_week VARCHAR(20) NOT NULL,
	start_time TIME NOT NULL,
	end_time TIME NOT NULL,
    constraint pk_volunteer_shifts primary key (id),
    constraint fk_shifts_volunteer foreign key (volunteer_id) references volunteer_profiles(id)
) engine=innodb;

drop table if exists lost_animals;
create table lost_animals (
    id int auto_increment,
    user_id int not null,
    animal_name varchar(100) not null,
    last_seen_date date not null,
    contact_phone varchar(20) not null,
    location varchar(255) not null,
    photo varchar(255),
    found enum('Yes', 'No') default 'No' not null,
    constraint pk_lost_animals primary key (id),
    constraint fk_lost_animals_users foreign key (user_id) references users(id)
) engine=innodb;

drop table if exists partners;
create table partners (
    id int auto_increment,
    company_name varchar(150) not null,
    contact_person varchar(100) not null,
    phone varchar(20) not null,
    email varchar(100),
    constraint pk_partners primary key (id)
) engine=innodb;

drop table if exists donations;
create table donations (
    id int auto_increment,
    amount decimal(10,2) not null,
    donation_date timestamp default current_timestamp,
    payment_method varchar(50) not null,
    constraint pk_donations primary key (id)
) engine=innodb;

insert into users (full_name, email, password, phone, local, role) values
('admin', 'admin@email.com', SHA2('123', 512), '910000001', 'porto', 'admin'),
('maria silva', 'maria@email.com', SHA2('123', 512), '910000002', 'lisboa', 'n'),
('joão lopes', 'joao@email.com', SHA2('123', 512), '910000003', 'braga', 'n'),
('ana costa', 'ana@email.com', SHA2('123', 512), '910000004', 'faro', 'n'),
('pedro santos', 'pedro@email.com', SHA2('123', 512), '910000005', 'aveiro', 'n'),
('maria matos', 'carla@email.com', SHA2('123', 512), '910000006', 'porto', 'n'),
('rui silva', 'rui@email.com', SHA2('123', 512), '910000007', 'coimbra', 'n'),
('sofia bento', 'sofia@email.com', SHA2('123', 512), '910000008', 'viana', 'n'),
('tiago ferreira', 'tiago@email.com', SHA2('123', 512), '910000009', 'lisboa', 'n'),
('marta luz', 'marta@email.com', SHA2('123', 512), '910000010', 'braga', 'n');

insert into species (name) values 
('Cão'), ('Gato'), ('Coelho'), ('Pássaro'), ('Hamster'), 
('Réptil'), ('Peixe'), ('Furão'), ('Porquinho da Índia'), ('Tartaruga');

insert into breeds (specie_id, name) values 
(1, 'Labrador'), (1, 'Poodle'), (2, 'Siamês'), (2, 'Persa'), (3, 'Anão holandês'), (5, 'Sírio'), (6, 'Iguana-verde'), (8, 'Standard'), (9, 'Abissínio'), (10, 'Jabuti-piranga');

insert into animals (name, specie_id, breed_id, gender, size, image, birth_date, status) values 
('Max', 1, 1, 'Macho', 'Grande', 'animal1.jpg', '2019-01-03', 'Disponível'),
('Poppy', 1, 2, 'Fêmea', 'Médio', 'animal2.jpg', '2019-02-20', 'Adotado'),
('Thor', 2, 3, 'Macho', 'Pequeno', 'animal3.jpg', '2023-03-26', 'Em processo'),
('Belota', 2, 4, 'Fêmea', 'Pequeno', 'animal4.jpg', '2022-04-30', 'Disponível'),      
('Lia', 3, 5, 'Fêmea', 'Pequeno', 'animal5.jpg', '2024-05-11', 'Disponível'),
('Spike', 6, 7, 'Macho', 'Pequeno', 'animal6.jpg', '2022-06-24', 'Disponível'),
('Fifi', 5, 6, 'Fêmea', 'Pequeno', 'animal7.jpg', '2025-07-01', 'Disponível'),
('Mel', 8, 8, 'Fêmea', 'Pequeno', 'animal8.jpg', '2021-08-13', 'Disponível'),
('Fred', 9, 9, 'Macho', 'Pequeno', 'animal9.jpg', '2023-09-02', 'Disponível'),
('Tico', 10, 10, 'Macho', 'Médio', 'animal10.jpg', '2018-10-09', 'Disponível');

insert into adoption_processes (user_id, animal_id, status, notes) values 
(2, 1, 'pendente', 'casa com jardim'),
(4, 2, 'aprovado', 'experiência anterior'),
(6, 3, 'pendente', 'apartamento'),
(7, 7, 'aprovado', 'tem outro gato'),
(9, 4, 'rejeitado', 'sem condições'),
(10, 8, 'pendente', 'família ativa'),
(2, 5, 'pendente', 'segunda adoção'),
(4, 6, 'pendente', 'visita agendada'),
(6, 9, 'pendente', 'primeiro animal'),
(7, 10, 'pendente', 'interessado em tartarugas');

insert into veterinarians (name, photo, license_number, specialty, phone) values 
('dr. silva', 'vet1.jpg', 'vet001', 'cirurgia', '220000001'),
('dra. ana', 'vet2.jpg', 'vet002', 'clínica geral', '220000002'),
('dr. mendes', 'vet3.jpg', 'vet003', 'exóticos', '220000003'),
('dra. beatriz', 'vet4.jpg', 'vet004', 'dermatologia', '220000004'),
('dr. carlos', 'vet5.jpg', 'vet005', 'ortopedia', '220000005'),
('dra. diana', 'vet6.jpg', 'vet006', 'oftalmologia', '220000006'),
('dr. eusebio', 'vet7.jpg', 'vet007', 'cardiologia', '220000007'),
('dra. fernanda', 'vet8.jpg', 'vet008', 'comportamento', '220000008'),
('dr. gabriel', 'vet9.jpg', 'vet009', 'clínica geral', '220000009'),
('dra. helena', 'vet10.jpg', 'vet010', 'neurologia', '220000010');
insert into appointments (animal_id, vet_id, appointment_date, reason, status) values 
(1, 1, '2026-04-10 10:00', 'check-up', 'concluida'),
(2, 2, '2026-04-11 11:30', 'vacinação', 'concluida'),
(3, 1, '2026-04-12 09:00', 'ferimento', 'cancelada'),
(4, 3, '2026-04-13 15:00', 'desparasitação', 'agendada'),
(5, 4, '2026-04-14 16:00', 'alergia', 'agendada'),
(6, 2, '2026-07-15 10:30', 'revisão', 'agendada'),
(7, 1, '2026-05-16 14:00', 'esterilização', 'agendada'),
(8, 3, '2026-09-17 09:30', 'unhas', 'agendada'),
(9, 5, '2026-06-18 11:00', 'coxeio', 'agendada'),
(10, 6, '2026-05-19 12:00', 'olhos', 'agendada');

insert into medical_history (appointment_id, diagnosis, weight) values 
(1, 'saudável', 30.5), (2, 'vacinas em dia', 4.2),
(3, 'exame de rotina ok', 30.8), (4, 'reação leve à vacina', 4.1),
(5, 'peso estável', 30.6), (6, 'bem nutrido', 4.3),
(7, 'bom estado geral', 30.4), (8, 'sem parasitas', 4.2),
(9, 'musculatura forte', 30.7), (10, 'pelagem brilhante', 4.4);

insert into events (name, event_date, end_date, location, description, event_type, status, capacity, organizer_id) values
('Rota Canina Norte', '2026-06-15 09:00', '2026-06-15 12:00', 'Parque Oriental', 'Caminhada de socialização para cães e tutores', 'Cãominhada', 'scheduled', 80, 1),
('Feira de Adoção Primavera', '2026-06-29 10:00', '2026-06-29 17:00', 'Marginal Atlantica', 'Feira para adoção de cães e gatos', 'Feira de Adoção', 'scheduled', 70, 3),
('Workshop Primeiros Socorros', '2026-07-06 15:00', '2026-07-06 17:00', 'Jardim das Oliveiras', 'Aprenda técnicas básicas de primeiros socorros para animais', 'Workshop', 'scheduled', 60, 5),
('Campanha Solidária de Ração', '2026-07-20 09:30', '2026-07-20 12:30', 'Parque da Serra', 'Recolha de alimentos para animais carenciados', 'Campanha Solidária', 'scheduled', 50, 3),
('Volta Peluda Comunitaria', '2026-08-03 08:45', '2026-08-03 11:15', 'Zona Ribeirinha', 'Circuito de consciencialização publica', 'Cãominhada', 'scheduled', 90, 1),
('Sessão de Treino Básico', '2026-08-17 09:15', '2026-08-17 12:15', 'Avenida do Mar', 'Sessão de treino para cães adotados', 'Sessão de Treino', 'scheduled', 75, 5),
('Visita Escolar Animal', '2026-09-07 14:00', '2026-09-07 16:30', 'Complexo Escolar Sul', 'Atividade educativa para escolas', 'Visita Escolar', 'scheduled', 45, 3),
('Caminhada Sunset Pets', '2026-09-21 18:00', '2026-09-21 20:00', 'Passeio da Cidade', 'Encontro ao fim da tarde com animais do abrigo', 'Cãominhada', 'scheduled', 65, 1),
('Palestra Bem-estar Animal', '2026-10-05 09:00', '2026-10-05 12:00', 'Ecopista Norte', 'Palestra sobre cuidados e bem-estar animal', 'Palestra', 'scheduled', 120, 5),
('Angariação de Fundos Final', '2026-10-19 10:00', '2026-10-19 13:00', 'Parque Municipal', 'Evento para angariação de fundos para o abrigo', 'Angariação de Fundos', 'scheduled', 100, 3);

insert into events_registrations (user_id, event_id, status) values 
(2, 1, 'confirmado'), (4, 1, 'confirmado'), (6, 2, 'confirmado'),
(7, 3, 'pendente'), (9, 4, 'confirmado'), (10, 5, 'confirmado'),
(2, 6, 'pendente'), (4, 8, 'confirmado'), (6, 8, 'confirmado'),
(7, 10, 'confirmado');

insert into volunteer_profiles (user_id, phone, city) values 
(2, '921383900', 'Lisboa'),
(3, '913746362', 'Lisboa'),
(4, '913745462', 'Braga'),
(5, '913336362', 'Leiria'),
(6, '914346362', 'Aveiro'),
(7, '913216362', 'Porto'),
(8, '913709362', 'Coimbra'),
(9, '913745562', 'Leiria'),
(10, '913776362', 'Viseu');

insert into volunteer_shifts (volunteer_id, day_week, start_time, end_time) values 
(1, 'Quarta-feira', '13:00:00', '17:00:00'),
(2, 'Terça-feira', '08:30:00', '15:00:00'),
(3, 'Segunda-feira', '15:00:00', '17:00:00'),
(4, 'Quarta-feira', '13:00:00', '17:00:00'),
(5, 'Quinta-feira', '15:00:00', '17:00:00'),
(6, 'Segunda-feira', '10:30:00', '17:00:00'),
(7, 'Sexta-feira', '10:30:00', '17:00:00'),
(8, 'Segunda-feira', '08:30:00', '10:30:00'),
(9, 'Domingo', '10:30:00', '15:00:00');

insert into lost_animals (user_id, animal_name, last_seen_date, contact_phone, location, photo) values 
(2, 'bolinha', '2026-04-01', '910000002', 'Leiria', 'bolinha_3.webp'), (4, 'pipas', '2026-04-02', '910000004', 'Leiria', null),
(6, 'rex', '2026-04-03', '910000006', 'Leiria', null), (7, 'fifi', '2026-04-04', '910000007', 'Leiria', null),
(9, 'lulu', '2026-04-05', '910000009', 'Leiria', null), (10, 'pantufa', '2026-04-06', '910000010', 'Leiria', null),
(1, 'kiko', '2026-04-07', '910000002', 'Leiria', null), (3, 'mimi', '2026-04-08', '910000004', 'Leiria', null),
(5, 'toby', '2026-04-09', '910000006', 'Leiria', null), (8, 'nini', '2026-04-10', '910000007', 'Leiria', null);

insert into partners (company_name, contact_person, phone) values 
('petshop alegria', 'sr. joaquim', '221111111'),
('clínica do bairro', 'dra. marta', '221111112'),
('ração premium', 'eng. paulo', '221111113'),
('hotel patinhas', 'd. rosa', '221111114'),
('seguros pet', 'dr. bento', '221111115'),
('banhos e mimos', 'claudia', '221111116'),
('transporte seguro', 'manuel', '221111117'),
('gráfica rápida', 'sofia', '221111118'),
('jardim feliz', 'ricardo', '221111119'),
('eventos top', 'beatriz', '221111120');

insert into donations (amount, payment_method) values 
(10.00, 'mbway'), (50.50, 'transferência'), (20.00, 'numerário'),
(5.00, 'mbway'), (100.00, 'transferência'), (25.00, 'numerário'),
(15.00, 'mbway'), (40.00, 'transferência'), (30.00, 'numerário'),
(12.50, 'mbway');

drop view if exists vw_user_engagement;
create view vw_user_engagement as
select u.id, u.full_name, u.role, u.local,
       (select count(*) from adoption_processes ap where ap.user_id = u.id) as total_adoption_requests,
       case when vp.id is not null then 'Sim' else 'Não' end as is_volunteer
from users u
left join volunteer_profiles vp on u.id = vp.user_id;

drop view if exists vw_species_population;
create view vw_species_population as
select s.name as species_name, count(a.id) as total_animals_registered
from species s
left join breeds b on s.id = b.specie_id
left join animals a on b.id = a.breed_id
group by s.id, s.name;

drop view if exists vw_breeds_adoption_stats;
create view vw_breeds_adoption_stats as
select b.name as breed_name, s.name as species_name, 
       count(a.id) as total_animals,
       sum(case when a.status = 'adotado' then 1 else 0 end) as total_adopted
from breeds b
join species s on b.specie_id = s.id
left join animals a on b.id = a.breed_id
group by b.id, b.name, s.name;

drop view if exists vw_animals_waiting_list;
create view vw_animals_waiting_list as
select a.id, a.name, b.name as breed, s.name as species, a.gender, a.size,
       datediff(current_date, a.created_at) as days_in_shelter
from animals a
join breeds b on a.breed_id = b.id
join species s on b.specie_id = s.id
where a.status in ('disponível', 'em processo')
order by days_in_shelter desc;

drop view if exists vw_pending_adoptions_action_list;
create view vw_pending_adoptions_action_list as
select ap.id as process_id, u.full_name as applicant, u.phone as applicant_phone,
       a.name as animal_name, ap.start_date, 
       datediff(current_date, ap.start_date) as waiting_days, ap.notes
from adoption_processes ap
join users u on ap.user_id = u.id
join animals a on ap.animal_id = a.id
where ap.status = 'pendente'
order by waiting_days desc;

drop view if exists vw_vet_workload_analysis;
create view vw_vet_workload_analysis as
select v.name, v.specialty, v.phone,
       count(app.id) as total_appointments,
       sum(case when app.status = 'agendada' then 1 else 0 end) as upcoming_appointments
from veterinarians v
left join appointments app on v.id = app.vet_id
group by v.id, v.name, v.specialty, v.phone;

drop view if exists vw_upcoming_appointments_agenda;
create view vw_upcoming_appointments_agenda as
select app.appointment_date, v.name as vet_name, a.name as animal_name, a.status as animal_status, app.reason
from appointments app
join veterinarians v on app.vet_id = v.id
join animals a on app.animal_id = a.id
where app.status = 'agendada' and app.appointment_date >= current_date
order by app.appointment_date asc;

drop view if exists vw_animal_health_records;
create view vw_animal_health_records as
select a.name as animal_name, app.appointment_date, v.name as vet_name,
       mh.diagnosis, mh.weight, mh.medications, mh.treatment
from medical_history mh
join appointments app on mh.appointment_id = app.id
join animals a on app.animal_id = a.id
join veterinarians v on app.vet_id = v.id
order by a.name asc, app.appointment_date desc;

drop view if exists vw_events_timeline;
create view vw_events_timeline as
select e.name as event_name, e.event_type, e.event_date, e.end_date, e.location,
       e.status, e.capacity, ifnull(u.full_name, 'Sem organizador') as organizer,
       case 
           when e.event_date < current_date then 'Concluido' 
           when date(e.event_date) = current_date then 'A decorrer hoje'
           else 'Próximo' 
       end as timeline_status
from events e
left join users u on e.organizer_id = u.id
order by e.event_date asc;

drop view if exists vw_event_capacity_planning;
create view vw_event_capacity_planning as
select e.name as event_name, e.event_date, e.event_type, e.status as event_status,
       e.capacity,
       count(er.id) as total_registrations,
       sum(case when er.status = 'confirmado' then 1 else 0 end) as confirmed_attendees,
       sum(case when er.status = 'pendente' then 1 else 0 end) as pending_attendees,
       case
           when e.capacity is null then null
           else e.capacity - count(case when er.status in ('confirmado', 'pendente') then 1 end)
       end as slots_remaining
from events e
left join events_registrations er on e.id = er.event_id
group by e.id, e.name, e.event_date, e.event_type, e.status, e.capacity;

DROP VIEW IF EXISTS vw_volunteer_simple_schedule;
CREATE VIEW vw_volunteer_simple_schedule AS
SELECT u.full_name AS volunteer_name,vs.day_week,vs.start_time,vs.end_time
FROM volunteer_shifts vs
JOIN volunteer_profiles vp ON vs.volunteer_id = vp.id
JOIN users u ON vp.user_id = u.id;

drop view if exists vw_volunteer_full_schedule;
CREATE VIEW vw_volunteer_full_schedule AS
SELECT 
vs.id AS shift_id, u.full_name AS volunteer_name,vp.phone,vp.city,vs.day_week,vs.start_time,vs.end_time,vp.id AS volunteer_profile_id,vs.id
FROM volunteer_shifts vs
JOIN volunteer_profiles vp ON vs.volunteer_id = vp.id
JOIN users u ON vp.user_id = u.id;

drop view if exists vw_lost_pets_radar;
create view vw_lost_pets_radar as
select la.id as id, la.animal_name as animal, u.full_name as reporter, la.contact_phone as contact, la.last_seen_date as since, la.photo as photo, la.location as location,
       datediff(current_date, la.last_seen_date) as days_missing, la.found as found
from lost_animals la
join users u on la.user_id = u.id
order by la.id asc;

drop view if exists vw_corporate_partners_directory;
create view vw_corporate_partners_directory as
select company_name, contact_person, phone, ifnull(email, 'Sem Email') as email
from partners
order by company_name asc;

drop view if exists vw_monthly_donations_report;
create view vw_monthly_donations_report as
select date_format(donation_date, '%Y-%m') as month_year,
       payment_method,
       count(id) as total_donations_count,
       sum(amount) as total_amount_raised
from donations
group by date_format(donation_date, '%Y-%m'), payment_method
order by month_year desc, total_amount_raised desc;