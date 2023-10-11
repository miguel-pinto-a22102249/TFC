# TFC DEISI277

## Dependências
Para correr a aplicação terá de instalar as seguintes dependências e programas:
- PHP: https://www.php.net/downloads.php
- XAMP: https://www.apachefriends.org/download.html
- MariaDB: https://mariadb.org/download/?t=mariadb&p=mariadb&r=11.1.0&os=windows&cpu=x86_64&-pkg=msi&m=ptisp

Ao instalar MariaDB terá que criar o utilizador "root" com a password "ola123" e a base de dados "tfc"

## Ferramenta de adminstração de base de dados

Deve-se instalar uma ferramenta de adminstração de base de dados para a correr script e criar a instância da base de dados que tem o nome de "tfc"
No meu caso utilizei o DBeaver: https://dbeaver.io/download/

O script da base de dados encontra-se no ficheiro sql_script_db
Os dados utilizados para testes locais encontram-se no ficheiro sql_script_dados

O servidor corre no seguinte link: http://localhost/frontend/src/index.php

## Docker
Não consegui por o docker a funcionar.
