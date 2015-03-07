drop table if exists Notes; 
drop table if exists User_Info;
create table User_Info(username char(20) PRIMARY KEY,email char(30), name char(20), password_hash char(128));
create table Notes(title char(25), author char(20), comments char(50), notes TEXT,last_mod char(40), meta_data char(50), PRIMARY KEY(title,author),FOREIGN KEY (author) REFERENCES User_Info(username));
