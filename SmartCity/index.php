<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report City Issue</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Report a City Issue</h1>
    <form action="submit_report.php" method="POST" enctype="multipart/form-data">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <label>Category:
            <select name="category" required>
                <option value="potholes">Potholes</option>
                <option value="broken_streetlights">Broken Streetlights</option>
                <option value="garbage_overflow">Garbage Overflow</option>
                <option value="vandalism">Vandalism</option>
                <option value="other">Other</option>
            </select>
        </label><br>
        <label>Your Email: <input type="email" name="email" required></label><br>
        <label>Photo: <input type="file" name="photo" accept="image/*"></label><br>
        <label>Location: Click on the map to select</label><br>
        <div id="map" style="height: 400px;"></div>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="submit">Submit Report</button>
    </form>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([40.7128, -74.0060], 13); // Default to NYC
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;
        map.on('click', function(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
</body>
</html>