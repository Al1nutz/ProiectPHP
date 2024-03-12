<?php
include("conectare.php");
$error = '';

if (isset($_POST['submit'])) {
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
		$error = 'ERROR: Campuri obligatorii goale!';
	} else {
		$stmt = $mysqli->prepare("INSERT INTO evenimente (Nume_Organizator, telefon_organizator, email_organizator, Denumire_Eveniment, Data_incepere, Data_sfarsit, Descriere, id_lci, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

		if ($stmt) {
			$stmt->bind_param("ssssssssi", $numeOrganizator, $telefonOrganizator, $emailOrganizator, $denumireEveniment, $dataIncepere, $dataSfarsit, $descriere, $idLocatie, $idUser);
			$stmt->execute();
			$eventID = $stmt->insert_id; // Luam ID-ul evenimentului inserat
			$stmt->close();

			// Inseram speakerii
			if (isset($_POST['speakers']) && is_array($_POST['speakers'])) {
				foreach ($_POST['speakers'] as $speaker) {
					$numeSpeaker = htmlentities($speaker['nume_speaker'], ENT_QUOTES);
					$prenumeSpeaker = htmlentities($speaker['prenume_speaker'], ENT_QUOTES);
					$emailSpeaker = htmlentities($speaker['email_speaker'], ENT_QUOTES);
					$nrTelefonSpeaker = htmlentities($speaker['nr_telefon_speaker'], ENT_QUOTES);

					// Inseram speakerii in baza de date
					$stmt = $mysqli->prepare("INSERT INTO speakeri (Nume_speaker, Prenume_speaker, Email_speaker, Nr_telefon_speaker, id_eve) VALUES (?, ?, ?, ?, ?)");
					if ($stmt) {
						$stmt->bind_param("ssssi", $numeSpeaker, $prenumeSpeaker, $emailSpeaker, $nrTelefonSpeaker, $eventID);
						$stmt->execute();
						$stmt->close();
					}
				}
			}

			// Inseram sponsorii/partenerii
			if (isset($_POST['colaboratori']) && is_array($_POST['colaboratori'])) {
				foreach ($_POST['colaboratori'] as $colaborator) {
					$numeColaborator = htmlentities($colaborator['nume_colaborator'], ENT_QUOTES);
					$contactColaborator = htmlentities($colaborator['contact_colaborator'], ENT_QUOTES);
					$adresaColaborator = htmlentities($colaborator['adresa_colaborator'], ENT_QUOTES);

					// Inseram sponsorii/partenerii in DB
					$stmt = $mysqli->prepare("INSERT INTO colaboratori (Nume_colaborator, Contact, Adresa, id_eve) VALUES (?, ?, ?, ?)");
					if ($stmt) {
						$stmt->bind_param("sssi", $numeColaborator, $contactColaborator, $adresaColaborator, $eventID);
						$stmt->execute();
						$stmt->close();
					}
				}
			}

		} else {
			echo "ERROR: Nu se poate executa insert.";
		}
	}
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Adauga Eveniment</title>
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
    </style></head>
<body>
<form action='home.php' method='get'>
    <input type='submit' value='Înapoi la Pagina Principală'>
</form>
<h2 text align="center">Adauga Eveniment</h2>
<?php echo $error; ?>
<form method="post" action="">
    <!-- Form fields for event -->
    <label>Nume Organizator:</label>
    <input type="text" name="Nume_Organizator" required><br>

    <label>Telefon Organizator:</label>
    <input type="text" name="telefon_organizator"><br>

    <label>Email Organizator:</label>
    <input type="text" name="email_organizator"><br>

    <label>Denumire Eveniment:</label>
    <input type="text" name="Denumire_Eveniment" required><br>

    <label>Data Incepere:</label>
    <input type="text" name="Data_incepere" placeholder="YYYY-MM-DD" required><br>

    <label>Data Sfarsit:</label>
    <input type="text" name="Data_sfarsit" placeholder="YYYY-MM-DD" required><br>

    <label>Descriere:</label>
    <textarea name="Descriere"></textarea><br>

    <label>ID Locatie:</label>
    <select name="id_lci" required>
        <option value="1">1 - Casa de Cultura a Studentilor</option>
        <option value="2">2 - Centrul Regional de Excelență pentru Industrii Creative</option>
        <option value="3">3 - Cinema Victoria</option>
    </select><br>

    <label>ID User:</label>
    <input type="text" name="id_user" required><br>

    <!-- Form fields for speakers -->
    <br><label>Speakers:</label>
    <div id="speakers-container">
        <div class="speaker">
            <label>Nume Speaker:</label>
            <input type="text" name="speakers[0][nume_speaker]" required><br>
            <label>Prenume Speaker:</label>
            <input type="text" name="speakers[0][prenume_speaker]" required><br>
            <label>Email Speaker:</label>
            <input type="text" name="speakers[0][email_speaker]" required><br>
            <label>Nr Telefon Speaker:</label>
            <input type="text" name="speakers[0][nr_telefon_speaker]">
            <button type="button" onclick="removeSpeaker(this.parentNode)">Remove Speaker</button><br>
        </div>
    </div>
    <button type="button" onclick="addSpeaker()">Adauga Speaker</button> <br>

    <br>
    <label>Colaboratori:</label>
    <div id="colaboratori-container">
        <div class="colaborator">
            <label>Nume Colaborator:</label>
            <input type="text" name="colaboratori[0][nume_colaborator]" required><br>
            <label>Contact Colaborator:</label>
            <input type="text" name="colaboratori[0][contact_colaborator]" required><br>
            <label>Adresa Colaborator:</label>
            <input type="text" name="colaboratori[0][adresa_colaborator]">
            <button type="button" onclick="removeColaborator(this.parentNode)">Remove Colaborator</button><br>
        </div>
    </div>

    <button type="button" onclick="addColaborator()">Adauga Colaborator</button><br>

   <br><input type="submit" name="submit" value="Adauga Eveniment">
</form>

<script>
    let speakerCount = 1;
    let colaboratorCount = 1;

    function addSpeaker() {
        const speakersContainer = document.getElementById('speakers-container');
        const newSpeaker = document.createElement('div');
        newSpeaker.className = 'speaker';
        newSpeaker.innerHTML = `
                <br><label>Nume Speaker:</label>
                <input type="text" name="speakers[${speakerCount}][nume_speaker]" required><br>
                <label>Prenume Speaker:</label>
                <input type="text" name="speakers[${speakerCount}][prenume_speaker]" required><br>
                <label>Email Speaker:</label>
                <input type="text" name="speakers[${speakerCount}][email_speaker]" required><br>
                <label>Nr Telefon Speaker:</label>
                <input type="text" name="speakers[${speakerCount}][nr_telefon_speaker]">
                <button type="button" onclick="removeSpeaker(this.parentNode)">Remove Speaker</button><br>
            `;
        speakerCount++;
        speakersContainer.appendChild(newSpeaker);
    }

    function addColaborator() {
        const colaboratoriContainer = document.getElementById('colaboratori-container');
        const newColaborator = document.createElement('div');
        newColaborator.className = 'colaborator';
        newColaborator.innerHTML = `
                <br><label>Nume Colaborator:</label>
                <input type="text" name="colaboratori[${colaboratorCount}][nume_colaborator]" required><br>
                <label>Contact Colaborator:</label>
                <input type="text" name="colaboratori[${colaboratorCount}][contact_colaborator]" required><br>
                <label>Adresa Colaborator:</label>
                <input type="text" name="colaboratori[${colaboratorCount}][adresa_colaborator]">
                <button type="button" onclick="removeColaborator(this.parentNode)">Remove Colaborator</button><br>
            `;
        colaboratorCount++;
        colaboratoriContainer.appendChild(newColaborator);
    }

    function removeSpeaker(element) {
        const speakersContainer = document.getElementById('speakers-container');
        speakersContainer.removeChild(element);
    }

    function removeColaborator(element) {
        const colaboratoriContainer = document.getElementById('colaboratori-container');
        colaboratoriContainer.removeChild(element);
    }
</script>

</body>
</html>
