-- TABLE FOR MYSQL 

CREATE TABLE users (
    username varchar(50) PRIMARY KEY not null,
    password LONGTEXT not null,
    firstName varchar(20) not null,
    lastName varchar(20) not null,
    birthday varchar(20) not null,
    question LONGTEXT not null,
    vkey LONGTEXT not null,
    verified tinyint(4) DEFAULT '0' not null,
    numLogins int,
    loginDate DATE,
    email varchar(40) UNIQUE not null
);


-- TABLE FOR RESET PASSWORD
CREATE TABLE pwdReset (
	pwdResetId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    pwdResetEmail TEXT NOT NULL,
    pwdResetSelector TEXT NOT NULL,
    pwdResetToken LONGTEXT NOT NULL,
    pwdResetExpires TEXT NOT NULL
);

-- TABLE FOR LOGGING LOGIN ATTEMPTS
CREATE TABLE loginAttempts (
	id int PRIMARY KEY AUTO_INCREMENT NOT NULL, 
    username varchar(50) NOT NULL,
    successful boolean default false,
    loginDate DATE NOT NULL
);