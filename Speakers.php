<?php
session_start();
include("conectare.php");

// Verifica daca event_id este dat in URL
if (!isset($_GET['event_id'])) {
	header('Location: Vizualizare.php');
	exit;
}

$event_id = $_GET['event_id'];

// Luam detaliile evenimentului din DB folosind $event_id
$sqlEvent = "SELECT Denumire_Eveniment FROM evenimente WHERE id_eve = ?";
$stmtEvent = $mysqli->prepare($sqlEvent);
$stmtEvent->bind_param("i", $event_id);
$stmtEvent->execute();
$resultEvent = $stmtEvent->get_result();
$eventDetails = $resultEvent->fetch_assoc();
$stmtEvent->close();

// Luam speakerii selectati pentru evenimentul nostru
$sqlSpeakers = "SELECT Nume_speaker, Prenume_speaker, Email_speaker, Nr_telefon_speaker
                FROM speakeri
                WHERE id_eve = ?";
$stmtSpeakers = $mysqli->prepare($sqlSpeakers);
$stmtSpeakers->bind_param("i", $event_id);
$stmtSpeakers->execute();
$resultSpeakers = $stmtSpeakers->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Speakers</title>
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

        .no-speakers {
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
    <h2>Speakeri evenimentului <?= $eventDetails['Denumire_Eveniment'] ?></h2>

	<?php if ($resultSpeakers->num_rows > 0) : ?>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
            </tr>

			<?php while ($row = $resultSpeakers->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['Nume_speaker'] ?></td>
                    <td><?= $row['Prenume_speaker'] ?></td>
                    <td><?= $row['Email_speaker'] ?></td>
                    <td><?= $row['Nr_telefon_speaker'] ?></td>
                </tr>
			<?php endwhile; ?>

        </table>
	<?php else : ?>
        <p class="no-speakers">No speakers found for the selected event.</p>
	<?php endif; ?>

</div>
</body>

</html>