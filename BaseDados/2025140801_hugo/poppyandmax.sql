DROP DATABASE IF EXISTS poopyandmax;
CREATE DATABASE poopyandmax;
USE poopyandmax;

CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Address VARCHAR(255),
    Email VARCHAR(150) UNIQUE NOT NULL,
    Cellphone VARCHAR(20) UNIQUE,
    Permissions TEXT
) ENGINE=InnoDB;

CREATE TABLE Animals (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Species VARCHAR(50),
    Race VARCHAR(100),
    Status ENUM('shelter', 'adopted', 'fostered', 'medical') DEFAULT 'shelter',
    Birthday DATE,
    Vaccinations TEXT
) ENGINE=InnoDB;

CREATE TABLE Volunteers (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Availability TEXT,
    CONSTRAINT fk_vol_user FOREIGN KEY (User_ID) REFERENCES Users(ID)
) ENGINE=InnoDB;

CREATE TABLE Workers (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Shifts VARCHAR(255),
    Position VARCHAR(100),
    CONSTRAINT fk_worker_user FOREIGN KEY (User_ID) REFERENCES Users(ID)
) ENGINE=InnoDB;

CREATE TABLE Events (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Date_start DATETIME,
    Date_end DATETIME,
    Description TEXT
) ENGINE=InnoDB;

CREATE TABLE Appointments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Reason VARCHAR(255),
    User_ID INT NOT NULL,
    Animal_ID INT NOT NULL,
    Appt_Date DATETIME,
    Notes TEXT,
    CONSTRAINT fk_appt_user FOREIGN KEY (User_ID) REFERENCES Users(ID),
    CONSTRAINT fk_appt_animal FOREIGN KEY (Animal_ID) REFERENCES Animals(ID)
) ENGINE=InnoDB;

CREATE TABLE Applications (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Birthday DATE,
    CV_Path VARCHAR(255),
    Notes TEXT,
    CONSTRAINT fk_app_user FOREIGN KEY (User_ID) REFERENCES Users(ID)
) ENGINE=InnoDB;

CREATE TABLE Adoptions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Animal_ID INT NOT NULL,
    Adoption_Date DATE,
    Notes TEXT,
    CONSTRAINT fk_adopt_user FOREIGN KEY (User_ID) REFERENCES Users(ID),
    CONSTRAINT fk_adopt_animal FOREIGN KEY (Animal_ID) REFERENCES Animals(ID)
) ENGINE=InnoDB;

CREATE TABLE Donations (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT DEFAULT NULL, -- NULL for anonymous donations
    Amount DECIMAL(10, 2) NOT NULL,
    Note TEXT,
    Donation_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_don_user FOREIGN KEY (User_ID) REFERENCES Users(ID) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Users
INSERT INTO Users (Name, Password, Address, Email, Cellphone, Permissions) VALUES
('Alice Smith', sha2('123',512), '123 Pine St', 'alice@email.com', '555-0101', 'Admin'),
('Bob Jones', sha2('124',512), '456 Oak St', 'bob@email.com', '555-0102', 'User'),
('Charlie Day', sha2('125',512), '789 Maple Ave', 'charlie@email.com', '555-0103', 'Worker'),
('Diana Prince', sha2('126',512), '101 Wonder Ln', 'diana@email.com', '555-0104', 'Volunteer'),
('Edward Norton', sha2('127',512), '202 Fight Dr', 'ed@email.com', '555-0105', 'User'),
('Fiona Glen', sha2('128',512), '303 Shrek Rd', 'fiona@email.com', '555-0106', 'User'),
('George King', sha2('129',512), '404 Error Blvd', 'george@email.com', '555-0107', 'Volunteer'),
('Hannah Abbott', sha2('120',512), '505 Hufflepuff', 'hannah@email.com', '555-0108', 'User'),
('Ian Wright', sha2('122',512), '606 Goal Ave', 'ian@email.com', '555-0109', 'Worker'),
('Jenny Slate', sha2('121',512), '707 Funny Way', 'jenny@email.com', '555-0110', 'User');

-- Animals
INSERT INTO Animals (Name, Species, Race, Status, Birthday, Vaccinations) VALUES
('Buddy', 'Dog', 'Retriever', 'shelter', '2021-05-10', 'Rabies, Parvo'),
('Mittens', 'Cat', 'Tuxedo', 'adopted', '2022-01-15', 'FVRCP'),
('Luna', 'Dog', 'Husky', 'shelter', '2020-11-20', 'Rabies, DHPP'),
('Rex', 'Dog', 'German Shepherd', 'medical', '2019-03-30', 'All Current'),
('Oliver', 'Cat', 'Tabby', 'fostered', '2023-06-01', 'None'),
('Bella', 'Dog', 'Samoyed', 'shelter', '2022-08-12', 'Rabies'),
('Simba', 'Cat', 'Lion-Cut', 'adopted', '2018-04-05', 'All Current'),
('Daisy', 'Dog', 'Dalmatian', 'shelter', '2021-12-25', 'Parvo'),
('Shadow', 'Cat', 'Persian', 'medical', '2017-09-14', 'FVRCP'),
('Cooper', 'Dog', 'Beagle', 'fostered', '2023-02-28', 'Bordetella');

-- Volunteers
INSERT INTO Volunteers (User_ID, Availability) VALUES
(4, 'Weekends'), (7, 'Mornings'), (1, 'On Call'), (2, 'Evenings'), (3, 'Tuesdays'),
(5, 'Fridays'), (6, 'Weekends'), (8, 'Flexible'), (9, 'Afternoons'), (10, 'Mondays');

-- Workers
INSERT INTO Workers (User_ID, Shifts, Position) VALUES
(3, 'Day Shift', 'Lead Vet'), (9, 'Night Shift', 'Manager'), (1, 'Day Shift', 'Admin'),
(2, 'Evening', 'Cleaner'), (4, 'Night Shift', 'Security'), (5, 'Day Shift', 'Trainer'),
(6, 'Rotating', 'Groomer'), (7, 'Day Shift', 'Vet Tech'), (8, 'Night Shift', 'Caregiver'), (10, 'Day Shift', 'Front Desk');

-- Events
INSERT INTO Events (Name, Date_start, Date_end, Description) VALUES
('Adoption Day', '2026-06-01 10:00:00', '2026-06-01 16:00:00', 'Find a new friend!'),
('Vaccine Clinic', '2026-06-15 09:00:00', '2026-06-15 14:00:00', 'Cheap shots for pets.'),
('Puppy Yoga', '2026-07-01 08:00:00', '2026-07-01 09:30:00', 'Relax with pups.'),
('Charity Gala', '2026-07-20 19:00:00', '2026-07-20 23:00:00', 'Fundraising dinner.'),
('Training Workshop', '2026-08-05 13:00:00', '2026-08-05 17:00:00', 'Learn dog basics.'),
('Kitten Shower', '2026-08-10 11:00:00', '2026-08-10 14:00:00', 'Supplies for kittens.'),
('Paws Walk', '2026-09-12 07:00:00', '2026-09-12 11:00:00', '5k run with dogs.'),
('Pet Photos', '2026-10-05 10:00:00', '2026-10-05 18:00:00', 'Holiday portraits.'),
('Volunteer Intro', '2026-10-15 17:00:00', '2026-10-15 19:00:00', 'New helper orientation.'),
('Winter Warmup', '2026-11-01 09:00:00', '2026-11-01 12:00:00', 'Blanket drive.');

-- Appointments
INSERT INTO Appointments (Reason, User_ID, Animal_ID, Appt_Date, Notes) VALUES
('Checkup', 2, 1, '2026-05-10 10:00:00', 'Annual vaccines'),
('Adoption Meet', 5, 3, '2026-05-11 14:30:00', 'Wants a husky'),
('Grooming', 8, 5, '2026-05-12 09:00:00', 'Trim nails'),
('Dental', 10, 7, '2026-05-13 11:00:00', 'Cleaning'),
('Surgery', 1, 9, '2026-05-14 08:00:00', 'Neutering'),
('Behavior', 6, 2, '2026-05-15 15:00:00', 'Anxiety issues'),
('Wound Care', 4, 4, '2026-05-16 10:00:00', 'Paw injury'),
('Checkup', 2, 6, '2026-05-17 12:00:00', 'New arrival'),
('Vaccine', 7, 8, '2026-05-18 13:00:00', 'Second booster'),
('Adoption Meet', 5, 10, '2026-05-19 16:00:00', 'Follow up');

-- Applications
INSERT INTO Applications (User_ID, Birthday, CV_Path, Notes) VALUES
(2, '1995-04-20', '/cvs/bob.pdf', 'Interested in fostering'),
(5, '1990-12-10', '/cvs/ed.pdf', 'Loves big dogs'),
(6, '1988-01-05', '/cvs/fiona.pdf', 'Previous vet tech'),
(8, '2000-07-22', '/cvs/hannah.pdf', 'Student volunteer'),
(10, '1993-09-30', '/cvs/jenny.pdf', 'Work from home'),
(1, '1985-03-15', '/cvs/alice.pdf', 'High level admin'),
(4, '1992-06-11', '/cvs/diana.pdf', 'Security background'),
(7, '1999-11-01', '/cvs/george.pdf', 'Cat specialist'),
(3, '1982-05-25', '/cvs/charlie.pdf', 'Expert cleaner'),
(9, '1991-08-14', '/cvs/ian.pdf', 'Management exp');

-- Adoptions
INSERT INTO Adoptions (User_ID, Animal_ID, Adoption_Date, Notes) VALUES
(2, 2, '2026-01-20', 'Happy home'), (5, 7, '2026-02-15', 'Barn cat'), 
(6, 1, '2026-03-10', 'First dog'), (8, 4, '2026-03-22', 'Therapy dog'),
(10, 9, '2026-04-05', 'Quiet home'), (1, 3, '2026-04-12', 'Active family'),
(4, 5, '2026-04-18', 'Indoor only'), (7, 6, '2026-04-25', 'Samoyed fan'),
(3, 8, '2026-05-01', 'Farm dog'), (9, 10, '2026-05-04', 'Beagle lover');

-- Donations
INSERT INTO Donations (User_ID, Amount, Note) VALUES
(1, 50.00, 'Monthly support'), (2, 25.50, 'For food'), (NULL, 100.00, 'Anonymous gift'),
(5, 10.00, 'Small help'), (8, 500.00, 'Legacy donation'), (10, 15.00, 'Birthday gift'),
(NULL, 20.00, 'Coffee money'), (4, 45.00, 'Vet bill aid'), (7, 120.00, 'New kennels'),
(NULL, 250.00, 'General fund');

CREATE VIEW Active_Animals_Summary AS
SELECT 
    Name, 
    Species, 
    Race, 
    Status, 
    TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) AS Age_Years,
    Vaccinations
FROM Animals
WHERE Status != 'adopted';

CREATE VIEW Staff_Directory AS
SELECT 
    u.Name, 
    u.Email, 
    u.Cellphone,
    CASE 
        WHEN w.ID IS NOT NULL AND v.ID IS NOT NULL THEN 'Both'
        WHEN w.ID IS NOT NULL THEN 'Worker'
        WHEN v.ID IS NOT NULL THEN 'Volunteer'
        ELSE 'General User'
    END AS Role,
    w.Position AS Job_Title,
    v.Availability
FROM Users u
LEFT JOIN Workers w ON u.ID = w.User_ID
LEFT JOIN Volunteers v ON u.ID = v.User_ID;

CREATE VIEW Upcoming_Appointments AS
SELECT 
    a.Appt_Date,
    u.Name AS Client_Name,
    an.Name AS Animal_Name,
    a.Reason,
    a.Notes
FROM Appointments a
JOIN Users u ON a.User_ID = u.ID
JOIN Animals an ON a.Animal_ID = an.ID
WHERE a.Appt_Date >= NOW()
ORDER BY a.Appt_Date ASC;

CREATE VIEW Adoption_History AS
SELECT 
    ad.Adoption_Date,
    u.Name AS Adopter_Name,
    u.Email AS Adopter_Email,
    an.Name AS Animal_Name,
    an.Species,
    ad.Notes AS Adoption_Notes
FROM Adoptions ad
JOIN Users u ON ad.User_ID = u.ID
JOIN Animals an ON ad.Animal_ID = an.ID;

CREATE VIEW Donation_Report AS
SELECT 
    COALESCE(u.Name, 'Anonymous') AS Donor_Name,
    d.Amount,
    d.Donation_Date,
    d.Note
FROM Donations d
LEFT JOIN Users u ON d.User_ID = u.ID
ORDER BY d.Donation_Date DESC;
