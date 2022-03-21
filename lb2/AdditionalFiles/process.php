<?php

$username = 'root';
$password = 'rootpass';
$dsn = 'mysql:host=192.168.0.30;dbname=formresponses';

try{
	$db = new PDO($dsn, $username, $password);
	$result=FALSE;

	if($_POST['first']!=null && $_POST['last']!=null
	{
		$first=filter_var(trim($_POST['first']),FILTER_SANITIZE_SPECIAL_CHARS);
		$last=filter_var(trim($_POST['last']),FILTER_SANITIZE_SPECIAL_CHARS);
		if(validSubmission($first,$last))
			$result=insertInfo($db,$first,$last);
	}

} catch(PDOException $ex) {
	echo $ex->getMessage();
}

header('Location: index.php?success='.$result);



//Return true if user info is valid (not empty, email syntax okay)
function validSubmission($first,$last)
{
	$result=FALSE;
	if(nonempty($first) && nonempty($last))
		$result=TRUE;
	return $result;
}

//Return true if input is not null and not an empty string
function nonempty($input)
{
	$nonempty=FALSE;
	if($input!=null && $input!='')
		$nonempty=TRUE;
	return $nonempty;
}

//Insert entered form info into the database
function insertInfo($db,$first,$last,$email)
{
	$stmt = $db->prepare("INSERT INTO response(firstname, lastname, email, submitdate) VALUES (:first, :last)");
	$stmt->bindParam(':first', $first);
	$stmt->bindParam(':last', $last);
	
	return $stmt->execute();
}

?>