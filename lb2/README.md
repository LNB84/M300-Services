# M300 | Webserver mit Registrierung und Mysql

## Inhaltsverzeichnis

- [Projektbeschreibung](#projektbeschreibung)
    - [Voraussetzungen](#voraussetzungen)
- [Aufbau der Umgebung](#aufbau-der-umgebung)
	- [Identifikationen](#identifikationen)
- [Vagrantumgebung Starten/Herunterfahren](#vagrantumgebung-starten-/-herunterfahren)
    - [Hochfahren](#hochfahren)
    - [Herunterfahren](#herunterfahren)
    -  [VMs löschen](#vms-löschen)
- [Via SSH auf die VMs zugreifen](#via-ssh-auf-die-vms-zugreifen)
- [Datenbank auf MySQL überprüfen](#datenbank-auf-mysql-überprüfen)
    - [Passwort](#Passwort)
    - [1. Via SSH auf Datenbankserver verbinden](#1.-via-ssh-auf-datenbankservre-verbinden)
    - [2. In MySQL einloggen](#2.-in-mysql-einloggen)
    - [3. Datenbank verwenden und Tabelle anzeigen](#3.-datenbank-verwenden-und-tabelle-anzeigen)
    - [Verlassen der VM](#verlassen-der-vm)
- [Sicherheit](#sicherheit)
- [Quellen](#quellen)

---

## Projektbeschreibung
In der LB2 des Moduls 300 (Plattformübergreifende Dienste in ein Netzwerk integrieren) arbeiten wir mit Vagrant. Das Ziel ist anhand von Vagrant ein Dienst mit VMs automatisiert aufsetzen zu können. In userem Fall ist das einen Webserver mit Apache und einen Datenbankserver mit Mysql. Der User füllt auf unserer Website ein Formular mit Vorname und Nachname aus. Diese Informationen werden dann in der MySQL-Datenbank gespeichert. Die Dokumentation der LB2 wird in Markdown geschrieben.

### Voraussetzungen
- Die neuste Version von Virtualbox muss installiert sein
- Auf Virtualbox dürfen keine VMs vorhanden sein, die "m300_webserver" oder "m300_database" heissen
- Vagrant muss installiert sein

---

## Aufbau der Umgebung

Die Umgebung besteht aus einem Webserver und einem Datenbankserver. Auf dem Webserver ist Apache und PHP installiert und auf der Datenbank MySQL.

![M300-Banner](Umgebung_m300.png)

### Identifikationen
- **Webserver**
    - Ubuntu/bionic64
    - 1024 MB RAM
    - Name: m300_webserver
    - Apache2-Dienst
    - PHP
    - IP-Adresse: 192.168.0.20
    - Port: 80
    - Portforwarding: 8080


- **Datenbankserver:**
    - Ubuntu/bionic64
    - 2048 RAM
    - Name: database
    - MySQL-Dienst
    - IP-Adresse: 192.168.0.20
    - Port: 80
    - Portforwarding: 3306


---

## Code

### Vagrantfile
```javascript
var s = "JavaScript syntax highlighting";
alert(s);
```
 
```python
s = "Python syntax highlighting"
print s
```
 
```
No language indicated, so no syntax highlighting. 
But let's throw in a <b>tag</b>.
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

## Datenbank auf MySQL überprüfen

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
- Um die VM zu verlassen und die SHH-Verbindung zu trennen, muss man den Befehl `exit` eintippen.
---

## Sicherheit
- Der Datenbankserver bzw. MySQL ist mit einem Passwort geschützt
- Der ist mit dem ungeschützten Protokoll "HTTP" erreichbar.

---
### Quellen
[MySQL Installation](https://linuxize.com/post/how-to-install-mysql-on-ubuntu-18-04/)

[Webserver mit MySQL](https://medium.com/analytics-vidhya/web-development-basics-how-to-connect-html-form-to-mysql-using-php-on-apache-web-server-part-1-7edce564169e)
