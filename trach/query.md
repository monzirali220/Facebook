# CREATE `USERS` TABLE 

1. CREATE TABLE Users(
Id INT NOT NULL AUTO_INCREMENT
,firstName CHAR(50) NOT NULL
,lastName CHAR(50) NOT NULL
,gender CHAR(30) 
,email CHAR(255) NOT NULL
,password CHAR(255) NOT NULL
,dateOfBarth CHAR(50)
,profileImage LONGBLOB
,profileBigImage LONGBLOB
,level INT(100) DEFAULT(1)
,lastLogin CHAR(20)
,PRIMARY KEY (Id)
);

# CREATE `POSTER` TABLE

2. CREATE TABLE Posts (
poster_id INT AUTO_INCREMENT,
author_id INT ,
content VARCHAR (500),
image LONGBLOB,
likes INT,
publish_date DATETIME,
PRIMARY KEY(poster_id)
);

# CREATE `COMMENTS` TABLE 

3. CREATE TABLE Comments(
id INT AUTO_INCREMENT,
poster_id INT,
author_id INT,
comment VARCHAR(500),
PRIMARY KEY(id)
);

# CREATE FRIANDSHIPE 
4. CREATE TABLE Friendship(
friendship_id INT AUTO_INCREMENT,
sender_id INT,
receiver_id INT,
is_friend INT DEFAULT(0),
date DATE,
PRIMARY KEY (friendship_id)
);

# MESSAGES TABLE
5. CREATE TABLE Messages(
sender_id INT,
receiver_id INT,
message CHAR(255),
date DATE
);


# CHECK IF USER IS EXEST
4. SELECT Id FROM Users WHERE email='email' 
, password='password'
# CREATE USER IN NARIADB

CREATE USER 'monzir'@localhost IDENTIFIED BY '0994284765';

ALTER USER 'userName'@'localhost' IDENTIFIED BY 'New-Password-Here';
