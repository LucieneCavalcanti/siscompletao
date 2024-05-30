create database bdSisCompletao

use bdSisCompletao

create table tbStatus(
id int not null primary key auto_increment,
descricao varchar(50) not null
)

insert into tbstatus 
values(1,"Ativo"),
(2,"Suspenso"),
(3,"Aguardando ativação"),
(4,"Cancelado")



create table tbUsuarios(
id int not null primary key auto_increment,
nome varchar(200) not null,
email varchar(200) not null,
senha varchar(40) not null,
idStatus int references tbStatus(id)
)

insert into tbusuarios values 
(1, 'Ana', 'anuxa.caldas@gmail.com', '123', @idstatus),
(2, 'Lorenzo', 'lorenzo@mail.com', '1234', @idstatus),
(3, 'Thais', 'thais@mail.com', '1234', @idstatus),
(4, 'Natalia', 'nat@mail.com', '1234', @idstatus),
(5, 'Maria', 'mary@mail.com', '1234', @idstatus),
(6, 'Ricardo', 'ricardin@mail.com', '1234', @idstatus),
(7, 'Rebeca', 'rebeca@mail.com', '1234', @idstatus),
(8, 'Sabrina', 'sabrina@mail.com', '1234', @idstatus),
(9, 'Jenifer', 'jeny@mail.com', '1234', @idstatus),
(10, 'Sergio', 'serjao@mail.com', '1234', @idstatus)

 

create table tbModulos(
id int not null primary key auto_increment,
descricao varchar(100) not null,
link varchar(500) not null
)

insert into tbmodulos (descricao,link)
values 
('Home', 'home.php'),
('Perfil', 'perfil.php'),
('Usuários', 'cadastro.php'),
('Categorias', 'categorias.php'),
('Produtos', 'documentos.php'),
('Módulos', 'modulos.php'),
('Pemissões', 'permissao.php')


select * from tbmodulos t 

create table tbPermissoes(
id int not null primary key auto_increment,
idModulo int not null references tbmodulos(id),
idUsuario int not null references tbusuarios(id),
validade date null,
nivel varchar(30)
)

select * from tbpermissoes 

create table tbCategorias(
id int not null primary key auto_increment,
descricao varchar(100) not null
)
create table tbProdutos(
id int not null primary key auto_increment,
descricao varchar(200) not null,
quantidade int not null,
preco decimal(10,2) not null,
desconto decimal(10,2),
idCategoria int not null references tbCategorias(id),
idStatus int not null references tbStatus(id))


SELECT p.*, c.descricao as categoria, st.descricao as status FROM tbprodutos p
        JOIN tbcategorias c ON p.idCategoria = c.id 
        JOIN tbstatus st ON p.idStatus = st.id ORDER BY p.descricao

select * from tbprodutos p 

Select * from tbprodutos 
where quantidade>0 and 
idstatus =1 
order by rand() limit 2 

INSERT INTO bdsiscompletao.tbprodutos (descricao,quantidade,preco,desconto,idCategoria,idStatus) VALUES
	 ('Celular Samsung G3',100,1750.00,0.00,1,1),
	 ('Celular iPhone 12',250,4560.00,0.00,1,1),
	 ('Aprenda PHP',200,15.00,NULL,4,1),
	 ('Livro de Banco de Dados',0,25.00,0.00,4,1),
	 ('Vidas secas',10,9.90,NULL,4,2),
	 ('Quincas Borba',10,12.90,2.90,4,1);
INSERT INTO bdsiscompletao.tbprodutos (descricao,quantidade,preco,desconto,idCategoria,idStatus) VALUES
	 ('Tablet LENOVO',1007,1230.00,30,1,1),
	 ('Caixa de som JBL',10,850,0.00,1,1),
	 ('Java como programar',2000,150.00,NULL,4,1),
	 ('Aprenda Banco de Dados',10,25.00,5,4,1),
	 ('Violetas na Janela',100,9.90,NULL,4,2);

create table tbPedidos(
id int not null auto_increment primary key,
dataPedido datetime default now(),
idUsuario int not null references tbusuarios(id),
valorTotal decimal(10,2) not null,
totalDescontos decimal(10,2) not null,
valorAPagar decimal(10,2) not null,
cupomAplicado varchar(50) null,
tipoPagamento varchar(20) default "Dinheiro",
statusPedido int not null references tbstatus(id), 
dataEntrega date,
statusEntrega int references tbstatus(id)
)
create table tbitenspedido(
id int not null auto_increment primary key,
idpedido int not null references tbpedidos(id),
idproduto int not null references tbprodutos(id),
quantidade int not null,
valorProduto decimal(10,2) not null,
valorDesconto decimal(10,2) default 0,
valorAPagar decimal(10,2)
)
	