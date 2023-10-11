
# grupo 1 - 1/2 elementos; grupo 2 - 3/4 elementos grupo 3 - 5 >

insert into 1agregado_familiar (niss, grupo) values (124, 2);
insert into 1agregado_familiar (niss, grupo) values (125, 2);
insert into 1agregado_familiar (niss, grupo) values (126, 1);
insert into 1agregado_familiar (niss, grupo) values (127, 1);
insert into 1agregado_familiar (niss, grupo) values (128, 3);
insert into 1agregado_familiar (niss, grupo) values (129, 3);

# escalao 1 - 0-2 anos ; 2 - 2-9 anos ; 3 - 9-14 anos; 4 - 14-40 anos ; 5 - 40-60 anos

insert into 2escalao (escalao_id, idade_inicial, idade_final) values (1, 0, 2);
insert into 2escalao (escalao_id, idade_inicial, idade_final) values (2, 2, 9);
insert into 2escalao (escalao_id, idade_inicial, idade_final) values (3, 9, 14);
insert into 2escalao (escalao_id, idade_inicial, idade_final) values (4, 14, 40);
insert into 2escalao (escalao_id, idade_inicial, idade_final) values (5, 40, 60);


insert into 3constituinte (niss,  agregado, escalao) values (124, 124, 5); 
insert into 3constituinte (niss,  agregado, escalao) values (1242, 124, 4); 
insert into 3constituinte (niss,  agregado, escalao) values (1243, 124, 2); 

insert into 3constituinte (niss,  agregado, escalao) values (125, 125, 4); 
insert into 3constituinte (niss,  agregado, escalao) values (1252, 125, 4); 
insert into 3constituinte (niss,  agregado, escalao) values (1253, 125, 1); 

insert into 3constituinte (niss,  agregado, escalao) values (126, 126, 3); 
insert into 3constituinte (niss,  agregado, escalao) values (1262, 126, 4); 

insert into 3constituinte (niss,  agregado, escalao) values (127, 127, 5); 

insert into 3constituinte (niss,  agregado, escalao) values (128, 128, 5); 
insert into 3constituinte (niss,  agregado, escalao) values (1281, 128, 4); 
insert into 3constituinte (niss,  agregado, escalao) values (1282, 128, 3); 
insert into 3constituinte (niss,  agregado, escalao) values (1283, 128, 3); 
insert into 3constituinte (niss,  agregado, escalao) values (1284, 128, 2); 

insert into 3constituinte (niss,  agregado, escalao) values (129, 129, 4); 
insert into 3constituinte (niss,  agregado, escalao) values (1291, 129, 4); 
insert into 3constituinte (niss,  agregado, escalao) values (1292, 129, 1); 
insert into 3constituinte (niss,  agregado, escalao) values (1293, 129, 2); 
insert into 3constituinte (niss,  agregado, escalao) values (1294, 129, 3); 
insert into 3constituinte (niss,  agregado, escalao) values (1295, 129, 4); 



insert into 4info_sensivel (niss, telefone, endereco, codigo_postal) values (124, "962", "Rua Teste1", "2123-321");
insert into 4info_sensivel (niss, telefone, endereco, codigo_postal) values (125, "963", "Rua Teste2", "2123-322");
insert into 4info_sensivel (niss, telefone, endereco, codigo_postal) values (126, "964", "Rua Teste3", "2123-323");
insert into 4info_sensivel (niss, telefone, endereco, codigo_postal) values (127, "965", "Rua Teste4", "2123-324");
insert into 4info_sensivel (niss, telefone, endereco, codigo_postal) values (128, "966", "Rua Teste5", "2123-325");
insert into 4info_sensivel (niss, telefone, endereco, codigo_postal) values (129, "967", "Rua Teste6", "2123-326");

insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Leite", 300, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Queijo", 200, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Arroz", 250, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Massa", 130, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Cereais", 140, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Grao", 360, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Feijao", 530, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Frango", 555, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "pescada", 421, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Sardinhas", 324, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Atum", 632, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Tomate", 342, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Vegetais", 433, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Brocolos", 121, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Espinafres", 620, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Azeite", 550, 300);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Creme", 390, 200);
insert into 5produto (produto_id, produto, quantidade_inicial, quantidade_disponivel) values (null, "Marmelada", 372, 300);


insert into 6referencia (produto_id, escalao, porcao) values (1, 1, 20);
insert into 6referencia (produto_id, escalao, porcao) values (1, 2, 21);
insert into 6referencia (produto_id, escalao, porcao) values (1, 3, 22);
insert into 6referencia (produto_id, escalao, porcao) values (1, 4, 23);
insert into 6referencia (produto_id, escalao, porcao) values (1, 5, 24);

insert into 6referencia (produto_id, escalao, porcao) values (2, 1, 11);
insert into 6referencia (produto_id, escalao, porcao) values (2, 2, 12);
insert into 6referencia (produto_id, escalao, porcao) values (2, 3, 13);
insert into 6referencia (produto_id, escalao, porcao) values (2, 4, 14);
insert into 6referencia (produto_id, escalao, porcao) values (2, 5, 15);

insert into 6referencia (produto_id, escalao, porcao) values (3, 1, 31);
insert into 6referencia (produto_id, escalao, porcao) values (3, 2, 32);
insert into 6referencia (produto_id, escalao, porcao) values (3, 3, 33);
insert into 6referencia (produto_id, escalao, porcao) values (3, 4, 34);
insert into 6referencia (produto_id, escalao, porcao) values (3, 5, 35);

insert into 6referencia (produto_id, escalao, porcao) values (4, 1, 41);
insert into 6referencia (produto_id, escalao, porcao) values (4, 2, 42);
insert into 6referencia (produto_id, escalao, porcao) values (4, 3, 43);
insert into 6referencia (produto_id, escalao, porcao) values (4, 4, 44);
insert into 6referencia (produto_id, escalao, porcao) values (4, 5, 45);

insert into 6referencia (produto_id, escalao, porcao) values (5, 1, 24);
insert into 6referencia (produto_id, escalao, porcao) values (5, 2, 25);
insert into 6referencia (produto_id, escalao, porcao) values (5, 3, 26);
insert into 6referencia (produto_id, escalao, porcao) values (5, 4, 27);
insert into 6referencia (produto_id, escalao, porcao) values (5, 5, 28);

insert into 6referencia (produto_id, escalao, porcao) values (6, 1, 9);
insert into 6referencia (produto_id, escalao, porcao) values (6, 2, 10);
insert into 6referencia (produto_id, escalao, porcao) values (6, 3, 8);
insert into 6referencia (produto_id, escalao, porcao) values (6, 4, 7);
insert into 6referencia (produto_id, escalao, porcao) values (6, 5, 11);

insert into 6referencia (produto_id, escalao, porcao) values (7, 1, 22);
insert into 6referencia (produto_id, escalao, porcao) values (7, 2, 23);
insert into 6referencia (produto_id, escalao, porcao) values (7, 3, 24);
insert into 6referencia (produto_id, escalao, porcao) values (7, 4, 25);
insert into 6referencia (produto_id, escalao, porcao) values (7, 5, 26);

insert into 6referencia (produto_id, escalao, porcao) values (8, 1, 27);
insert into 6referencia (produto_id, escalao, porcao) values (8, 2, 28);
insert into 6referencia (produto_id, escalao, porcao) values (8, 3, 29);
insert into 6referencia (produto_id, escalao, porcao) values (8, 4, 30);
insert into 6referencia (produto_id, escalao, porcao) values (8, 5, 31);

insert into 6referencia (produto_id, escalao, porcao) values (9, 1, 31);
insert into 6referencia (produto_id, escalao, porcao) values (9, 2, 32);
insert into 6referencia (produto_id, escalao, porcao) values (9, 3, 33);
insert into 6referencia (produto_id, escalao, porcao) values (9, 4, 34);
insert into 6referencia (produto_id, escalao, porcao) values (9, 5, 35);

insert into 6referencia (produto_id, escalao, porcao) values (10, 1, 11);
insert into 6referencia (produto_id, escalao, porcao) values (10, 2, 12);
insert into 6referencia (produto_id, escalao, porcao) values (10, 3, 13);
insert into 6referencia (produto_id, escalao, porcao) values (10, 4, 14);
insert into 6referencia (produto_id, escalao, porcao) values (10, 5, 15);

insert into 6referencia (produto_id, escalao, porcao) values (11, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (11, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (11, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (11, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (11, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (12, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (12, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (12, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (12, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (12, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (13, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (13, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (13, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (13, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (13, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (14, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (14, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (14, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (14, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (14, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (15, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (15, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (15, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (15, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (15, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (16, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (16, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (16, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (16, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (16, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (17, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (17, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (17, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (17, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (17, 5, 25);

insert into 6referencia (produto_id, escalao, porcao) values (18, 1, 21);
insert into 6referencia (produto_id, escalao, porcao) values (18, 2, 22);
insert into 6referencia (produto_id, escalao, porcao) values (18, 3, 23);
insert into 6referencia (produto_id, escalao, porcao) values (18, 4, 24);
insert into 6referencia (produto_id, escalao, porcao) values (18, 5, 25);


insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 1, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 1, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 1, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 1, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 1, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 2, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 2, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 2, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 2, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 2, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 3, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 3, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 3, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 3, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 3, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 4, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 4, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 4, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 4, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 4, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 5, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 5, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 5, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 5, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 5, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 6, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 6, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 6, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 6, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 6, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 7, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 7, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 7, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 7, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 7, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 8, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 8, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 8, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 8, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 8, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 9, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 9, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 9, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 9, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 9, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 10, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 10, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 10, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 10, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 10, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 11, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 11, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 11, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 11, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 11, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 12, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 12, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 12, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 12, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 12, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 13, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 13, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 13, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 13, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 13, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 14, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 14, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 14, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 14, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 14, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 15, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 15, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 15, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 15, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 15, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 16, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 16, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 16, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 16, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 16, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 17, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 17, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 17, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 17, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 17, 250, 0.98, "2023-04-08");

insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 124, 18, 250, 0.94, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 125, 18, 250, 0.92, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 126, 18, 250, 0.84, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 127, 18, 250, 0.91, "2023-04-08");
insert into 7distribuicao_individual (distribuicao_id, niss, produto_id, quantidade, index_1, data_1) values (null, 128, 18, 250, 0.98, "2023-04-08");


insert into 8entrega (entrega_id, niss, distribuicao_id, status, descricao, tipo_entrega, data_inicio, data_fim) values (null, 124, 1, 0, "N/A", 1, "2023-04-08", "2023-04-09");
insert into 8entrega (entrega_id, niss, distribuicao_id, status, descricao, tipo_entrega, data_inicio, data_fim) values (null, 125, 2, 1, "O filho assinou", 1, "2023-04-08", "2023-05-09");
insert into 8entrega (entrega_id, niss, distribuicao_id, status, descricao, tipo_entrega, data_inicio, data_fim) values (null, 126, 3, 0, "N/A", 1, "2023-04-08", "2023-06-09");
insert into 8entrega (entrega_id, niss, distribuicao_id, status, descricao, tipo_entrega, data_inicio, data_fim) values (null, 127, 4, 1, "Vem amanhã", 1, "2023-04-08", "2023-07-09");
insert into 8entrega (entrega_id, niss, distribuicao_id, status, descricao, tipo_entrega, data_inicio, data_fim) values (null, 128, 5, 0, "N/A", 1, "2023-04-08", "2023-08-09");






