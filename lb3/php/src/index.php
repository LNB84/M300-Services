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
echo "<h1>Datenbank LB3 Modul 300</h1>";
foreach ($users as $user) {
    echo "<br>";
    echo "<b>ID:</b> <a>$user->id</a>" . " " . "<b>Benutzername:</b> <a>$user->username</a>" . " " . "<b>Passwort:</b> <a>$user->password</a>";
    echo "<br>";
}
?>