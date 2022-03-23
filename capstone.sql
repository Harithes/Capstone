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
    hashword varchar(225),
    classId int
);
drop table if exists admins;
create table admins(
adminLogin varchar(255)
);

drop table if exists modules;
create table modules(
modId int primary key auto_increment,
classId int,
modName varchar(30),
multipleChoice bit default 0,
mc1 varchar(40) default "",
mc2 varchar(40) default "",
mc3 varchar(40) default "",
mc4 varchar(40) default"",
written bit default 0,
writtenOptions varchar(255) default "");


insert into admins(adminLogin) values('$2y$10$Nfhs8ch4ewTI.YJL2WYEEuYAmpjAio4/3es83s4OBk3LRrrQOVq8S');
/*insert into profs(email, fName, lName, hashword, classId)
values ('benjamin.stearns@western.edu', 'ben', 'stearns', '0', 123);*/

insert into modules(classId, modName)
values(123, 'mod uno');

insert into modules(classId, modName)
values(123, 'mod dose');

select * from profs;
select * from modules;