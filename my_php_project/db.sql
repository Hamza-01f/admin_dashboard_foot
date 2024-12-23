-- Use the specified database
USE adminfutchampions;

-- nationality
CREATE TABLE nationality (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nationality VARCHAR(20) NOT NULL,
    flag VARCHAR(60) NOT NULL
);

-- club
CREATE TABLE club (
    id INT AUTO_INCREMENT PRIMARY KEY,
    club_name VARCHAR(30) NOT NULL,
    logo VARCHAR(60) NOT NULL
);

-- players
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_player VARCHAR(30) NOT NULL,  
    photo VARCHAR(100) NOT NULL,
    position VARCHAR(5) NOT NULL,
    deleted_players VARCHAR(5),
    rating INT,
    nationality_id INT,
    club_id INT,
    FOREIGN KEY (nationality_id) REFERENCES nationality(id),
    FOREIGN KEY (club_id) REFERENCES club(id)
);


CREATE TABLE players_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pace INT,
    shooting INT,
    passing INT,
    dribbling INT,
    defending INT,
    physical INT,
    players_id INT,
    FOREIGN KEY (players_id) REFERENCES players(id)
);

-- gk_fields
CREATE TABLE gk_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    diving INT,
    handling INT,
    kicking INT,
    reflexes INT,
    speed INT,
    positioning INT,
    players_id INT,
    FOREIGN KEY (players_id) REFERENCES players(id)
);


ALTER TABLE players
ADD statu VARCHAR(10);


INSERT INTO club (club_name, logo) VALUES
('Inter Miami', 'https://cdn.sofifa.net/meta/team/239235/120.png'),
('Al Nassr', 'https://cdn.sofifa.net/meta/team/2506/120.png'),
('Manchester City', 'https://cdn.sofifa.net/players/239/085/25_120.png'),
('Real Madrid', 'https://cdn.sofifa.net/meta/team/3468/120.png'),
('Al-Hilal', 'https://cdn.sofifa.net/meta/team/7011/120.png'),
('Liverpool', 'https://cdn.sofifa.net/meta/team/8/120.png'),
('Bayern Munich', 'https://cdn.sofifa.net/meta/team/503/120.png'),
('Atletico Madrid', 'https://cdn.sofifa.net/meta/team/7980/120.png'),
('Al-Ittihad', 'https://cdn.sofifa.net/meta/team/476/120.png'),
('Manchester United', 'https://cdn.sofifa.net/meta/team/14/120.png');

ALTER TABLE nationality MODIFY nationality VARCHAR(30);
-- Insert data into nationality table
INSERT INTO nationality (nationality, flag)
VALUES
('Argentina', 'https://cdn.sofifa.net/flags/ar.png'),
('Portugal', 'https://cdn.sofifa.net/flags/pt.png'),
('Belgium', 'https://cdn.sofifa.net/flags/be.png'),
('France', 'https://cdn.sofifa.net/flags/fr.png'),
('Netherlands', 'https://cdn.sofifa.net/flags/nl.png'),
('Germany', 'https://cdn.sofifa.net/flags/de.png'),
('Egypt', 'https://cdn.sofifa.net/flags/eg.png'),
('Croatia', 'https://cdn.sofifa.net/flags/hr.png'),
('Morocco', 'https://cdn.sofifa.net/flags/ma.png'),
('Norway', 'https://cdn.sofifa.net/flags/no.png'),
('Canada', 'https://cdn.sofifa.net/flags/ca.png');

