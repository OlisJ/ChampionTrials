<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'config.php';
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
    ?>
    <h1>City Issues Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_email']); ?> | <a href="logout.php">Logout</a></p>
    <?php
    $result = $conn->query("SELECT * FROM issues ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<div class='issue'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>Category: " . htmlspecialchars($row['category']) . "</p>";
        echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Location: {$row['latitude']}, {$row['longitude']}</p>";
        if ($row['photo']) echo "<img src='" . htmlspecialchars($row['photo']) . "' width='100' alt='Photo'>";
        echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
        echo "<form action='update_status.php' method='POST'>";
        echo "<input type='hidden' name='id' value='{$row['id']}'>";
        echo "<select name='status'>";
        echo "<option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>";
        echo "<option value='In Progress' " . ($row['status'] == 'In Progress' ? 'selected' : '') . ">In Progress</option>";
        echo "<option value='Resolved' " . ($row['status'] == 'Resolved' ? 'selected' : '') . ">Resolved</option>";
        echo "</select>";
        echo "<button type='submit'>Update</button>";
        echo "</form>";
        echo "</div>";
    }
    $conn->close();
    ?>
</body>
</html>