<?php
session_start();

class Database {
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $name = 'proiect1';
	private $conn;

	public function __construct() {
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

		if ($this->conn->connect_error) {
			exit('Esec conectare MySQL: ' . $this->conn->connect_error);
		}
	}

	public function closeConnection() {
		$this->conn->close();
	}

	public function getUserByUsername($username) {
		$stmt = $this->conn->prepare('SELECT ID_User, Password FROM useri WHERE Username = ?');
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		return $result->fetch_assoc();
	}
}

class HomePage {
	private $db;

	public function __construct() {
		$this->db = new Database();

		// Daca user-ul nu e logat, retrimitere la pagina de login.
		if (!isset($_SESSION['loggedin'])) {
			header('Location: index.php');
			exit;
		}
	}

	public function render() {
		include("conectare.php");
		?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <title>Home</title>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <style>
                body {
                    background-color: #87b8ea;
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                .navtop {
                    background-color: #333;
                    color: #fff;
                    text-align: center;
                    padding: 10px;
                }

                .header-container {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px;
                }

                .header-container h1 {
                    color: #e0a328;
                    font-size: 24px;
                    margin: 0;
                }

                .logout-link {
                    color: #e0a328;
                    font-size: 18px;
                    text-decoration: none;
                }

                .logout-link i {
                    margin-right: 5px;
                }

                .content {
                    padding: 20px;
                    text-align: center;
                }

                h1 {
                    color: #333;
                }

                ul {
                    list-style-type: none;
                    padding: 0;
                }

                h2 {
                    background-color: #e0a328;
                    color: #fff;
                    padding: 10px;
                    margin: 5px 0;
                }
            </style>
        </head>

        <body class="loggedin">
        <nav class="navtop">
            <div class="header-container">
                <h1>Master Events</h1>
                <a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>

        <div class="content">
            <h1>Bine ati revenit, <?= $_SESSION['name'] ?>!</h1>

            <!-- Link-uri/Formular pt. Control Panel -->
            <div>
                <h2>Control Panel</h2>
                <ul>
                    <h1><a href="Vizualizare.php">View Events</a></h1>
                    <h1><a href="Inserare.php">Insert Event</a></h1>
                    <h1><a href="Modificare.php">Modify Event</a></h1>
                    <h1><a href="Stergere.php">Delete Event</a></h1>
                </ul>
            </div>
        </div>
        </body>

        </html>
		<?php
	}
}

$homePage = new HomePage();
$homePage->render();
?>
