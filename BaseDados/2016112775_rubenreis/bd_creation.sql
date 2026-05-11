DROP DATABASE IF EXISTS pam;
CREATE DATABASE pam;
USE pam;

CREATE TABLE users(
	id INT UNSIGNED AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	birthday DATE,
	gender ENUM('Male', 'Female'),
	nif CHAR(9),
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	disabled BOOLEAN DEFAULT FALSE NOT NULL,
	notes VARCHAR(255),

	CONSTRAINT pk_users_id
		PRIMARY KEY (id),

	CONSTRAINT uq_users_user
		UNIQUE (email)
) ENGINE=InnoDB;

CREATE TABLE addresses(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	country VARCHAR(100) NOT NULL,
	city VARCHAR(100) NOT NULL,
	street VARCHAR(150) NOT NULL,
	number VARCHAR(20) NOT NULL,
	zip VARCHAR(20) NOT NULL,

	CONSTRAINT pk_addresses_id
		PRIMARY KEY (id),

	CONSTRAINT fk_addresses_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_addresses_user_address
		UNIQUE (users_id, country, number, zip)
) ENGINE=InnoDB;

CREATE TABLE phones(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	number VARCHAR(20) NOT NULL,
	is_primary BOOLEAN DEFAULT FALSE NOT NULL,

	CONSTRAINT pk_phones_id
		PRIMARY KEY (id),

	CONSTRAINT fk_phones_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_phones_user_phone
		UNIQUE (users_id, number)
) ENGINE=InnoDB;

CREATE TABLE partners(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	active BOOLEAN DEFAULT TRUE NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_partners_id
		PRIMARY KEY (id),

	CONSTRAINT fk_partners_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_partners_partner
		UNIQUE (users_id)
) ENGINE=InnoDB;

CREATE TABLE volunteers(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	active BOOLEAN DEFAULT TRUE NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_volunteers_id
		PRIMARY KEY (id),

	CONSTRAINT fk_volunteers_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_volunteers_volunteer
		UNIQUE (users_id)
) ENGINE=InnoDB;

CREATE TABLE veterinarians(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	active BOOLEAN DEFAULT TRUE NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_veterinarians_id
		PRIMARY KEY (id),

	CONSTRAINT fk_veterinarians_users_id
		FOREIGN KEY(users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_veterinarians_veterinarian
		UNIQUE (users_id)
) ENGINE=InnoDB;

CREATE TABLE admins(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	active BOOLEAN DEFAULT TRUE NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_admins_id
		PRIMARY KEY (id),

	CONSTRAINT fk_admins_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_admins_admin
		UNIQUE (users_id)
) ENGINE=InnoDB;

CREATE TABLE donations(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED,
	name VARCHAR(100),
	nif CHAR(9),
	amount DECIMAL(10,2) UNSIGNED NOT NULL,
	notes VARCHAR(255),
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_donations_id
	PRIMARY KEY (id),

	CONSTRAINT fk_donations_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id),

	CONSTRAINT uq_donations_donation
		UNIQUE (nif, amount, date)
) ENGINE=InnoDB;

CREATE TABLE applications(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	position VARCHAR(100) NOT NULL,
	cv VARCHAR(255) NOT NULL,
	notes VARCHAR(255),
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_applications_id
		PRIMARY KEY (id),

	CONSTRAINT fk_applications_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_applications_application
		UNIQUE (users_id, position, cv)
) ENGINE=InnoDB;

CREATE TABLE events(
	id INT UNSIGNED AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	date_start TIMESTAMP NOT NULL,
	date_end TIMESTAMP NOT NULL,

	CONSTRAINT pk_events_id
		PRIMARY KEY (id),

	CONSTRAINT uq_events_event
		UNIQUE (name, date_start, date_end)
) ENGINE=InnoDB;

CREATE TABLE shift_volunteers(
	id INT UNSIGNED AUTO_INCREMENT,
	volunteers_id INT UNSIGNED NOT NULL, -- NOT NULL _____________________________________________________________
	date DATE NOT NULL,
	hour_start TIME NOT NULL,
	hour_end TIME NOT NULL,
	notes VARCHAR(255),

	CONSTRAINT pk_shift_volunteers_id
		PRIMARY KEY (id),

	CONSTRAINT fk_shift_volunteers_volunteers_id
		FOREIGN KEY (volunteers_id)
		REFERENCES volunteers(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_shift_volunteers_volunteer_shift
		UNIQUE (volunteers_id, date, hour_start)
) ENGINE=InnoDB;

CREATE TABLE shifts(
	id INT UNSIGNED AUTO_INCREMENT,
	hour_start TIME NOT NULL,
	hour_end TIME NOT NULL,

	CONSTRAINT pk_shifts_id
		PRIMARY KEY (id),

	CONSTRAINT uq_shifts_shift
		UNIQUE (hour_start, hour_end)
) ENGINE=InnoDB;

CREATE TABLE shifts_veterinarians(
	id INT UNSIGNED AUTO_INCREMENT,
	date DATE NOT NULL,
	shifts_id INT UNSIGNED NOT NULL,
	veterinarians_id INT UNSIGNED NOT NULL,
	notes VARCHAR(255),

	CONSTRAINT pk_shifts_veterinarians_id
		PRIMARY KEY (id),

	CONSTRAINT fk_shifts_veterinarians_shifts_id
		FOREIGN KEY (shifts_id)
		REFERENCES shifts(id),

	CONSTRAINT fk_shifts_veterinarians_veterinarians_id
		FOREIGN KEY (veterinarians_id)
		REFERENCES veterinarians(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_shifts_veterinarians_veterinarian_shift
		UNIQUE (veterinarians_id, date, shifts_id)
) ENGINE=InnoDB;

CREATE TABLE events_volunteers(
	id INT UNSIGNED AUTO_INCREMENT,
	events_id INT UNSIGNED NOT NULL,
	volunteers_id INT UNSIGNED NOT NULL,
	role VARCHAR(50) NOT NULL,

	CONSTRAINT pk_events_volunteers_id
		PRIMARY KEY (id),

	CONSTRAINT fk_events_volunteers_events_id
		FOREIGN KEY (events_id)
		REFERENCES events(id)
		ON DELETE CASCADE,

	CONSTRAINT fk_events_volunteers_volunteers_id
		FOREIGN KEY (volunteers_id)
		REFERENCES volunteers(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_events_volunteers_organizer
		UNIQUE (events_id, volunteers_id, role)
) ENGINE=InnoDB;

CREATE TABLE species(
	id INT UNSIGNED AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,

	CONSTRAINT pk_species_id
		PRIMARY KEY (id),

	CONSTRAINT uq_species_name
		UNIQUE (name)
) ENGINE=InnoDB;

CREATE TABLE breeds(
	id INT UNSIGNED AUTO_INCREMENT,
	species_id INT UNSIGNED NOT NULL,
	name VARCHAR(100) NOT NULL,

	CONSTRAINT pk_breeds_id
		PRIMARY KEY (id),

	CONSTRAINT fk_breeds_species_id
		FOREIGN KEY (species_id)
		REFERENCES species(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_breeds_breed
		UNIQUE (species_id, name)
) ENGINE=InnoDB;

CREATE TABLE animals(
	id INT UNSIGNED AUTO_INCREMENT,
	species_id INT UNSIGNED NOT NULL,
	breeds_id INT UNSIGNED,
	name VARCHAR(100) NOT NULL,
	birthday DATE NOT NULL,
	gender ENUM('Male', 'Female'),
	color VARCHAR(50),
	size ENUM('Small', 'Medium', 'Large'),
	weight DECIMAL(5,2),
	sterilized BOOLEAN DEFAULT FALSE NOT NULL,
	ownership ENUM('For adoption', 'Owned', 'Not for adoption') DEFAULT 'For Adoption' NOT NULL,
	users_id INT UNSIGNED,
	image VARCHAR(255),
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	notes VARCHAR(255),

	CONSTRAINT pk_animals_id
		PRIMARY KEY(id),

	CONSTRAINT fk_animals_species_id
		FOREIGN KEY (species_id)
		REFERENCES species(id)
		ON DELETE RESTRICT,

	CONSTRAINT fk_animals_breeds_name
		FOREIGN KEY (breeds_id)
		REFERENCES breeds(id)
		ON DELETE RESTRICT,

	CONSTRAINT fk_animals_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE participants(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	events_id INT UNSIGNED NOT NULL,

	CONSTRAINT pk_participants_id
		PRIMARY KEY (id),

	CONSTRAINT fk_participants_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT fk_participants_events_id
		FOREIGN KEY (events_id)
		REFERENCES events(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_participants_participation
		UNIQUE (users_id, events_id)
) ENGINE=InnoDB;

CREATE TABLE participants_animals(
	id INT UNSIGNED AUTO_INCREMENT,
	participants_id INT UNSIGNED NOT NULL,
	animals_id INT UNSIGNED NOT NULL,

	CONSTRAINT pk_participants_animals_id
		PRIMARY KEY (id),

	CONSTRAINT fk_participants_animals_participants_id
		FOREIGN KEY (participants_id)
		REFERENCES participants(id)
		ON DELETE CASCADE,

	CONSTRAINT fk_participants_animals_animals_id
		FOREIGN KEY (animals_id)
		REFERENCES animals(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_participants_animals_participant_animal
		UNIQUE (participants_id, animals_id)
) ENGINE=InnoDB;

CREATE TABLE checkups(
	id INT UNSIGNED AUTO_INCREMENT,
	veterinarians_id INT UNSIGNED NOT NULL,
	animals_id INT UNSIGNED NOT NULL,
	users_id INT UNSIGNED NOT NULL,
	type VARCHAR(50),
	date TIMESTAMP NOT NULL,
	status ENUM('Scheduled', 'Completed', 'Missed') DEFAULT 'Scheduled' NOT NULL,
	results TEXT(8192) NOT NULL,

	CONSTRAINT pk_checkups_id
		PRIMARY KEY (id),

	CONSTRAINT fk_checkups_veterinarians_id
		FOREIGN KEY (veterinarians_id)
		REFERENCES veterinarians(id),

	CONSTRAINT fk_checkups_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id),

	CONSTRAINT fk_checkups_animals_id
		FOREIGN KEY (animals_id)
		REFERENCES animals(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_checkups_checkup
		UNIQUE (veterinarians_id, animals_id, type, date)
) ENGINE=InnoDB;

CREATE TABLE vaccinations(
	id INT UNSIGNED AUTO_INCREMENT,
	animals_id INT UNSIGNED NOT NULL,
	checkups_id INT UNSIGNED,
	vaccine VARCHAR(150) NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,

	CONSTRAINT pk_vaccinations_id
		PRIMARY KEY (id),

	CONSTRAINT fk_vaccinations_animals_id
		FOREIGN KEY (animals_id)
		REFERENCES animals(id)
		ON DELETE CASCADE,

	CONSTRAINT fk_vaccinations_checkups_id
		FOREIGN KEY (checkups_id)
		REFERENCES checkups(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_vaccinations_vaccine
		UNIQUE (animals_id, vaccine, date)
) ENGINE=InnoDB;

CREATE TABLE adoptions(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	animals_id INT UNSIGNED NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	status ENUM( 'Pending', 'Approved', 'Denied', 'Cancelled') DEFAULT 'Pending' NOT NULL,
	notes VARCHAR(255),

	CONSTRAINT pk_adoptions_id
		PRIMARY KEY (id),

	CONSTRAINT fk_adoptions_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id)
		ON DELETE CASCADE,

	CONSTRAINT fk_adoptions_animals_id
		FOREIGN KEY (animals_id)
		REFERENCES animals(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_adoptions_adoption
		UNIQUE (users_id, animals_id)
) ENGINE=InnoDB;

CREATE TABLE missing_animals(
	id INT UNSIGNED AUTO_INCREMENT,
	users_id INT UNSIGNED NOT NULL,
	animals_id INT UNSIGNED NOT NULL,
	owner VARCHAR(100),
	phone VARCHAR(20),
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	location VARCHAR(255) NOT NULL,
	notes VARCHAR(255),
	status ENUM('Missing', 'Found') DEFAULT 'Missing' NOT NULL,

	CONSTRAINT pk_missing_animals_id
		PRIMARY KEY (id),

	CONSTRAINT fk_missing_animals_users_id
		FOREIGN KEY (users_id)
		REFERENCES users(id),

	CONSTRAINT fk_missing_animals_animals_id
		FOREIGN KEY (animals_id)
		REFERENCES animals(id)
		ON DELETE CASCADE,

	CONSTRAINT uq_missing_animals_missing
		UNIQUE (animals_id, date)
) ENGINE=InnoDB;