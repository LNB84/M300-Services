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