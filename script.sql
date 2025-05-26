DROP DATABASE IF EXISTS ticketing;


CREATE DATABASE IF NOT EXISTS ticketing;

use ticketing;


CREATE TABLE tp_client(c_id INT AUTO_INCREMENT,
                                c_firstname VARCHAR(50) NOT NULL,
                                                        c_lastname VARCHAR(50) NOT NULL,
                                                                               PRIMARY KEY(c_id));


CREATE TABLE tp_project(p_id INT AUTO_INCREMENT,
                                 p_name VARCHAR(50) NOT NULL,
                                                    p_description VARCHAR(50),
                                                                  p_creation DATETIME NOT NULL,
                                                                                      p_due_date DATETIME NOT NULL,
                                                                                                          t_timestamp_modification DATETIME NOT NULL,
                                                                                                                                            t_timestamp_closed DATETIME,
                                                                                                                                            c_id INT NOT NULL,
                                                                                                                                                     PRIMARY KEY(p_id),
                        FOREIGN KEY(c_id) REFERENCES tp_client(c_id));


CREATE TABLE tp_priority(p_id INT AUTO_INCREMENT,
                                  p_name VARCHAR(10) NOT NULL,
                                                     p_description VARCHAR(50),
                                                                   PRIMARY KEY(p_id));


CREATE TABLE tp_status(s_id INT AUTO_INCREMENT,
                                s_name VARCHAR(10) NOT NULL,
                                                   s_description VARCHAR(50),
                                                                 PRIMARY KEY(s_id));


CREATE TABLE tp_role(r_id INT AUTO_INCREMENT,
                              r_name VARCHAR(30) NOT NULL,
                                                 r_description VARCHAR(100),
                                                               r_timestamp_addition DATETIME NOT NULL,
                                                                                             r_timestamp_modification DATETIME NOT NULL,
                                                                                                                               PRIMARY KEY(r_id));


CREATE TABLE tp_user(u_id INT AUTO_INCREMENT,
                              u_login VARCHAR(50) NOT NULL,
                                                  u_firstname VARCHAR(50) NOT NULL,
                                                                          u_lastname VARCHAR(50) NOT NULL,
                                                                                                 u_email VARCHAR(50) NOT NULL,
                                                                                                                     u_password TEXT NOT NULL,
                                                                                                                                     u_timestamp_creation DATETIME,
                                                                                                                                     u_timestamp_modification DATETIME NOT NULL,
                                                                                                                                                                       u_profile_picture TEXT, u_gender BOOLEAN NOT NULL,
                                                                                                                                                                                                                u_phone_number VARCHAR(10),
                                                                                                                                                                                                                               u_email_verified BOOLEAN, u_status INT NOT NULL,
                                                                                                                                                                                                                                                                      u_description VARCHAR(50),
                                                                                                                                                                                                                                                                                    r_id INT NOT NULL,
                                                                                                                                                                                                                                                                                             PRIMARY KEY(u_id),
                                                                                                                                                                                                                                                                                                     UNIQUE(u_login),
                                                                                                                                                                                                                                                                                                     UNIQUE(u_email),
                     FOREIGN KEY(r_id) REFERENCES tp_role(r_id));


CREATE TABLE tp_ticket(t_id INT AUTO_INCREMENT,
                                t_desription VARCHAR(300),
                                             t_creation DATETIME NOT NULL,
                                                                 t_due_date DATETIME,
                                                                 t_timestamp_modification DATETIME,
                                                                 t_timestamp_closed DATETIME,
                                                                 c_id INT, p_id INT NOT NULL,
                                                                                    s_id INT NOT NULL,
                                                                                             PRIMARY KEY(t_id),
                       FOREIGN KEY(c_id) REFERENCES tp_client(c_id),
                       FOREIGN KEY(p_id) REFERENCES tp_priority(p_id),
                       FOREIGN KEY(s_id) REFERENCES tp_status(s_id));


CREATE TABLE Attach(t_id INT, p_id INT, PRIMARY KEY(t_id, p_id),
                    FOREIGN KEY(t_id) REFERENCES tp_ticket(t_id),
                    FOREIGN KEY(p_id) REFERENCES tp_project(p_id));


CREATE TABLE tp_work(u_id INT, t_id INT, w_commentary TEXT, w_timestamp_modification DATETIME,
                                                            PRIMARY KEY(u_id, t_id),
                     FOREIGN KEY(u_id) REFERENCES tp_user(u_id),
                     FOREIGN KEY(t_id) REFERENCES tp_ticket(t_id));


CREATE TABLE Manage(u_id INT, c_id INT, PRIMARY KEY(u_id, c_id),
                    FOREIGN KEY(u_id) REFERENCES tp_user(u_id),
                    FOREIGN KEY(c_id) REFERENCES tp_client(c_id));


CREATE TABLE Handle(u_id INT, p_id INT, PRIMARY KEY(u_id, p_id),
                    FOREIGN KEY(u_id) REFERENCES tp_user(u_id),
                    FOREIGN KEY(p_id) REFERENCES tp_project(p_id));

---------------------------------------------
 -- Insertion

INSERT INTO `tp_role` (`r_id`, `r_name`, `r_description`, `r_timestamp_addition`, `r_timestamp_modification`)
VALUES (NULL,
        'Administrateur',
        'Utilisateur chargé de la gestion des utilisateurs et les projets',
        '2025-05-17 18:02:57.000000',
        '2025-05-17 18:02:57.000000'), (NULL,
                                        'Développeur',
                                        'Utilisateur chargé du traitement des tickets',
                                        '2025-05-17 18:02:57.000000',
                                        '2025-05-17 18:02:57.000000'), (NULL,
                                                                        'Rapporteur',
                                                                        'Utilisateur enregistrant les tickets',
                                                                        '2025-05-17 18:02:57.000000',
                                                                        '2025-05-17 18:02:57.000000');

