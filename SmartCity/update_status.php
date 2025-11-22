<?php
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];

    // Update status
    $stmt = $conn->prepare("UPDATE issues SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    // Get reporter email
    $result = $conn->query("SELECT reporter_email, title FROM issues WHERE id = $id");
    $row = $result->fetch_assoc();
    $email = $row['reporter_email'];
    $title = $row['title'];

    // Send notification email
    $subject = "Issue Update: $title";
    $message = "Your reported issue status has been updated to: $status.";
    mail($email, $subject, $message);

    header("Location: admin.php");
} else {
    echo "Invalid request.";
}
$conn->close();
?>