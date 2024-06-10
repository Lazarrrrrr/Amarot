<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = ""; // Assurez-vous que le mot de passe est correct
$dbname = "WebAppDB";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $appointment_date = $_POST['appointment_date'];

    // Insérer l'utilisateur
    $stmt = $conn->prepare("INSERT INTO Users (name, email, phone) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $name, $email, $phone);
    if ($stmt->execute() === false) {
        die("Execute failed: " . $stmt->error);
    }
    $user_id = $stmt->insert_id;
    $stmt->close();

    // Insérer le message
    if ($subject && $message) {
        $stmt = $conn->prepare("INSERT INTO Messages (user_id, subject, message) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iss", $user_id, $subject, $message);
        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    }

    // Insérer le rendez-vous
    if ($appointment_date) {
        $stmt = $conn->prepare("INSERT INTO Appointments (user_id, appointment_date) VALUES (?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("is", $user_id, $appointment_date);
        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    }

    echo "Données soumises avec succès!";
}

$conn->close();
?>
