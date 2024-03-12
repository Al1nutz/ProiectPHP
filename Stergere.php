<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Your Page Title</title>
	<style>
        body {
            background-color: #87b8ea;
            margin: 0;
            padding: 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #2980b9;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #3498db;
        }

        a:hover {
            text-decoration: underline;
            color: #2980b9;
        }

        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            float: right;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
	</style>
</head>
<body>
<?php
class Database {
	private $hostname = 'localhost';
	private $username = 'root';
	private $password = '';
	private $db = 'proiect1';
	private $mysqli;

	public function __construct() {
		$this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->db);

		if ($this->mysqli->connect_error) {
			die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
		}
	}

	public function getConnection() {
		return $this->mysqli;
	}

	public function closeConnection() {
		$this->mysqli->close();
	}
// Functia fetchEvents afiseaza toate evenimentele care au fost inserate prin intermediul paginii Inserare.php
	public function fetchEvents() {
		$result = $this->mysqli->query("SELECT id_eve, Denumire_Eveniment FROM evenimente");
		$events = [];
		while ($row = $result->fetch_assoc()) {
			$events[$row['id_eve']] = $row['Denumire_Eveniment'];
		}
		return $events;
	}
// Aceasta functie foloseste la stergerea datelor din baza de date
	public function deleteEvent($idEveniment) {
		$stmt = $this->mysqli->prepare("DELETE FROM evenimente WHERE id_eve = ? LIMIT 1");
		$stmt->bind_param("i", $idEveniment);
		$stmt->execute();
		$stmt->close();
	}
}

// Initializare DB
$database = new Database();
$mysqli = $database->getConnection();

echo "<form action='home.php' method='get'>";
echo "<input type='submit' class='back-button' value='Înapoi la Pagina Principală'>";
echo "</form>";

$events = $database->fetchEvents();

if (isset($_GET['id_eve']) && is_numeric($_GET['id_eve'])) {
	$idEveniment = $_GET['id_eve'];
	$database->deleteEvent($idEveniment);
	echo "<div>Înregistrarea a fost ștearsă!</div>";
}

echo "<h2>Evenimente disponibile:</h2>";
echo "<table>";
echo "<tr><th>Eveniment</th><th>Acțiune</th></tr>";
foreach ($events as $eventID => $eventName) {
	echo "<tr><td>$eventName</td><td><a href='Stergere.php?id_eve=$eventID'>Șterge</a></td></tr>";
}
echo "</table>";

$database->closeConnection();
?>

</body>
</html>