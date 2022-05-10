# M300 | Webserver mit Registrierung und MySQL

## Inhaltsverzeichnis

- [Projektbeschreibung](#projektbeschreibung)
    - [Voraussetzungen](#voraussetzungen)
- [Aufbau der Umgebung](#aufbau-der-umgebung)
	- [Identifikationen](#identifikationen)
- [Code](#code)
	- [Vagrantfile](#vagrantfile)
	- [web shell](#web-shell)
	- [db shell](#db-shell)
	- [HTML-File](#html-file)
	- [PHP Prozess](#php-prozess)
- [Vagrantumgebung Starten/Herunterfahren](#vagrantumgebung-starten-/-herunterfahren)
    - [Hochfahren](#hochfahren)
    - [Herunterfahren](#herunterfahren)
    -  [VMs löschen](#vms-löschen)
- [Via SSH auf die VMs zugreifen](#via-ssh-auf-die-vms-zugreifen)
- [Testing Website](#testing-website)
	- [User Registrieren](#user-registrieren) 
- [Testing Datenbank](#testing-datenbank)
    - [Passwort](#Passwort)
    - [1. Via SSH auf Datenbankserver verbinden](#1.-via-ssh-auf-datenbankservre-verbinden)
    - [2. In MySQL einloggen](#2.-in-mysql-einloggen)
    - [3. Datenbank verwenden und Tabelle anzeigen](#3.-datenbank-verwenden-und-tabelle-anzeigen)
    - [Verlassen der VM](#verlassen-der-vm)
- [Sicherheit](#sicherheit)
- [Quellen](#quellen)

---

## Projektbeschreibung
In der LB3 des Moduls 300 (Plattformübergreifende Dienste in ein Netzwerk integrieren) arbeiten wir mit Containern. Das Ziel ist anhand von Docker ein Dienst mit Containern automatisiert aufsetzen zu können. In userem Fall ist das einen Webserver mit Apache und einen Datenbankserver mit MySQL. Zu MySQL haben wir auch noch phpMyAdmin. Mit dem Befehl docker-compose werden Daten automatisiert in eine MySQL Datenbank geschrieben. Zu den Daten gehört der Username und das Passwort. Diese Einträge sind dann auf dem Webserver ersichtlich. Die Dokumentation der LB3 wird in Markdown geschrieben.

### Voraussetzungen
- Auf der VM muss Docker-Compose installiert sein
- Das Git Repository muss lokal auf der VM sein
- Vagrant muss installiert sein (Für die VM)

---

## Aufbau der Umgebung

Die Umgebung besteht aus drei Containern. Auf ersten ist Apache und PHP installiert, auf dem zweiten MySQL und auf dem letzten noch PhpMyAdmin

![M300-Banner](Umgebung_m300.png)

### Identifikationen
- **Webserver**
    - php-Apache
    - Name: lb3_php-apache
    - Apache2-Dienst
    - PHP
    - Port: 80
    - Portforwarding: 8080


- **Datenbankserver:**
    - MySQL
    - Name: lb3_mysql
    - MySQL-Dienst
    - Port: 3306
    - Portforwarding: 9906 


- **phpMyAdmin:**
    - phpMyAdmin
    - Name: lb3_mysql
    - Port: 80
    - Portforwarding: 8000 

---

## Code

### Docker-Compose
```
version: '2'
```
Als erstes definieren wir die Version von Docker-Compose.
```
networks:
    lb3_Network:
```
Als nächstes wir das Netzwerk für die Container definiert. In userem Fall lb3_Network.
```
services:
```
Ab hier werden die verschiedenen Containern erstellt.
```
php-apache-environment:
        container_name: lb3_php-apache
        build:
            context: ./php
            dockerfile: Dockerfile
        depends_on:
            - db
        volumes:
            - ./php/src:/var/www/html/
        ports:
            - "8080:80"
        networks:
            - lb3_Network
```
Nun erstellen wir den ersten Containern mit den folgenden Eigenschaften. Hier ist es der Webserver-Container.
```
db:
        container_name: lb3_db
        image: mysql
        restart: always
        environment:
            MYSQL_ROOT_PASSWORD: MYSQL_ROOT_PASSWORD
            MYSQL_DATABASE: MYSQL_DATABASE
            MYSQL_USER: MYSQL_USER
            MYSQL_PASSWORD: MYSQL_PASSWORD
        build:
            context: ./mysql
            dockerfile: Dockerfile
        volumes:
            - ./mysql/init.sql:/docker-entrypoint-initdb.d/init.sql
        ports:
            - "9906:3306"
        networks:
            - lb3_Network
```
Als nächstes die Datenbank.
```
phpmyadmin:
        image: phpmyadmin/phpmyadmin
        
        restart: always
        environment:
              PMA_HOST: db
        depends_on:
            - db
        ports:
            - "8000:80"
        networks:
            - lb3_Network
```
Und zuletzt noch phpMyAdmin.

### Dockerfile php
Dieser Code zeigt das Image basiert auf php.
```
FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
```
### php Index-File
Mit dem folgenden Code werden die Daten von der Datenbank auf den Webserver geschrieben.
```
<?php
// Der MySQL Servicename, welcher im docker-compose.yml definiert ist.
$host = 'db';

// Datenbank Username
$user = 'MYSQL_USER';

// Datenbank User Passwort
$pass = 'MYSQL_PASSWORD';

// Datenbankname
$mydatabase = 'MYSQL_DATABASE';

// Verbindung zur Datenbank herstellen
$conn = new mysqli($host, $user, $pass, $mydatabase);

// Anfrage
$sql = 'SELECT * FROM users';

if ($result = $conn->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

foreach ($users as $user) {
    echo "<br>";
    echo $user->username . " " . $user->password;
    echo "<br>";
}
?>
```

### Dockerfile für MySQL
Dieser Code verweist auf ein Datenbankscript, welches eine Tabelle erstellt und Daten einträgt.
```
FROM mysql:8.0

COPY ./mysql/init.sql /docker-entrypoint-init.d/init.sql
```
### SQL-Code
Folgender SQL-Code erstellt eine Tabelle und trägt Daten ein.
```
Use MYSQL_DATABASE;
drop table if exists `users`;
create table `users` (
    id int not null auto_increment,
    username text not null,
    password text not null,
    primary key (id)
);
insert into `users` (username, password) values
    ("Administrator","password"),
    ("Testuser","this is my password"),
    ("Job","12345678");>
```

---

## Vagrantumgebung Starten/Herunterfahren

### Hochfahren
Um die Umgebung zu starten öffnet man als erstes **im Ordner vom Vagrantfile** ein git Bash Terminal. In dieses kann man dann `vagrant up` schreiben. Danach werden die VMs aufgesetzt.

### Herunterfahren
Um die Umgebung herunterzufahren kann man ins gleiche Terminal `vagrant halt`  schreiben.

### VMs löschen
Um die VMs zu löschen kann man ins Terminal `vagrant destroy`" schreiben. Danach bestätigt man mit `y`, dass man die VMs löschen möchte.

>**NOTE:** Das Terminal muss immer **im Ordner vom Vagrantfile** geöffnet sein!
 
 ---
 
## Via SSH auf die VMs zugreifen

Um auf die einzelnen VMs zuzugreifen, muss man lediglich im Terminal im **gleichen Ordner wie das Vagrantfile** sein und den Befehl **vagrant ssh "Maschine"** eingeben.

|Welche Maschine  |Command (im Terminal)              |
|-----------------|-----------------------------------|
|Webserver    |`vagrant ssh web`       |
|Datenbankserver  |`vagrant ssh db`        |

---

## Testing Website
### User Registrieren
- Im Webbrowser die IP mit dem Port `192.168.0.20:80` eintragen
- Name nach Wahl eintragen

## Testing Datenbank
### Passwort

- Benutzername: root
- Passwort: rootpass

### 1. Via SSH auf Datenbankserver verbinden
- Terminal im Ordner vom Vagrantfile öffnen
- Ins Terminal `vagrant shh db` tippen

### 2. In MySQL einloggen
- Mit `mysql -uroot -p` in MySQL einloggen
- In die Passwortabfrage `rootpass` eintppen

### 3. Datenbank verwenden und Tabelle anzeigen
- Mit `use formresponses;` Datenbank verwenden
- Tabelle anzeigen mit `select*from response;`

### Verlassen der VM
- Um die VM zu verlassen und die SHH-Verbindung zu trennen, muss man den Befehl `exit` eintippen
---

## Sicherheit
- Der Datenbankserver bzw. MySQL ist mit einem Passwort geschützt
- Der ist mit dem ungeschützten Protokoll "HTTP" erreichbar

---
### Quellen
[MySQL Installation](https://linuxize.com/post/how-to-install-mysql-on-ubuntu-18-04/)

[Webserver mit MySQL](https://medium.com/analytics-vidhya/web-development-basics-how-to-connect-html-form-to-mysql-using-php-on-apache-web-server-part-1-7edce564169e)

[Website Formular](https://www.youtube.com/watch?v=gpM9hUKXLgk&ab_channel=ProgrammingKnowledge)

[PHP Syntax](https://www.w3schools.com/php/php_syntax.asp)
