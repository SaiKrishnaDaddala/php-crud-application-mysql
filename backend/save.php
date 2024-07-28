<?php
include '../autoload.php';
session_start();

$db_host = $_SESSION['db_host'] ?? null;
$db_name = $_SESSION['db_name'] ?? null;
$db_user = $_SESSION['db_user'] ?? null;
$db_pass = $_SESSION['db_pass'] ?? null;

header('Content-Type: text/plain');

if (!$db_host || !$db_name || !$db_user || !$db_pass) {
    echo "500|Database connection details not found. Please provide them in the form.";
    exit;
}

$db = new Database($db_host, $db_name, $db_user, $db_pass);
$conn = $db->dbConnection();

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "403|Invalid CSRF token";
        exit;
    }

    $type = sanitizeInput($_POST['type'] ?? '');
    if ($type === '') {
        echo "400|Invalid request";
        exit;
    }

    switch ($type) {
        case 1:
            // Add user
            $name = sanitizeInput($_POST['name']);
            $email = filter_var(sanitizeInput($_POST['email']), FILTER_VALIDATE_EMAIL);
            $phone = sanitizeInput($_POST['phone']);
            $city = sanitizeInput($_POST['city']);
            $address = sanitizeInput($_POST['address']);
            $job_title = sanitizeInput($_POST['job_title']);

            if ($email === false) {
                echo "201|Invalid email format";
                exit;
            }

            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, city, address, job_title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $email, $phone, $city, $address, $job_title);
            if ($stmt->execute()) {
                echo "200|Data added successfully";
            } else {
                echo "500|Error adding data: " . $stmt->error;
            }
            $stmt->close();
            break;
        case 2:
            // Update user
            $id = sanitizeInput($_POST['id']);
            $name = sanitizeInput($_POST['name']);
            $email = filter_var(sanitizeInput($_POST['email']), FILTER_VALIDATE_EMAIL);
            $phone = sanitizeInput($_POST['phone']);
            $city = sanitizeInput($_POST['city']);
            $address = sanitizeInput($_POST['address']);
            $job_title = sanitizeInput($_POST['job_title']);

            if ($email === false) {
                echo "201|Invalid email format";
                exit;
            }

            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, city=?, address=?, job_title=? WHERE id=?");
            $stmt->bind_param("ssssssi", $name, $email, $phone, $city, $address, $job_title, $id);
            if ($stmt->execute()) {
                echo "200|Data updated successfully";
            } else {
                echo "500|Error updating data: " . $stmt->error;
            }
            $stmt->close();
            break;
        case 3:
            // Delete user
            $id = sanitizeInput($_POST['id']);
            $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo "200|Data deleted successfully|$id";
            } else {
                echo "500|Error deleting data: " . $stmt->error;
            }
            $stmt->close();
            break;
        case 4:
            // Delete multiple users
            $ids = explode(",", sanitizeInput($_POST['id']));
            $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
            foreach ($ids as $id) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
            echo "200|Data deleted successfully";
            $stmt->close();
            break;
        default:
            echo "400|Invalid request";
            break;
    }
} else {
    echo "405|Method not allowed";
}
?>
