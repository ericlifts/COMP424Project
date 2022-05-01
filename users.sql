-- TABLE FOR MYSQL 

CREATE TABLE users (
    username varchar(50) PRIMARY KEY not null,
    password LONGTEXT not null,
    firstName varchar(20) not null,
    lastName varchar(20) not null,
    birthday varchar(20) not null,
    email varchar(40) UNIQUE not null
);