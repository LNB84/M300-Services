# Pakete herunterlae^den
apt-get update

# Apache installieren
apt install -y apache2

# PHP installieren
sudo apt-get install -y php-fpm php-mysql
sudo apt-get install -y php libapache2-mod-php php-mysql

# Dienst neu Starten
sudo service apache2 restart
