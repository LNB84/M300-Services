<!doctype html>
<html>
<head>
<title>Database output</title>
</head>
<body>
    <table>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
		</tr>
            <?php
            // Schauen, ob etwas in der Datenbank ist
            if(isset($_POST['submit']))
            {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
		
                $con = mysqli_connect('192.168.0.30', 'root', 'rootpass','formresponses');
            // Verindung zur Datenbank überprüfen
                if (!$con)
                {
                    die("Connection failed!" . mysqli_connect_error());
                }
            // Daten in die Tabelle legen
                $sql = "INSERT INTO response (firstname, lastname) VALUES ('$firstname', '$lastname')";


                $rs = mysqli_query($con, $sql);
            // Gibt einen Output, wenn etwas in der Datenbank ist          
                if($rs)
                {
			$selectsql = "SELECT firstname, lastname from response";
			$resultat = $con-> query($selectsql);

			if ($resultat-> num_rows > 0) {
				while ($row = $resultat-> fetch_assoc()) {
					echo "</td><td>". $row["firstname"] ."</td><td>". $row["lastname"] ."</td><td>";
			}
				echo "</table>";
			}
                }
                else
                {
                    echo "The Data couldn't be loaded in the database.";
                }
            }
        ?>
    </table>
</body>
</html>
