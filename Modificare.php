<?php
include("conectare.php");
$error = '';

// Initializarea variabilelor
$idEveniment = $numeOrganizator = $telefonOrganizator = $emailOrganizator = $denumireEveniment = $dataIncepere = $dataSfarsit = $descriere = $idLocatie = $idUser = '';

// Luam lista de evenimente
$result = $mysqli->query("SELECT id_eve, Denumire_Eveniment FROM evenimente");
$events = [];
while ($row = $result->fetch_assoc()) {
	$events[$row['id_eve']] = $row['Denumire_Eveniment'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!empty($_POST['id_eve'])) {
		if (is_numeric($_POST['id_eve'])) {
			$idEveniment = $_POST['id_eve'];
			$numeOrganizator = htmlentities($_POST['Nume_Organizator'], ENT_QUOTES);
			$telefonOrganizator = htmlentities($_POST['telefon_organizator'], ENT_QUOTES);
			$emailOrganizator = htmlentities($_POST['email_organizator'], ENT_QUOTES);
			$denumireEveniment = htmlentities($_POST['Denumire_Eveniment'], ENT_QUOTES);
			$dataIncepere = htmlentities($_POST['Data_incepere'], ENT_QUOTES);
			$dataSfarsit = htmlentities($_POST['Data_sfarsit'], ENT_QUOTES);
			$descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
			$idLocatie = (int)$_POST['id_lci'];
			$idUser = (int)$_POST['id_user'];

			if ($denumireEveniment == '' || $dataIncepere == '' || $dataSfarsit == '') {
				echo "<div> ERROR: Completati campurile obligatorii!</div>";
			} else {
				if ($stmt = $mysqli->prepare("UPDATE evenimente SET Nume_Organizator=?, telefon_organizator=?, email_organizator=?, Denumire_Eveniment=?, Data_incepere=?, Data_sfarsit=?, Descriere=?, id_lci=?, id_user=? WHERE id_eve=?")) {
					$stmt->bind_param("ssssssssii", $numeOrganizator, $telefonOrganizator, $emailOrganizator, $denumireEveniment, $dataIncepere, $dataSfarsit, $descriere, $idLocatie, $idUser, $idEveniment);
					$stmt->execute();
					$stmt->close();
					echo "<div>Eveniment modificat cu succes!</div>";
				} else {
					echo "ERROR: nu se poate executa update.";
				}
			}
		} else {
			echo "ID incorect!";
		}
	}
}

// Luam datele existente deja pt. eveniment
if (isset($_POST['id_eve']) && is_numeric($_POST['id_eve'])) {
	$idEveniment = $_POST['id_eve'];
// Aceast if cauta daca ID-ul este existent in baza de date
	if ($stmt = $mysqli->prepare("SELECT * FROM evenimente WHERE id_eve = ?")) {
		$stmt->bind_param("i", $idEveniment);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$numeOrganizator = $row['Nume_Organizator'];
			$telefonOrganizator = $row['telefon_organizator'];
			$emailOrganizator = $row['email_organizator'];
			$denumireEveniment = $row['Denumire_Eveniment'];
			$dataIncepere = $row['Data_incepere'];
			$dataSfarsit = $row['Data_sfarsit'];
			$descriere = $row['Descriere'];
			$idLocatie = $row['id_lci'];
			$idUser = $row['id_user'];
		} else {
			echo "ERROR: Evenimentul nu a fost gasit!";
		}

		$stmt->close();
	} else {
		echo "ERROR: Nu se poate executa interogarea.";
	}
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Modifica Eveniment</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #87b8ea;
            margin: 0;
            padding: 0;
        }

        form {
            width: 50%;
            margin: 50px auto;
            background-color: #006ab5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<form action='home.php' method='get'>
    <input type='submit' value='Înapoi la Pagina Principală'>
    </form>
<form action="" method="post">
    <label for="id_eve">Select Event:</label>
    <select name="id_eve" id="id_eve">
		<?php
		foreach ($events as $eventID => $eventName) {
			echo "<option value=\"$eventID\">$eventName</option>";
		}
		?>
    </select>
    <br /><br />
    Nume Organizator:
    <br />
    <input type="text" name="Nume_Organizator" value="<?= $numeOrganizator ?>" required>
    <br /><br />
    Telefon Organizator:
    <br />
    <input type="text" name="telefon_organizator" value="<?= $telefonOrganizator ?>" required>
    <br /><br />
    Email Organizator:
    <br />
    <input type="text" name="email_organizator" value="<?= $emailOrganizator ?>" required>
    <br /><br />
    Denumire Eveniment:
    <br />
    <input type="text" name="Denumire_Eveniment" value="<?= $denumireEveniment ?>" required>
    <br /><br />
    Data Incepere:
    <br />
    <input type="date" name="Data_incepere" value="<?= $dataIncepere ?>" placeholder="YYYY-MM-DD" required>
    <br /><br />
    Data Sfarsit:
    <br />
    <input type="date" name="Data_sfarsit" value="<?= $dataSfarsit ?>" placeholder="YYYY-MM-DD" required>
    <br /><br />
    Descriere:
    <br />
    <textarea name="Descriere"><?php $descriere ?></textarea>
    <br /><br />
    ID Locatie:
    <br />
    <input type="text" name="id_lci" value="<?= $idLocatie ?>" required>
    <br /><br />
    ID User:
    <br />
    <input type="text" name="id_user" value="<?php $idUser ?>" required>
    <br /><br />
    <input type="submit" name="submit" value="Modifica Eveniment">
</form>
</body>
</html>
