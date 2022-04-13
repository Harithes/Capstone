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
    classId int,
    expDate varchar(50),
	verifyToken varchar(100),
	verifyBit bit default 0,
	resetToken varchar(100)
);

drop table if exists profs;
create table profs(
	profId int primary key auto_increment,
	email varchar(30),
    fName varchar(20),
    lName varchar(20),
    hashword varchar(225),
    classId int,
    expDate INT default null,
    resetToken INT default null
);

drop table if exists classes;
create table classes(
	primId int primary key auto_increment,
    profId int,
    classId int,
    className varchar(50)
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
modInfo mediumtext,
modQuestion varchar(100),
multipleChoice bit,
mc1 varchar(40),
mc2 varchar(40),
mc3 varchar(40),
mc4 varchar(40),
written bit);

drop table if exists modSubs;
create table modSubs(
submissionId int primary key auto_increment,
modId int,
modName varchar(30),
classId int,
subInfo mediumtext,
fName varchar(20),
lName varchar(20),
grade int,
gradeComment mediumtext,
profChanged bit);


insert into admins(adminLogin) values('$2y$10$Nfhs8ch4ewTI.YJL2WYEEuYAmpjAio4/3es83s4OBk3LRrrQOVq8S');
/*insert into profs(email, fName, lName, hashword, classId)
values ('benjamin.stearns@western.edu', 'ben', 'stearns', '0', 123);*/

