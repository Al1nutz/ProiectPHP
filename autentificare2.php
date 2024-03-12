<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'proiect1';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
	exit('Esec conectare MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {
	exit('Completati toate campurile!');
}

if ($stmt = $con->prepare('SELECT id_pti, password FROM participanti WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $hashedPassword);
		$stmt->fetch();

		// Verifica daca parola introdusa este la fel cu parola stocata in baza de date
		if (password_verify($_POST['password'], $hashedPassword)) {
			session_regenerate_id();
			$_SESSION['loggedin'] = true;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			echo 'Bine ati venit ' . $_SESSION['name'] . '!';
			header('Location: home2.php');
		} else {
			echo 'Incorrect username sau password!';
		}
	} else {
		echo 'Incorrect username sau password!';
	}

	$stmt->close();
}

$con->close();
?>
