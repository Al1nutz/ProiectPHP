<?php
class Database {
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $name = 'proiect1';
	private $conn;

	public function __construct() {
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

		if ($this->conn->connect_error) {
			exit('Nu se poate conecta la MySQL: ' . $this->conn->connect_error);
		}
	}

	public function closeConnection() {
		$this->conn->close();
	}
// Functia de mai jos o vom folosi pentru a verifica daca exista vreun user cu acelasi Username pentru a evita creearea de mai multe conturi cu acelasi username
	public function checkExistingUsername($username) {
		$stmt = $this->conn->prepare('SELECT ID_User, Password FROM useri WHERE Username = ?');
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		$result = $stmt->num_rows > 0;
		$stmt->close();

		return $result;
	}
// Functia de mai jos foloseste la preluarea datelor din formular si transmiterea acestora la baza de date
	public function registerUser($username, $hashedPassword, $email, $nume, $prenume, $telefon) {
		$stmtParticipanti = $this->conn->prepare('INSERT INTO participanti (username, password, nume, prenume, email, telefon) VALUES (?, ?, ?, ?, ?, ?)');
		$stmtParticipanti->bind_param('ssssss', $username, $hashedPassword, $nume, $prenume, $email, $telefon);
		$stmtParticipanti->execute();
		$stmtParticipanti->close();
	}
}

$database = new Database();

if (!isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['nume'], $_POST['prenume'], $_POST['telefon'])) {
	exit('Completati formularul de inregistrare!');
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['nume']) || empty($_POST['prenume']) || empty($_POST['telefon'])) {
	exit('Completati formularul de inregistrare!');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email nu este valid!');
}

if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
	exit('Username nu este valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Password trebuie sa fie intre 5 si 20 de caractere!');
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

if ($database->checkExistingUsername($_POST['username'])) {
	echo 'Username exista, alegeti altul!';
} else {
	$database->registerUser(
		$_POST['username'],
		$hashedPassword,
		$_POST['email'],
		$_POST['nume'],
		$_POST['prenume'],
		$_POST['telefon']
	);
	echo 'Succes inregistrat!';
	header('Location: index.html');
}

$database->closeConnection();
?>
