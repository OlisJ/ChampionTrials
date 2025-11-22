<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report City Issue</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Report a City Issue</h1>

        <!-- NEW: Two-column layout -->
        <div class="form-grid">
            <!-- LEFT: All form fields -->
            <div class="form-fields">
                <form action="submit_report.php" method="POST" enctype="multipart/form-data" id="reportForm">
                    <label>Title</label>
                    <input type="text" name="title" required>

                    <label>Description</label>
                    <textarea name="description" required></textarea>

                    <label>Category</label>
                    <select name="category" required>
                        <option value="potholes">Potholes</option>
                        <option value="broken_streetlights">Broken Streetlights</option>
                        <option value="garbage_overflow">Garbage Overflow</option>
                        <option value="vandalism">Vandalism</option>
                        <option value="other">Other</option>
                    </select>

                    <label>Your Email</label>
                    <input type="email" name="email" required>

                    <label>Photo (optional)</label>
                    <input type="file" name="photo" accept="image/*">

                    <label>Location: Click on the map to select</label>

                    <!-- Hidden fields for coordinates -->
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </form>
            </div>

            <!-- RIGHT: Map + Submit button -->
            <div class="map-section">
                <div id="map"></div>

                <div class="submit-box">
                    <button type="submit" form="reportForm">Submit Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Your existing Leaflet scripts (unchanged) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([42.6625, 21.1657], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;
        map.on('click', function(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
        });
    });
    </script>
</body>
</html>