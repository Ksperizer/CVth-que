CREATE DATABASE CVth - ques 

use CVth - ques

CREATE TABLE 'users' (
    id int AUTOINCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    password varchar(50) NOT NULL  
) 

CREATE TABLE 'CV'(
    id int AUTOINCREMENT PRIMARY KEY,
    title varchar(50) NOT NULL,
    description varchar(50) NOT NULL,
    date date NOT NULL,
    user_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
) 

CREATE TABLE 'Projects'(
    id int AUTOINCREMENT PRIMARY KEY,
    title varchar(50) NOT NULL,
    description varchar(50) NOT NULL,
    date date NOT NULL,
    user_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)