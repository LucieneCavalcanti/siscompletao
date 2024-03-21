create database bdSisCompletao

use bdSisCompletao

create table tbStatus(
id int not null primary key auto_increment,
descricao varchar(50) not null
)

create table tbUsuarios(
id int not null primary key auto_increment,
nome varchar(200) not null,
email varchar(200) not null,
senha varchar(40) not null,
idStatus int references tbStatus(id)
)

insert into tbstatus 
values(1,"Ativo"),
(2,"Suspenso"),
(3,"Aguardando ativação"),
(4,"Cancelado")

select * from tbstatus

create table tbModulos(
id int not null primary key auto_increment,
descricao varchar(100) not null,
link varchar(500) not null
)

create table tbPermissoes(
idModulo int not null references tbmodulos(id),
idUsuario int not null references tbusuarios(id),
validade date null,
nivel varchar(20)
)

create table tbpessoas(
id varchar(20) not null,
idUsuario int not null references tbusuarios(id),
cpf varchar(20) null,
rg varchar(20) null,
endereco varchar(500) not null,
cep varchar(9) not null,
sexo varchar(10) not null,
dataNascimento date not null

)

create table tbresponsaveis(
idUsuarioResponsavel int not null references tbusuarios(id),
idUsuarioMenor int not null references tbusuarios(id),
parentesco int not null,
assinacontrato boolean
)

create table tbdocumentos(
iddocumento int not null primary key auto_increment,
documento blob,
datadocumento date,
tipodocumento varchar(20)
idUsuario int not null references tbusuarios(id)
)