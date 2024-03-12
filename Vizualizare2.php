<?php
session_start();
include("conectare.php");

// Luam evenimentele din baza de date
$sql = "SELECT id_eve, Denumire_Eveniment FROM evenimente";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Event List</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        body {
            background-color: #87b8ea;
            color: coral;
        }

        .navtop {
            background-color: black;
            color: #e0a328;
            font-size: 18px;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navtop .header-container h1 {
            color: coral;
            font-size: 24px;
            margin: 0;
        }

        .navtop a {
            color: coral;
            text-decoration: none;
            font-size: 16px;
            margin: 0 10px;
        }

        .navtop a:hover {
            color: #fff;
        }

        .content {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #d2d2d2;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #a3a3a3;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #7a7a7a;
            color: #fff;
        }

        td {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body class="loggedin">
<nav class="navtop">
    <div class="header-container">
        <h1>Master Events</h1>
    </div>
    <form action='home2.php' method='get'>
        <input type='submit' value='Înapoi la Pagina Principală'>
    </form><br>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
</nav>

<div class="content">
    <h2>Event List</h2>

	<?php
	if ($result->num_rows > 0) {
		echo "<table>";
		echo "<tr><th>Event Name</th><th>Agenda</th><th>Speakers</th><th>Contact</th><th>Sponsori</th><th>Bilete</th><th>Detalii</th></tr>";
// cream hyperlinkuri pentru paginile autogenerate care vor contine in link si ID-ul evenimentului selectat
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['Denumire_Eveniment'] . "</td>";
			echo "<td><a href='Agenda.php?event_id=" . $row['id_eve'] . "'>Agenda</a></td>";
			echo "<td><a href='Speakers.php?event_id=" . $row['id_eve'] . "'>Speakers</a></td>";
			echo "<td><a href='Contact.php?event_id=" . $row['id_eve'] . "'>Contact</a></td>";
			echo "<td><a href='Sponsori.php?event_id=" . $row['id_eve'] . "'>Sponsori</a></td>";
			echo "<td><a href='Bilete.php?event_id=" . $row['id_eve'] . "'>Bilete</a></td>";
			echo "<td><a href='EventDetails.php?event_id=" . $row['id_eve'] . "'>Detalii</a></td>";
			echo "</tr>";
		}

		echo "</table>";
	} else {
		echo "No events available.";
	}

	$result->free_result();
	?>
</div>
</body>

</html>
