#drop database if exists capStoneStudents;
#create database capStoneStudents;
use capstoneStudents;
drop table if exists students;
create table students(
	userId int primary key auto_increment,
	email varchar(30),
    fName varchar(20),
    lName varchar(20),
    hashWord varchar(255),
    mod1Sub bit default 0,
    mod1Response varchar(500) default "",
    mod2Sub bit default 0,
    classId int
);

drop table if exists profs;
create table profs(
	email varchar(30),
    fName varchar(20),
    lName varchar(20),
    classId int
);
drop table if exists admins;
create table admins(
adminLogin varchar(255)
);

insert into admins(adminLogin) values('$2y$10$Nfhs8ch4ewTI.YJL2WYEEuYAmpjAio4/3es83s4OBk3LRrrQOVq8S');
insert into profs(email, fName, lName, classId)
values ('benjamin.stearns@western.edu', 'ben', 'stearns', 123);
insert into profs(email, fName, lName, classId)
values ('kiowa.horendeck@western.edu', 'kiowa', 'horendeck', 456);

select * from profs;