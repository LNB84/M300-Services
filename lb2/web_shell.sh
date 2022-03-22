apt-get update

apt install -y apache2
sudo apt-get install -y php-fpm php-mysql
sudo apt-get install -y php libapache2-mod-php php-mysql
sudo rm -rf "/var/www/html/index.html"
sudo cp "/AdditionalFiles/html/index.html" "/var/www/html"
sudo cp "/AdditionalFiles/html/process.php" "/var/www/html"

sudo service apache2 restart