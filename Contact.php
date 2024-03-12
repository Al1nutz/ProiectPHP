<?php
session_start();
include("conectare.php");

// Verifica daca event_id este dat in URL
if (!isset($_GET['event_id'])) {
	header('Location: Vizualizare.php');
	exit;
}

$event_id = $_GET['event_id'];

// Luam detaliile evenimentului din baza de date folosind $event_id
$sqlEvent = "SELECT Denumire_Eveniment, id_lci, Nume_Organizator, Telefon_Organizator, Email_Organizator
             FROM evenimente
             WHERE id_eve = ?";
$stmtEvent = $mysqli->prepare($sqlEvent);
$stmtEvent->bind_param("i", $event_id);
$stmtEvent->execute();
$resultEvent = $stmtEvent->get_result();
$eventDetails = $resultEvent->fetch_assoc();
$stmtEvent->close();

// Luam detaliile locatiilor folosind id_lci
$sqlLocation = "SELECT strada, numar, oras, judet, denumire
                FROM locatii
                WHERE id_lci = ?";
$stmtLocation = $mysqli->prepare($sqlLocation);
$stmtLocation->bind_param("i", $eventDetails['id_lci']);
$stmtLocation->execute();
$resultLocation = $stmtLocation->get_result();
$locationDetails = $resultLocation->fetch_assoc();
$stmtLocation->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Contact</title>
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
            width: 97.9%;
            border: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .navtop div h1 {
            color: white;
            font-size: 24px;
        }

        .navtop a {
            text-decoration: none;
            color: white;
            font-size: 14px;
            padding: 15px 0;
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

        .no-contact {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
            border-radius: 4px;
        }
    </style>
</head>

<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Master Events</h1>
    </div>
    <div>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>

<div class="content">
    <h2>Informatii de contact <?= $eventDetails['Denumire_Eveniment'] ?></h2>

	<?php if ($resultEvent->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Nume organizator</th>
                <th>Numar telefon organizator</th>
                <th>Email organizator</th>
                <th>Locatie</th>
            </tr>

            <tr>
                <td><?= $eventDetails['Nume_Organizator'] ?></td>
                <td><?= $eventDetails['Telefon_Organizator'] ?></td>
                <td><?= $eventDetails['Email_Organizator'] ?></td>
                <td><?= $locationDetails['strada'] ?>, <?= $locationDetails['numar'] ?>, <?= $locationDetails['oras'] ?>, <?= $locationDetails['judet'] ?>, <?= $locationDetails['denumire'] ?></td>
            </tr>

        </table>
	<?php else : ?>
        <p class="no-contact">No contact information found for the selected event.</p>
	<?php endif; ?>
</div>
</body>

</html>