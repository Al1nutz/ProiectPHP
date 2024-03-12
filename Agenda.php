<?php
session_start();
include("conectare.php");

// Verificam daca event_id este dat in URL
if (!isset($_GET['event_id'])) {
	header('Location: Vizualizare.php');
	exit;
}

$event_id = $_GET['event_id'];

// Preluam detaliile evenimentului din baza de date folosind $event_id
$sqlEvent = "SELECT Denumire_Eveniment FROM evenimente WHERE id_eve = ?";
$stmtEvent = $mysqli->prepare($sqlEvent);
$stmtEvent->bind_param("i", $event_id);
$stmtEvent->execute();
$resultEvent = $stmtEvent->get_result();
$eventDetails = $resultEvent->fetch_assoc();
$stmtEvent->close();

// Luam Data_incepere si Data_sfarsit pentru evenimentul specific
$sqlDates = "SELECT Data_incepere, Data_sfarsit FROM evenimente WHERE id_eve = ?";
$stmtDates = $mysqli->prepare($sqlDates);
$stmtDates->bind_param("i", $event_id);
$stmtDates->execute();
$resultDates = $stmtDates->get_result();
$dates = $resultDates->fetch_assoc();
$stmtDates->close();

// Generam o matrice cu date între: Data_incepere si Data_sfarsit
$startDate = new DateTime($dates['Data_incepere']);
$endDate = new DateTime($dates['Data_sfarsit']);
$dateRange = array();

while ($startDate <= $endDate) {
	$dateRange[] = $startDate->format('Y-m-d');
	$startDate->modify('+1 day');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Agenda</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #87b8ea;
            margin: 0;
            padding: 0;
        }

        .navtop {
            background-color: #333;
            height: 60px;
            width: 100%;
            border: 0;
            display: flex;
            justify-content: space-between;
        }

        .navtop h1 {
            padding: 15px 20px;
            color: white;
            font-size: 24px;
        }

        .navtop a {
            text-decoration: none;
            color: white;
            font-size: 14px;
            padding: 15px 20px;
            display: inline-block;
        }

        .navtop a i {
            padding-right: 10px;
        }

        .content {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body class="loggedin">
<nav class="navtop">
    <h1>Master Events</h1>
    <div>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>

<div class="content">
    <h2>Agenda evenimentului: <?= $eventDetails['Denumire_Eveniment'] ?></h2>

    <table>
        <tr>
            <th>Date</th>
            <th>Activitati</th>
        </tr>

		<?php
		// Afiseaza randuri pentru fiecare data
		foreach ($dateRange as $date) {
			echo "<tr>";
			echo "<td>{$date}</td>";
			echo "<td></td>"; // Tine locul temporar pentru Activitati
			echo "</tr>";
		}
		?>
    </table>
</div>
</body>

</html>
