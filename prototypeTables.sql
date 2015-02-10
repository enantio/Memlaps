drop table if exists User_Notes;
drop table if exists Notes; 
drop table if exists User_Info;
create table User_Info(username char(20) PRIMARY KEY,email char(30), name char(20), password_hash numeric(16,0),passwordSalt numeric(16,0));
create table Notes(title char(25), author char(20), comments char(50), notes TEXT, meta_data char(50), PRIMARY KEY(title,author),FOREIGN KEY (author) REFERENCES User_Info(username));
create table User_Notes(username char(20), title char(25), PRIMARY KEY(username,title), FOREIGN KEY(username) References User_Info(username), FOREIGN KEY(title) References Notes(title));
