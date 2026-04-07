DROP SCHEMA IF EXISTS adoption;
CREATE SCHEMA adoption;
USE adoption;

drop table if exists species;
CREATE TABLE species(
    id INT NOT NULL auto_increment primary key,
    name VARCHAR(20) NOT NULL
) engine=InnoDB;

drop table if exists breeds;
CREATE TABLE breeds(
    id INT NOT NULL auto_increment primary key,
    specie_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    constraint fk_species foreign key(specie_id) references species(id) on delete cascade
    ) engine= InnoDB;

drop table if exists animals;
CREATE TABLE animals(  
    id INT NOT NULL auto_increment primary key,  
    name VARCHAR(100) NOT NULL,
    breed_id INT NOT NULL,
    gender ENUM('M', 'F') NULL,
    image VARCHAR(255) Null,
    birth_date DATE NULL,
    description TEXT NULL,
    status ENUM('disponível', 'adotado', 'em processo') DEFAULT 'disponível',
    created_at TIMESTAMP default current_timestamp,
    constraint fk_breeds foreign key(breed_id) references breeds(id) on delete cascade
    ) engine=InnoDB;


drop table if exists adopters;
CREATE TABLE adopters( 
    id INT NOT NULL auto_increment primary key, 
    full_name VARCHAR(150) NOT NULL,  
    email VARCHAR(100) NOT NULL,  
    phone VARCHAR(20) NOT NULL,
    house_type ENUM('casa', 'apartamento') NULL,
    status BOOLEAN DEFAULT TRUE, 
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE
    )engine=InnoDB;

drop table if exists adoption_processes;
CREATE table adoption_processes( 
    id INT auto_increment primary key,    
    adopter_id INT not null,    
    animal_id INT not null,    
    status ENUM('pendente', 'aprovado', 'rejeitado') default 'pendente',    
    start_date timestamp default current_timestamp,    
    notes text null,    
    constraint fk_adopters foreign key(adopter_id) references adopters(id) on delete cascade,    
    constraint fk_animals foreign key(animal_id) references animals(id) on delete cascade
    ) engine=InnoDB;






