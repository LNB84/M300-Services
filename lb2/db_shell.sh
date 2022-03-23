# Packete herunterladen
sudo apt-get update
# mysql Benutzername: root
# mysql Passwort: rootpass
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password rootpass'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password rootpass'

# mysql installieren
sudo apt-get install -y mysql-server

sudo sed -i -e"s/bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf

# Root-Zugriff von jedem Host
echo "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'rootpass' WITH GRANT OPTION; FLUSH PRIVILEGES;" | mysql -u root --password=rootpass

#Service neu starten
sudo service mysql restart

# Datenbank für die Registrieungen erstellen
mysql -uroot -prootpass -e "DROP DATABASE IF EXISTS formresponses; 
	CREATE DATABASE formresponses; 
	USE formresponses; 
	CREATE TABLE response (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
		firstname VARCHAR(20), lastname VARCHAR(20));"
sudo service mysql restart
