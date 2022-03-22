DELETE FROM events;
CREATE TABLE users (id serial PRIMARY KEY, username varchar (50) NOT NULL, password varchar (250) NOT NULL);
INSERT INTO users (username, password) VALUES ('Admin', md5('admin'));

CREATE TABLE clubs (id_club serial PRIMARY KEY, club_name varchar (100) NOT NULL, link_club varchar (100));
INSERT INTO clubs (club_name) VALUES ('Портал');
INSERT INTO clubs (club_name) VALUES ('Убежище');
INSERT INTO clubs (club_name) VALUES ('Единорог');
INSERT INTO clubs (club_name) VALUES ('Лига');

CREATE TABLE formats (id_format serial PRIMARY KEY, format_name varchar (100) NOT NULL);
INSERT INTO formats (format_name) VALUES ('Standard');
INSERT INTO formats (format_name) VALUES ('Brawl');

CREATE TABLE events (id_event serial PRIMARY KEY, id_club integer REFERENCES clubs, id_format  integer REFERENCES formats, date date NOT NULL, time time NOT NULL, cost integer NOT NULL,  comment varchar (100));
