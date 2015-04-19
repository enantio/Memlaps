DROP TABLE IF EXISTS Notes; 
DROP TABLE IF EXISTS Note_Share;
DROP TABLE IF EXISTS Friends;
DROP TABLE IF EXISTS User_Info;
CREATE TABLE User_Info(username CHAR(30) PRIMARY KEY,email CHAR(40), name CHAR(20), password_hash CHAR(128));
CREATE TABLE Notes(title CHAR(25), author CHAR(30), comments CHAR(50), notes TEXT,last_mod CHAR(40), meta_data CHAR(50), PRIMARY KEY(title,author),FOREIGN KEY (author) REFERENCES User_Info(username));
CREATE TABLE Note_Share(author CHAR(30),title CHAR(25),share_W_user CHAR(30), PRIMARY KEY(author,title),FOREIGN KEY (author) REFERENCES User_Info(username),FOREIGN KEY (share_W_user) REFERENCES User_Info(username));
CREATE TABLE Friends(username CHAR(30),friend CHAR(30),PRIMARY KEY (username,friend),FOREIGN KEY (username) REFERENCES User_Info(username),FOREIGN KEY (friend) REFERENCES User_Info(username));
