<?php
session_start();
include("conectare.php");

// Verificam daca event_id este dat in URL
if (!isset($_GET['event_id'])) {
	header('Location: Vizualizare.php');
	exit;
}

$event_id = $_GET['event_id'];
//Folosim acest query pentru creearea pagini generate automat
$sqlEvent = "SELECT Denumire_Eveniment FROM evenimente WHERE id_eve = ?";
$stmtEvent = $mysqli->prepare($sqlEvent);
$stmtEvent->bind_param("i", $event_id);
$stmtEvent->execute();
$resultEvent = $stmtEvent->get_result();
$eventDetails = $resultEvent->fetch_assoc();
$stmtEvent->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bilete</title>
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
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
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
    <h2>Bilete pentru evenimentul: <?= $eventDetails['Denumire_Eveniment'] ?></h2>
    <br>
    <br>
    <h3>Bilete Standard</h3>
    <button onclick="window.location.href='ConfirmareBiletStandard.html'">Achizitioneaza Bilet</button>
    <br>
    <br>
    <h3>Bilete Premium</h3>
    <button onclick="window.location.href='ConfirmareBiletPremium.html'">Achizitioneaza Bilet</button>
</div>
</body>
</html>