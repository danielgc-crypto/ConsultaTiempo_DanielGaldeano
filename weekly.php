<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Previsión Semanal</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Previsión Semanal</h1>
    <div class="forecast-container">
        <h2>Temperaturas y Lluvia Semanal</h2>
        <canvas id="weeklyChart"></canvas>
        <div id="weatherIcons">
            <!-- Aquí se mostrarán los iconos del clima -->
        </div>
    </div>

    <?php
    $apiKey = ''; // Reemplaza con tu API Key
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];

    $url = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric&lang=es";
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo "<p class='error'>Error al obtener la previsión semanal.</p>";
        exit;
    }

    $data = json_decode($response, true);

    // Agrupar datos por día
    $dailyData = [];
    foreach ($data['list'] as $forecast) {
        $date = date('Y-m-d', $forecast['dt']);
        if (!isset($dailyData[$date])) {
            $dailyData[$date] = [
                'min_temp' => $forecast['main']['temp_min'],
                'max_temp' => $forecast['main']['temp_max'],
                'rain' => $forecast['rain']['3h'] ?? 0, // Precipitación en mm (3 horas)
                'icon' => $forecast['weather'][0]['icon'], // Icono del clima
                'date' => $date
            ];
        } else {
            if ($forecast['main']['temp_min'] < $dailyData[$date]['min_temp']) {
                $dailyData[$date]['min_temp'] = $forecast['main']['temp_min'];
            }
            if ($forecast['main']['temp_max'] > $dailyData[$date]['max_temp']) {
                $dailyData[$date]['max_temp'] = $forecast['main']['temp_max'];
            }
            // Sumar la precipitación si hay datos
            if (isset($forecast['rain']['3h'])) {
                $dailyData[$date]['rain'] += $forecast['rain']['3h'];
            }
        }
    }

    // Preparar datos para el gráfico
    $labels = [];
    $temperatures = [];
    $rain = [];
    $icons = [];

    foreach ($dailyData as $day) {
        $labels[] = date('D, M j', strtotime($day['date'])); // Formato: Lun, Oct 3
        $temperatures[] = [
            'min' => $day['min_temp'],
            'max' => $day['max_temp']
        ];
        $rain[] = $day['rain']; // Precipitación en mm
        $icons[] = $day['icon']; // Icono del clima
    }
    ?>

    <script>
        // Datos desde PHP
        const labels = <?php echo json_encode($labels); ?>; // Días
        const temperatures = <?php echo json_encode($temperatures); ?>; // Temperaturas
        const rain = <?php echo json_encode($rain); ?>; // Precipitación
        const icons = <?php echo json_encode($icons); ?>; // Iconos del clima

        // Configuración del gráfico
        const ctx = document.getElementById('weeklyChart').getContext('2d');
        const weeklyChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico (barras)
            data: {
                labels: labels, // Eje X: Días
                datasets: [
                    {
                        label: 'Temperatura Mínima (°C)',
                        data: temperatures.map(temp => temp.min), // Temperaturas mínimas
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Temperatura Máxima (°C)',
                        data: temperatures.map(temp => temp.max), // Temperaturas máximas
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Lluvia (mm)',
                        data: rain, // Precipitación
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        type: 'line', // Mostrar la lluvia como una línea
                        yAxisID: 'rainAxis', // Eje Y secundario para la lluvia
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Temperaturas y Lluvia Semanal'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Día'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Temperatura (°C)'
                        }
                    },
                    rainAxis: {
                        position: 'right', // Eje Y secundario para la lluvia
                        title: {
                            display: true,
                            text: 'Lluvia (mm)'
                        },
                        grid: {
                            display: false, // Ocultar la cuadrícula del eje secundario
                        }
                    }
                }
            }
        });

    </script>

    <style>
        /* Estilos para los iconos del clima */
        #weatherIcons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .weather-icon {
            text-align: center;
        }
        .weather-icon img {
            width: 50px;
            height: 50px;
        }
    </style>
</body>
</html>
