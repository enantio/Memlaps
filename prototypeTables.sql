drop table if exists Notes; 
drop table if exists User_Info;
create table User_Info(username char(20) PRIMARY KEY,email char(30), name char(20), password_hash numeric(16,0),passwordSalt numeric(16,0));
create table Notes(title char(25), author char(20), comments char(50), notes TEXT,last_mod char(40), meta_data char(50), PRIMARY KEY(title,author),FOREIGN KEY (author) REFERENCES User_Info(username));

INSERT INTO User_Info VALUES('ADMIN','I can not remember','memlaps team',0,0);
INSERT INTO Notes VALUES('testTitle','ADMIN','none','blah','some time','meta stuff');
