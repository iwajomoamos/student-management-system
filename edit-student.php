<?php

require_once "config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid student ID.");
}

$id = (int) $_GET["id"];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST["student_id"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $department = trim($_POST["department"]);
    $level = (int) $_POST["level"];
    $gpa = (float) $_POST["gpa"];

    $sql = "UPDATE students
            SET student_id = ?,
                first_name = ?,
                last_name = ?,
                email = ?,
                department = ?,
                level = ?,
                gpa = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssidi",
        $student_id,
        $first_name,
        $last_name,
        $email,
        $department,
        $level,
        $gpa,
        $id
    );

    if ($stmt->execute()) {
        header("Location: students.php");
        exit;
    } else {
        $message = "Error updating student: " . $stmt->error;
    }

    $stmt->close();
}

$sql = "SELECT * FROM students WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Student</title>

<link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar">

    <h2>Student Management System</h2>

    <div>
        <a href="index.php">Dashboard</a>
        <a href="students.php">Students</a>
    </div>

</nav>

<div class="form-container">

    <h1>Edit Student</h1>

    <?php if ($message): ?>

        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label for="student_id">Student ID</label>

        <input
            type="text"
            id="student_id"
            name="student_id"
            value="<?= htmlspecialchars($student["student_id"]) ?>"
            required
        >


        <label for="first_name">First Name</label>

        <input
            type="text"
            id="first_name"
            name="first_name"
            value="<?= htmlspecialchars($student["first_name"]) ?>"
            required
        >


        <label for="last_name">Last Name</label>

        <input
            type="text"
            id="last_name"
            name="last_name"
            value="<?= htmlspecialchars($student["last_name"]) ?>"
            required
        >


        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($student["email"]) ?>"
            required
        >


        <label for="department">Department</label>

        <input
            type="text"
            id="department"
            name="department"
            value="<?= htmlspecialchars($student["department"]) ?>"
            required
        >


        <label for="level">Level</label>

        <select id="level" name="level" required>

            <option value="100" <?= $student["level"] == 100 ? "selected" : "" ?>>100</option>
            <option value="200" <?= $student["level"] == 200 ? "selected" : "" ?>>200</option>
            <option value="300" <?= $student["level"] == 300 ? "selected" : "" ?>>300</option>
            <option value="400" <?= $student["level"] == 400 ? "selected" : "" ?>>400</option>
            <option value="500" <?= $student["level"] == 500 ? "selected" : "" ?>>500</option>

        </select>


        <label for="gpa">GPA</label>

        <input
            type="number"
            id="gpa"
            name="gpa"
            min="0"
            max="5"
            step="0.01"
            value="<?= htmlspecialchars($student["gpa"]) ?>"
            required
        >


        <button type="submit" class="form-button">
            Save Changes
        </button>

    </form>

    <a href="students.php" class="action-link back-link">
        ← Back to Students
    </a>

</div>

</body>

</html>