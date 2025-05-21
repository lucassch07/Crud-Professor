create database professor;

use professor;

create table professor(
    id int auto_increment primary key,
    nome varchar(250),
    cpf varchar(250),
    rg varchar(250),
    idade int,
    formacao varchar(250),
    foto_identidade varchar(250),
    foto_sua varchar(250)
);

select * from professor;