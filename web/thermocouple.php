<?php
include 'connexion.php';
$date = date('Y-m-d');

// Requêtes SQL pour récupérer les données
$sql_tableau = "SELECT * FROM `thermocouple` ORDER BY `thermocouple`.`TIME` DESC LIMIT 100";
$sql_time = "SELECT TIME FROM `thermocouple` ORDER BY `thermocouple`.`TIME` DESC LIMIT 100";
$sql_temp = "SELECT temp FROM `thermocouple` ORDER BY `thermocouple`.`TIME` DESC LIMIT 100";

// Variables contenant les données récupéré a partir des requêtes 
$result_time = mysqli_query($conn, $sql_time);
$result_temp = mysqli_query($conn, $sql_temp);
$result_hum = mysqli_query($conn, $sql_hum);
$result_tableau = mysqli_query($conn, $sql_tableau);

// Données de temps pour le tableau
while($row_time = mysqli_fetch_array($result_time)) {
    $timeArray[] = $row_time['TIME'];
}

// Données pour le graphique de Temperature
while($row_temp = mysqli_fetch_array($result_temp)) {
    $tempArray[] = $row_temp['temp'];
}

// Données pour le graphique de l'Humidité
while($row_hum = mysqli_fetch_array($result_hum)) {
    $humArray[] = $row_hum['hum'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>MultiSense - Capteur 2</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/main2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<header class="header" align='center'>
      	<ul class="main-nav">
			<li><a href="index.html">Home</a></li>
        	<li><a href="sht0.php">SHT1</a></li>
        	<li><a href="sht1.php">SHT2</a></li>
			<li><a href="sht2.php">SHT3</a></li>
			<li><a href="sht3.php">SHT4</a></li>
			<li><a href="thermocouple.php">thermocouple</a></li>
      	</ul>
	</header>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		// Setup block
		const time_labels = <?php echo json_encode($timeArray); ?>;
		const temp_datasets = <?php echo json_encode($tempArray); ?>;

		const data_temp = {
			labels: time_labels,
			datasets: [{
				label: ' Température',
				data: temp_datasets,
				borderWidth: 2,
				borderColor: '#ba181b',
				backgroundColor: '#ba181b',
			}]
		};

		// Config block
		const config_temp = {
			type: 'line',
			data: data_temp,
			options: {
				elements: { 
					point:{
                        radius: 0
                    }
				},
				plugins: {
					title: {
						display : true,
						pointStyle : false
					},
					legend: {
						position : 'bottom',
						align: 'start',
					},
				},
				scales: {
					align: "center",
					y: {
						beginAtZero: false,
						grace: '2',
						title: {
							display: true,
							text: 'Température',
							color: '#000000',
						},
					},
					x : {
						reverse : true,
					},
				},
			},
		};
	
	
		// Render Block
		const myChart = new Chart(
			document.getElementById("temp"),
			config = config_temp
		);
	</script>

	<script>
		var temp = document.getElementById("graphTemp");
		var hum = document.getElementById("graphHum");
		var temphum = document.getElementById("graphTempAndHum");
		var tap = document.getElementById("container")
		
        temp.style.display = "block";
	</script>

<?php mysqli_close($conn); ?>
