# Usar a imagem oficial do PostgreSQL
FROM postgres:13

# Adicionar um script de inicialização para criar o banco de dados adicional
COPY /docker/postgresql/init.sql /docker-entrypoint-initdb.d/
