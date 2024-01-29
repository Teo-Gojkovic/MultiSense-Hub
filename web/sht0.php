<?php
include 'connexion.php';
$date = date('Y-m-d');

// Requêtes SQL pour récupérer les données
$sql_tableau = "SELECT * FROM `SHT0` ORDER BY `SHT0`.`TIME` DESC LIMIT 100";
$sql_time = "SELECT TIME FROM `SHT0` ORDER BY `SHT0`.`TIME` DESC LIMIT 100";
$sql_temp = "SELECT temp FROM `SHT0` ORDER BY `SHT0`.`TIME` DESC LIMIT 100";
$sql_hum = "SELECT hum FROM `SHT0` ORDER BY `SHT0`.`TIME` DESC LIMIT 100";

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
	<div class="boutons_flex">
		<div> <!-- graphTemp -->
			<button onclick="graphTemp()" class="cap-boutons">
				<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.7 13.468V5.66796C15.7 3.66796 14.1 1.96796 12 1.96796C11 1.96796 10.1 2.36796 9.4 3.06796C8.7 3.76796 8.3 4.66796 8.3 5.66796V13.468C6.8 14.568 6 16.268 6 18.068C6 21.268 8.7 23.968 12 23.968C15.3 23.968 18 21.268 18 18.068C18 16.268 17.2 14.568 15.7 13.468ZM12 21.968C9.8 21.968 8 20.168 8 18.068C8 16.768 8.7 15.568 9.8 14.768C10.1 14.568 10.3 14.268 10.3 13.968V5.66796C10.3 5.26796 10.5 4.76796 10.8 4.46796C11.1 4.16796 11.5 3.96796 12 3.96796C13 3.96796 13.7 4.76796 13.7 5.66796V13.968C13.7 14.268 13.9 14.668 14.2 14.768C15.3 15.468 16 16.668 16 18.068C16 20.168 14.2 21.968 12 21.968Z" fill="black"/>
					<path d="M12 20.968C13.6016 20.968 14.9 19.6696 14.9 18.068C14.9 16.4663 13.6016 15.168 12 15.168C10.3984 15.168 9.10001 16.4663 9.10001 18.068C9.10001 19.6696 10.3984 20.968 12 20.968Z" fill="black"/>
				</svg>
				Température
			</button>
		</div>
		<div> <!-- graphHum -->
			<button onclick="graphHum()" class="cap-boutons">
				<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.8 23.968C13.3 23.968 11 22.668 9.69999 20.568C8.39999 18.468 8.29999 15.868 9.39999 13.568L14.9 2.46796C15.2 1.76796 16.3 1.76796 16.7 2.46796L22.2 13.568C23.3 15.768 23.2 18.468 21.9 20.568C20.6 22.668 18.3 23.968 15.8 23.968ZM15.8 5.16796L11.2 14.468C10.4 16.068 10.5 17.968 11.4 19.468C12.3 20.968 14 21.968 15.8 21.968C17.6 21.968 19.3 21.068 20.2 19.468C21.2 17.968 21.2 16.068 20.4 14.468L15.8 5.16796Z" fill="black"/>
					<path d="M4.80001 12.968C3.50001 12.968 2.30001 12.268 1.60001 11.168C0.900014 10.068 0.800014 8.66796 1.40001 7.46796L3.90001 2.46796C4.20001 1.76796 5.40001 1.76796 5.70001 2.46796L8.20001 7.46796C8.80001 8.66796 8.70001 10.068 8.00001 11.168C7.40001 12.368 6.10001 12.968 4.80001 12.968ZM4.80001 5.16796L3.20001 8.36796C2.90001 8.96796 2.90001 9.56796 3.30001 10.168C3.60001 10.668 4.20001 10.968 4.80001 10.968C5.40001 10.968 6.00001 10.668 6.40001 10.168C6.70001 9.56796 6.70001 8.96796 6.40001 8.36796L4.80001 5.16796Z" fill="black"/>
				</svg>
				Humiité
			</button>
		</div>
		<div> <!-- graphTempAndHum -->
			<button onclick="graphTempAndHum()" class="cap-boutons">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M18.7 12.5V4.7C18.7 2.7 17.1 1 15 1C14 1 13.1 1.4 12.4 2.1C11.7 2.8 11.3 3.7 11.3 4.7V12.5C9.8 13.6 9 15.3 9 17.1C9 20.3 11.7 23 15 23C18.3 23 21 20.3 21 17.1C21 15.3 20.2 13.6 18.7 12.5ZM15 21C12.8 21 11 19.2 11 17.1C11 15.8 11.7 14.6 12.8 13.8C13.1 13.6 13.3 13.3 13.3 13V4.7C13.3 4.3 13.5 3.8 13.8 3.5C14.1 3.2 14.5 3 15 3C16 3 16.7 3.8 16.7 4.7V13C16.7 13.3 16.9 13.7 17.2 13.8C18.3 14.5 19 15.7 19 17.1C19 19.2 17.2 21 15 21Z" fill="black"/>
					<path d="M15 20C16.6016 20 17.9 18.7016 17.9 17.1C17.9 15.4984 16.6016 14.2 15 14.2C13.3984 14.2 12.1 15.4984 12.1 17.1C12.1 18.7016 13.3984 20 15 20Z" fill="black"/>
					<path d="M6.79397 12.025C5.49397 12.025 4.29397 11.325 3.59397 10.225C2.89397 9.125 2.79397 7.725 3.39397 6.525L5.89397 1.525C6.19397 0.825 7.39397 0.825 7.69397 1.525L10.194 6.525C10.794 7.725 10.694 9.125 9.99397 10.225C9.39397 11.425 8.09397 12.025 6.79397 12.025ZM6.79397 4.225L5.19397 7.425C4.89397 8.025 4.89397 8.625 5.29397 9.225C5.59397 9.725 6.19397 10.025 6.79397 10.025C7.39397 10.025 7.99397 9.725 8.39397 9.225C8.69397 8.625 8.69397 8.025 8.39397 7.425L6.79397 4.225Z" fill="black"/>
				</svg>
				Température et Humiité
			</button>
		</div>
		<!--<div>  tabTempAndHum 
			<button onclick="tabTempAndHum()" class="cap-boutons">
				<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M17.6219 2.40002H6.27861C3.89055 2.40002 2 4.30002 2 6.70002V18.2C2 20.5 3.89055 22.4 6.27861 22.4H17.7214C20.1095 22.4 22 20.5 22 18.1V6.70002C21.9005 4.30002 20.01 2.40002 17.6219 2.40002ZM6.27861 4.40002H17.7214C18.9154 4.40002 19.9104 5.40002 19.9104 6.70002V8.20002H3.99005V6.70002C3.99005 5.40002 4.98507 4.40002 6.27861 4.40002ZM17.6219 20.4H6.27861C4.98507 20.4 3.99005 19.4 3.99005 18.1V10.1H19.9104V18.1C19.9104 19.4 18.9154 20.4 17.6219 20.4Z" fill="black"/>
					<path d="M17.7 12.2H6.3C5.7 12.2 5.3 12.6 5.3 13.2C5.3 13.8 5.7 14.2 6.3 14.2H17.8C18.4 14.2 18.8 13.8 18.8 13.2C18.7 12.7 18.3 12.2 17.7 12.2Z" fill="black"/>
					<path d="M17.7 16.3H6.3C5.7 16.3 5.3 16.7 5.3 17.3C5.3 17.9 5.7 18.3 6.3 18.3H17.8C18.4 18.3 18.8 17.9 18.8 17.3C18.8 16.7 18.3 16.3 17.7 16.3Z" fill="black"/>
				</svg>
				Tableau de température et d'humiité
			</button>
		</div>-->
	</div>

	<div align = 'center'>
		<div  align = 'center' id="graphTemp" class="temp-graph">
			<canvas id="temp"></canvas>
		</div>
		<div  align = 'center' id="graphHum" class="hum-graph">
			<canvas id="hum"></canvas>
		</div>
		<div align = 'center' id="graphTempAndHum" class="temphum-graph">
			<canvas id="temphum"></canvas>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		// Setup block
		const time_labels = <?php echo json_encode($timeArray); ?>;
		const temp_datasets = <?php echo json_encode($tempArray); ?>;
		const hum_datasets = <?php echo json_encode($humArray); ?>;

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

		const data_hum = {
			labels: time_labels,
			datasets: [{
				label: ' Humidité',
				data: hum_datasets,
				borderWidth: 2,
				borderColor: '#3da5d9',
				backgroundColor: '#3da5d9',
			}]
		};

		const data_temphum = {
			labels: time_labels, 
			datasets: [
			{
				label: ' Humidité',
				data: hum_datasets,
				borderWidth: 2,
				borderColor: '#3da5d9',
				backgroundColor: '#3da5d9',
			},
			{
				label: ' Température',
				data: temp_datasets,
				borderWidth: 2,
				borderColor: '#ba181b',
				backgroundColor: '#ba181b',
			}
			],
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

		const config_hum = {
			type: 'line',
			data: data_hum,
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
					y: {
						beginAtZero: false,
						grace: '2',
						title: {
							display: true,
							text: 'Humidité',
							color: '#000000',
						},
					},
					x : {
						reverse : true,
					},
				},

			},
		};

		const config_temphum = {
			type: 'line',
			data: data_temphum,
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
					y : {
						grace: '2',
						type: 'linear',
						display: true,
						position: 'left',
						title: {
							display: true,
							text: 'Température et Humidité',
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
		const myChart2 = new Chart(
			document.getElementById("hum"),
			config = config_hum
		);
		const myChart3 = new Chart(
			document.getElementById("temphum"),
			config = config_temphum
		);
	</script>

	<script>
		var temp = document.getElementById("graphTemp");
		var hum = document.getElementById("graphHum");
		var temphum = document.getElementById("graphTempAndHum");
		var tap = document.getElementById("container")
		
		temp.style.display = "none";
		hum.style.display = "none";
		temphum.style.display = "block";

		function graphTemp() {
			if (temp.style.display === "none") {
				temp.style.display = "block"; // Le graphique de température s'affiche
				hum.style.display = "none"; // Le graphinque d'humidité disparet
				temphum.style.display = "none"; // le graphique de température et d'humidité disparret
			} else {
				temp.style.display = "none";
			}
		}

		function graphHum() {	
			if (hum.style.display === "none") {
				temp.style.display = "none"; // Le graphique de température s'affiche
				hum.style.display = "block"; // Le graphinque d'humidité disparet
				temphum.style.display = "none"; // le graphique de température et d'humidité disparret
			} else {
				x.style.display = "none";
			}
		}

		function graphTempAndHum() {
			if (temphum.style.display === "none") {
				temp.style.display = "none"; // Le graphique de température s'affiche
				hum.style.display = "none"; // Le graphinque d'humidité disparet
				temphum.style.display = "block"; // le graphique de température et d'humidité disparret
			} else {
				x.style.display = "none";
			}
		}

		function tabTempAndHum() {
		if (tab.style.display === "none") {
			tab.style.display = "block";
		} else {
			tab.style.display = "none";
		}
		}
	</script>

<?php mysqli_close($conn); ?>
