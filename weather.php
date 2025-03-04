<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información del Tiempo</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Consulta del Tiempo</h1>
    <form action="index.php" method="GET">
        <label for="city">Ciudad:</label>
        <input type="text" id="city" name="city" required>
        <button type="submit">Buscar</button>
    </form>

    <?php
    if (isset($_GET['city'])) {
        $apiKey = '8d21a8f3db9f462c8f9b2b0e3c6d7b58'; // Reemplaza con tu API Key
        $city = urlencode($_GET['city']);
        $geocodeUrl = "http://api.openweathermap.org/geo/1.0/direct?q={$city}&limit=1&appid={$apiKey}";

        // Obtener la latitud y longitud de la ciudad
        $response = @file_get_contents($geocodeUrl);

        if ($response === FALSE) {
            echo "<p class='error'>Error al conectar con la API de geolocalización.</p>";
            exit;
        }

        $data = json_decode($response, true);

        if (empty($data)) {
            echo "<p class='error'>Ciudad no encontrada.</p>";
            exit;
        }

        $lat = $data[0]['lat'];
        $lon = $data[0]['lon'];

        // Obtener el tiempo actual
        $weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric&lang=es";
        $weatherResponse = @file_get_contents($weatherUrl);

        if ($weatherResponse === FALSE) {
            echo "<p class='error'>Error al obtener el tiempo actual.</p>";
            exit;
        }

        $weatherData = json_decode($weatherResponse, true);

        // Mostrar la información del tiempo
        echo "<div class='weather-info'>";
        echo "<h2>Tiempo en {$data[0]['name']}</h2>";
        echo "<p>Temperatura: {$weatherData['main']['temp']}°C</p>";
        echo "<p>Condición: {$weatherData['weather'][0]['description']}</p>";
        echo "<p>Humedad: {$weatherData['main']['humidity']}%</p>";
        echo "<p>Viento: {$weatherData['wind']['speed']} m/s</p>";

        // Enlaces para ver más detalles
        echo "<div class='nav-links'>";
        echo "<a href='hourly.php?lat={$lat}&lon={$lon}'>Previsión por Horas</a>";
        echo "<a href='weekly.php?lat={$lat}&lon={$lon}'>Previsión Semanal</a>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</body>
</html>
