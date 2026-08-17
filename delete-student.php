<?php

require_once "config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid student ID.");
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM students WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: students.php");
    exit;
} else {
    die("Error deleting student: " . $stmt->error);
}

$stmt->close();