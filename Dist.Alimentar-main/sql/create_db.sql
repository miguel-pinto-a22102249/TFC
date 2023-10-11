use tfc;

drop table if exists 6referencia;
drop table if exists 8entrega;
drop table if exists 7distribuicao_individual;
drop table if exists 5produto;
drop table if exists 4info_sensivel;
drop table if exists 3constituinte;
drop table if exists 2escalao;
drop table if exists 1agregado_familiar;
DROP TABLE IF EXISTS 9access_log;
DROP TABLE IF EXISTS 9quantity_change_log;


create table 1agregado_familiar
(
	niss int primary key,
	grupo tinyint
);

create table 2escalao
(
	escalao_id int primary key,
	idade_inicial int,
	idade_final int
);

create table 3constituinte
(
	niss int primary key,
	agregado int,
	escalao int,
	foreign key(agregado) references 1agregado_Familiar(niss) ON DELETE cascade,
	foreign key(escalao) references 2escalao(escalao_id) on delete cascade
	
);

create table 4info_sensivel
(
	niss int,
	telefone varchar(20),
	endereco varchar(50),
	codigo_postal varchar(15),
	foreign key(niss) references 1agregado_Familiar(niss) ON DELETE CASCADE
);


create table 5produto
(
	produto_id int primary key AUTO_INCREMENT,
	produto varchar(50),
	quantidade_inicial int,
	quantidade_disponivel int
);

create table 6referencia
(
	produto_id int,
	escalao int,
	porcao int,
	foreign key(produto_id) references 5produto(produto_id) ON DELETE cascade,
	foreign key(escalao) references 2escalao(escalao_id) on delete cascade
);


create table 7distribuicao_individual
(
	distribuicao_id int primary key AUTO_INCREMENT,
	niss int,
	produto_id int,
	quantidade int,
	index_1 float,
	data_1 DATETIME,
	foreign key(niss) references 1agregado_Familiar(niss) ON DELETE CASCADE,
	foreign key(produto_id) references 5produto(produto_id) ON DELETE CASCADE
);

create table 8entrega
(
	entrega_id int primary key AUTO_INCREMENT,
	niss int,
	distribuicao_id int,
	status tinyint(5) default 0,
	descricao varchar(200),
	tipo_entrega tinyint(5),
	data_inicio DATETIME,
	data_fim DATETIME,
	foreign key(niss) references 1agregado_Familiar(niss) ON DELETE CASCADE,
	foreign key(distribuicao_id) references 7distribuicao_individual(distribuicao_id) ON DELETE CASCADE
);


CREATE TABLE 9access_log
(
	access_id int PRIMARY key AUTO_INCREMENT,
	data_1 DATETIME,
	id_accessed int
);

create table 9quantity_change_log
(
	change_id int PRIMARY key AUTO_INCREMENT,
	data_1 DATETIME,
	id_accessed int,
	quantidade_antes int,
	quantidade_depois int
);

