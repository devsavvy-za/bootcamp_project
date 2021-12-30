FROM mariadb:10.6

COPY ./mysql/00-init.sql /docker-entrypoint-initdb.d
