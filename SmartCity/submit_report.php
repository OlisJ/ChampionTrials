<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $category = $_POST['category'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $latitude = (float)$_POST['latitude'];
    $longitude = (float)$_POST['longitude'];

   
    if (!$latitude || !$longitude) {
        die("Please select a location on the map.");
    }

    
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $targetDir = 'uploads/';
        $fileName = basename($_FILES['photo']['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileType, ['jpg', 'png', 'jpeg', 'gif']) && $_FILES['photo']['size'] < 5000000) { // 5MB limit
            $photoPath = $targetDir . time() . '_' . $fileName; // Unique filename
            move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
        } else {
            die("Invalid photo file.");
        }
    }

    
    $stmt = $conn->prepare("INSERT INTO issues (title, description, category, latitude, longitude, photo, reporter_email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdss", $title, $description, $category, $latitude, $longitude, $photoPath, $email);
    $stmt->execute();
    $stmt->close();

    
    $subject = "Issue Reported: $title";
    $message = "Your issue has been reported. Status: Pending. We'll notify you of updates.";
    mail($email, $subject, $message);

    echo "Report submitted successfully! Check your email.";
} else {
    echo "Invalid request.";
}
$conn->close();
?>