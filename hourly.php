<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Previsión por Horas</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Previsión por Horas</h1>
    <div class="forecast-container">
        <h2>Temperaturas y Lluvia por Horas</h2>
        <canvas id="hourlyChart"></canvas>
    </div>

    <!-- Botón para ir a Inicio -->
    <a href="weather.php" class="btn">Inicio</a>

    <?php
    $apiKey = '8d21a8f3db9f462c8f9b2b0e3c6d7b58'; // Reemplaza con tu API Key
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];

    $hourlyUrl = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric&lang=es";
    $hourlyResponse = @file_get_contents($hourlyUrl);

    if ($hourlyResponse === FALSE) {
        echo "<p class='error'>Error al obtener la previsión por horas.</p>";
        exit;
    }

    $hourlyData = json_decode($hourlyResponse, true);

    // Preparar datos para el gráfico
    $labels = [];
    $temperatures = [];
    $rainfall = [];

    foreach ($hourlyData['list'] as $hour) {
        $labels[] = date('H:i', $hour['dt']); // Hora en formato HH:MM
        $temperatures[] = $hour['main']['temp']; // Temperatura en °C
        $rainfall[] = isset($hour['rain']['3h']) ? $hour['rain']['3h'] : 0; // Lluvia en mm (0 si no hay datos)
    }
    ?>

    <script>
        // Datos desde PHP
        const labels = <?php echo json_encode($labels); ?>;
        const temperatures = <?php echo json_encode($temperatures); ?>;
        const rainfall = <?php echo json_encode($rainfall); ?>;

        // Configuración del gráfico
        const ctx = document.getElementById('hourlyChart').getContext('2d');
        const hourlyChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico principal, se puede modificar para todo el gráfico si es necesario
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        type: 'line', // Esta es la parte donde se hace la gráfica de línea para las temperaturas
                        data: temperatures,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true,
                        yAxisID: 'y', // Eje y para las temperaturas
                    },
                    {
                        label: 'Lluvia (mm)',
                        type: 'bar', // Esta es la parte donde se hace la gráfica de barras para la lluvia
                        data: rainfall,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1', // Eje y1 para la lluvia
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Temperaturas y Lluvia por Horas'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Hora'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Temperatura (°C)'
                        },
                        position: 'left',
                    },
                    y1: {
                        title: {
                            display: true,
                            text: 'Lluvia (mm)'
                        },
                        position: 'right',
                        grid: {
                            drawOnChartArea: false // Desactiva las líneas de la cuadrícula para el eje de la lluvia
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
