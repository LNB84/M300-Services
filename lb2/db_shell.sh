
sudo apt-get update
# mysql username: root
# mysql password: rootpass
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password rootpass'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password rootpass'

sudo apt-get install -y mysql-server

sudo sed -i -e"s/bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf

# Allow root access from any host
echo "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'rootpass' WITH GRANT OPTION; FLUSH PRIVILEGES;" | mysql -u root --password=rootpass

sudo service mysql restart

# Create database for form responses (WebExampleBox)
mysql -uroot -p'rootpass' -e "DROP DATABASE IF EXISTS formresponses; 
	CREATE DATABASE formresponses; 
	USE formresponses; 
	CREATE TABLE response (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
		firstname VARCHAR(20), lastname VARCHAR(20), 
		email VARCHAR(50), submitdate DATETIME);"
sudo service mysql restart