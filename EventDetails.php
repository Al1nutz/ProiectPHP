<?php
session_start();
include("conectare.php");

// Verificam daca event_id este dat in URL
if (!isset($_GET['event_id'])) {
	header('Location: Vizualizare.php');
	exit;
}

$event_id = $_GET['event_id'];

// Luam detaliile evenimentului din DB folosind $event_id
$sql = "SELECT Denumire_Eveniment, Descriere, Data_incepere, Data_sfarsit
        FROM evenimente
        WHERE id_eve = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$eventDetails = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Detalii</title>
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

        .no-details {
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
    <h2>Detalii Eveniment</h2>

	<?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Denumire Eveniment</th>
                <th>Descriere</th>
                <th>Data Incepere</th>
                <th>Data Sfarsit</th>
            </tr>

            <tr>
                <td><?= $eventDetails['Denumire_Eveniment'] ?></td>
                <td><?= $eventDetails['Descriere'] ?></td>
                <td><?= $eventDetails['Data_incepere'] ?></td>
                <td><?= $eventDetails['Data_sfarsit'] ?></td>
            </tr>

        </table>
	<?php else : ?>
        <p class="no-details">No event details found for the selected event.</p>
	<?php endif; ?>
</div>
</body>

</html>