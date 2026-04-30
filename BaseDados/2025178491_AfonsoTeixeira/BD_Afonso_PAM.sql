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
    role enum('admin', 'adotante', 'voluntario') not null,
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
    breed_id int not null,
    gender enum('m', 'f'),
    size enum('pequeno', 'médio', 'grande'),
    image varchar(255),
    birth_date date,
    description text,
    status enum('disponível', 'adotado', 'em processo') not null,
    created_at timestamp default current_timestamp,
    constraint pk_animals primary key (id),
    constraint fk_animals_breeds foreign key (breed_id) references breeds(id)
) engine=innodb;

drop table if exists adoption_processes;
create table adoption_processes (
    id int auto_increment,
    user_id int not null,
    animal_id int not null,
    status enum('pendente', 'aprovado', 'rejeitado') default 'pendente',
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
    location varchar(150) not null,
    description text,
    event_type varchar(50) not null,
    constraint pk_events primary key (id)
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
    skills text,
    availability varchar(100),
    join_date date default (current_date),
    constraint pk_volunteer_profiles primary key (id),
    constraint fk_volunteer_users foreign key (user_id) references users(id)
) engine=innodb;

drop table if exists volunteer_shifts;
create table volunteer_shifts (
    id int auto_increment,
    volunteer_id int not null,
    task_description text not null,
    shift_date date not null,
    start_date time not null,
    end_time time not null,
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
    photo varchar(255),
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
('admin', 'admin@email.com', 'pass123', '910000001', 'porto', 'admin'),
('maria silva', 'maria@email.com', 'pass123', '910000002', 'lisboa', 'adotante'),
('joão pinto', 'joao@email.com', 'pass123', '910000003', 'braga', 'voluntario'),
('ana costa', 'ana@email.com', 'pass123', '910000004', 'faro', 'adotante'),
('pedro santos', 'pedro@email.com', 'pass123', '910000005', 'aveiro', 'voluntario'),
('carla matos', 'carla@email.com', 'pass123', '910000006', 'porto', 'adotante'),
('rui silva', 'rui@email.com', 'pass123', '910000007', 'coimbra', 'adotante'),
('sofia bento', 'sofia@email.com', 'pass123', '910000008', 'viana', 'voluntario'),
('tiago ferreira', 'tiago@email.com', 'pass123', '910000009', 'lisboa', 'adotante'),
('marta luz', 'marta@email.com', 'pass123', '910000010', 'braga', 'adotante');

insert into species (name) values 
('cão'), ('gato'), ('coelho'), ('pássaro'), ('hamster'), 
('réptil'), ('peixe'), ('furão'), ('porquinho da india'), ('tartaruga');

insert into breeds (specie_id, name) values 
(1, 'labrador'), (1, 'poodle'), (2, 'siamês'), (2, 'persa'), (3, 'anão holandês'),
(4, 'canário'), (5, 'sírio'), (8, 'standard'), (9, 'abissínio'), (10, 'corcunda de mississipi');

insert into animals (name, breed_id, gender, size, status) values 
('max', 1, 'm', 'grande', 'disponível'),
('poppy', 3, 'f', 'pequeno', 'adotado'),
('thor', 1, 'm', 'grande', 'em processo'),
('luna', 4, 'f', 'médio', 'disponível'),
('boby', 2, 'm', 'pequeno', 'disponível'),
('nina', 2, 'f', 'pequeno', 'disponível'),
('simba', 3, 'm', 'médio', 'adotado'),
('mel', 5, 'f', 'pequeno', 'disponível'),
('fred', 6, 'm', 'pequeno', 'disponível'),
('tico', 7, 'm', 'pequeno', 'disponível');

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

insert into veterinarians (name, license_number, specialty, phone) values 
('dr. silva', 'vet001', 'cirurgia', '220000001'),
('dra. ana', 'vet002', 'clínica geral', '220000002'),
('dr. mendes', 'vet003', 'exóticos', '220000003'),
('dra. beatriz', 'vet004', 'dermatologia', '220000004'),
('dr. carlos', 'vet005', 'ortopedia', '220000005'),
('dra. diana', 'vet006', 'oftalmologia', '220000006'),
('dr. eusebio', 'vet007', 'cardiologia', '220000007'),
('dra. fernanda', 'vet008', 'comportamento', '220000008'),
('dr. gabriel', 'vet009', 'clínica geral', '220000009'),
('dra. helena', 'vet010', 'neurologia', '220000010');

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

insert into events (name, event_date, location, event_type) values 
('feira de adoção', '2026-05-01 10:00', 'parque da cidade', 'feira'),
('recolha de ração', '2026-07-15 09:00', 'supermercado x', 'recolha'),
('workshop treino', '2026-06-01 15:00', 'sede associação', 'educação'),
('caminhada cãopanheira', '2026-08-20 08:30', 'avenida central', 'convívio'),
('jantar solidário', '2026-07-10 20:00', 'restaurante y', 'angariação'),
('banho e tosquia solidário', '2026-07-25 10:00', 'sede', 'serviço'),
('visita escola a', '2026-09-05 14:00', 'escola básica 1', 'educação'),
('mega feira verão', '2026-08-20 10:00', 'praça principal', 'feira'),
('peddy paper animal', '2026-09-05 09:30', 'mata nacional', 'convívio'),
('venda de natal', '2026-12-01 10:00', 'sede', 'feira');

insert into events_registrations (user_id, event_id, status) values 
(2, 1, 'confirmado'), (4, 1, 'confirmado'), (6, 2, 'confirmado'),
(7, 3, 'pendente'), (9, 4, 'confirmado'), (10, 5, 'confirmado'),
(2, 6, 'pendente'), (4, 8, 'confirmado'), (6, 8, 'confirmado'),
(7, 10, 'confirmado');

insert into volunteer_profiles (user_id, skills, availability) values 
(3, 'limpeza, passeio', 'fins de semana'), (5, 'treino canino', 'terças e quintas'),
(8, 'administrativo', 'segunda a sexta'), (1, 'primeiros socorros', 'noites'),
(2, 'fotografia', 'sábados'), (4, 'redes sociais', 'remoto'),
(6, 'condução', 'flexível'), (7, 'tosquia', 'domingos'),
(9, 'organização eventos', 'fins de semana'), (10, 'manutenção', 'manhãs');

insert into volunteer_shifts (volunteer_id, task_description, shift_date, start_date, end_time) values 
(1, 'limpeza canis', '2026-04-10', '09:00', '12:00'),
(2, 'aula de obediência', '2026-04-10', '14:00', '16:00'),
(3, 'atendimento público', '2026-04-11', '10:00', '13:00'),
(4, 'passeio de cães', '2026-12-12', '15:00', '18:00'),
(5, 'sessão fotos', '2026-04-13', '09:00', '11:00'),
(6, 'gestão fb', '2026-04-14', '14:00', '15:00'),
(7, 'transporte vet', '2026-08-15', '08:00', '10:00'),
(8, 'apoio banhos', '2026-04-16', '10:00', '13:00'),
(9, 'planeamento feira', '2026-04-17', '18:00', '20:00'),
(10, 'reparação vedações', '2026-06-18', '09:00', '13:00');

insert into lost_animals (user_id, animal_name, last_seen_date, contact_phone) values 
(2, 'bolinha', '2026-04-01', '910000002'), (4, 'pipas', '2026-04-02', '910000004'),
(6, 'rex', '2026-04-03', '910000006'), (7, 'fifi', '2026-04-04', '910000007'),
(9, 'lulu', '2026-04-05', '910000009'), (10, 'pantufa', '2026-04-06', '910000010'),
(1, 'kiko', '2026-04-07', '910000002'), (3, 'mimi', '2026-04-08', '910000004'),
(5, 'toby', '2026-04-09', '910000006'), (8, 'nini', '2026-04-10', '910000007');

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
select name as event_name, event_type, event_date, location,
       case 
           when event_date < current_date then 'Concluído' 
           when date(event_date) = current_date then 'A decorrer hoje'
           else 'Próximo' 
       end as event_status
from events
order by event_date asc;

drop view if exists vw_event_capacity_planning;
create view vw_event_capacity_planning as
select e.name as event_name, e.event_date,
       count(er.id) as total_registrations,
       sum(case when er.status = 'confirmado' then 1 else 0 end) as confirmed_attendees
from events e
left join events_registrations er on e.id = er.event_id
group by e.id, e.name, e.event_date;

drop view if exists vw_volunteer_skills_matrix;
create view vw_volunteer_skills_matrix as
select u.full_name, u.phone, u.local, vp.skills, vp.availability,
       datediff(current_date, vp.join_date) as days_as_volunteer
from volunteer_profiles vp
join users u on vp.user_id = u.id
order by days_as_volunteer desc;

drop view if exists vw_daily_shifts_schedule;
create view vw_daily_shifts_schedule as
select vs.shift_date, vs.start_date as start_time, vs.end_time, vs.task_description, u.full_name as volunteer
from volunteer_shifts vs
join volunteer_profiles vp on vs.volunteer_id = vp.id
join users u on vp.user_id = u.id
order by vs.shift_date desc, vs.start_date asc;

drop view if exists vw_lost_pets_radar;
create view vw_lost_pets_radar as
select la.animal_name, u.full_name as reporter_name, la.contact_phone, la.last_seen_date,
       datediff(current_date, la.last_seen_date) as days_missing
from lost_animals la
join users u on la.user_id = u.id
order by days_missing asc;

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