# opencart_vasia

## db backup
`docker exec -it db /bin/bash`
`mysqldump -u root --password=MYSQL_ROOT_PASSWORD MY_DATABASE > /db-entrypoint/backup.sql`

## installation troubleshoot
install mysqli and pdo in the php.ini file, set 'db'(docker container name) as host, set correct directories in config.php files(admin, root store folders)
