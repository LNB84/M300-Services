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
            //Check if something is in the Database
            if(isset($_POST['submit']))
            {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];

                $con = mysqli_connect('192.168.0.30', 'root', 'rootpass','formresponses');
            // It checks if the connection is available to the Database
                if (!$con)
                {
                    die("Connection failed!" . mysqli_connect_error());
                }
            // Insert the Data to the Table contact
                $sql = "INSERT INTO response (firstname, lastname) VALUES ('$firstname', '$lastname')";


                $rs = mysqli_query($con, $sql);
            // It will give a output, if something is written in the Database                
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