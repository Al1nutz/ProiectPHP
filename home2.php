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
		$stmt = $this->conn->prepare('SELECT id_pti, password FROM participanti WHERE username = ?');
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		return $result->fetch_assoc();
	}

	public function getLatestEventTimestamp() {
		$result = $this->conn->query('SELECT MAX(DataAdaugare) as latest_timestamp FROM evenimente');
		return $result->fetch_assoc()['latest_timestamp'];
	}
}

class HomePage {
	private $db;

	public function __construct() {
		$this->db = new Database();

		// Verifica daca user-ul e logat
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

                .notification {
                    background-color: #4CAF50;
                    color: white;
                    text-align: center;
                    padding: 15px;
                    font-size: 18px;
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
			<?php $this->checkAndDisplayNotifications(); ?>

            <h1>Bine ati revenit, <?= $_SESSION['name'] ?>!</h1>

            <div>
                <h2>Control Panel</h2>
                <ul>
                    <h1><a href="Vizualizare2.php">View Events</a></h1>
                </ul>
            </div>
        </div>
        </body>

        </html>
		<?php
	}

	public function checkAndDisplayNotifications() {
		$latestEventTimestamp = $this->db->getLatestEventTimestamp();

		// Daca clientul nu a vazut evenimentele, atunci apare:
		if (!isset($_SESSION['last_event_check']) || $_SESSION['last_event_check'] < $latestEventTimestamp) {
			// Display a notification
			echo '<div class="notification">New events are available. Check them out!</div>';

			// Actualizam ultimul timestamp verificat din sesiune
			$_SESSION['last_event_check'] = $latestEventTimestamp;
		}
	}
}

$homePage = new HomePage();
$homePage->render();
?>
