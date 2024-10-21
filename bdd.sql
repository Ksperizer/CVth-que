CREATE DATABASE IF NOT EXISTS 'cv_db';
USE 'cv_db';

CREATE TABLE 'users' (
    id int AUTOINCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    password varchar(255) NOT NULL
) 

CREATE TABLE 'CV'(
    id UUID AUTOINCREMENT PRIMARY KEY,
    title varchar(50) NOT NULL,
    description varchar(50) NOT NULL,
    date DATE NOT NULL,
    user_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)

CREATE TABLE 'Projects'(
    id int AUTOINCREMENT PRIMARY KEY,
    title varchar(50) NOT NULL,
    description varchar(200) NOT NULL,
    date DATE NOT NULL,
    user_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)

)