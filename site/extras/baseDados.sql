drop schema if exists adoption;
create schema adoption;
use adoption;

drop table if exists species;
create table species(
    id INT NOT NULL auto_increment,
    name VARCHAR(20) NOT NULL,
    constraint pk_species_id primary key (id)
) engine=InnoDB;

drop table if exists breeds;
create table breeds(
    id INT NOT NULL auto_increment,
    specie_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    constraint pk_breeds_id primary key (id),
    constraint fk_species foreign key(specie_id) references species(id) on delete cascade
    ) engine= InnoDB;

drop table if exists animals;
create table animals(  
    id INT NOT NULL auto_increment,  
    name VARCHAR(100) NOT NULL,
    breed_id INT NOT NULL,
    gender ENUM('Macho', 'Fêmea') NULL,
    image VARCHAR(255) Null,
    birth_date DATE NULL,
    description TEXT NULL,
    status ENUM('disponível', 'adotado', 'em processo') DEFAULT 'disponível',
    created_at TIMESTAMP default current_timestamp,
    constraint pk_animals_id primary key (id),
    constraint fk_breeds foreign key(breed_id) references breeds(id) on delete cascade
    ) engine=InnoDB;

drop table if exists adopters;
create table adopters( 
    id INT NOT NULL auto_increment, 
    full_name VARCHAR(150) NOT NULL,  
    email VARCHAR(100) NOT NULL,  
    phone VARCHAR(20) NOT NULL,
    house_type ENUM('casa', 'apartamento') NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP default current_timestamp,
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
    constraint pk_adopters_id primary key (id)
    )engine=InnoDB;

drop table if exists adoption_processes;
create table adoption_processes(
    id INT NOT NULL auto_increment,    
    adopter_id INT not null,    
    animal_id INT not null,    
    status ENUM('pendente', 'aprovado', 'rejeitado') default 'pendente',    
    start_date timestamp default current_timestamp,    
    notes text null,
    constraint pk_adoption_processes_id primary key (id), 
    constraint fk_adopters foreign key(adopter_id) references adopters(id) on delete cascade,    
    constraint fk_animals foreign key(animal_id) references animals(id) on delete cascade
    ) engine=InnoDB;

insert into species (name) values ('Cão'), ('Gato'), ('Pássaro'), ('Peixe'), ('Roedor'), ('Réptil');

insert into breeds (specie_id, name) values (1, 'Labrador'), (1, 'Bulldog'), (2, 'Siamese'), (2, 'Persa'), (3, 'Canários'), (3, 'Periquito'), (4, 'Nemo'), (4, 'Betta'), (5, 'Coelho'), (5, 'Hamster'), (6, 'Tartaruga'), (6, 'Cobra');

insert into animals (name, breed_id, gender, birth_date, description) values ('Roger', 1, 'Macho', '2020-01-01', 'Animal meigo');



