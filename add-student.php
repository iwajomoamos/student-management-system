<?php

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST["student_id"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $department = trim($_POST["department"]);
    $level = (int) $_POST["level"];
    $gpa = (float) $_POST["gpa"];

    if (
        empty($student_id) ||
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($department)
    ) {

        $message = "Please fill in all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } elseif ($level < 100 || $level > 500) {

        $message = "Invalid student level.";

    } elseif ($gpa < 0 || $gpa > 5) {

        $message = "GPA must be between 0 and 5.";

    } else {

        $sql = "INSERT INTO students
                (student_id, first_name, last_name, email, department, level, gpa)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssssid",
            $student_id,
            $first_name,
            $last_name,
            $email,
            $department,
            $level,
            $gpa
        );

        if ($stmt->execute()) {

            $message = "Student added successfully!";

        } else {

            $message = "Error: " . $stmt->error;

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student</title>

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

    <h1>Add Student</h1>

    <?php if ($message): ?>

        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label for="student_id">
            Student ID
        </label>

        <input
            type="text"
            id="student_id"
            name="student_id"
            required
        >


        <label for="first_name">
            First Name
        </label>

        <input
            type="text"
            id="first_name"
            name="first_name"
            required
        >


        <label for="last_name">
            Last Name
        </label>

        <input
            type="text"
            id="last_name"
            name="last_name"
            required
        >


        <label for="email">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >


        <label for="department">
            Department
        </label>

        <input
            type="text"
            id="department"
            name="department"
            required
        >


        <label for="level">
            Level
        </label>

        <select id="level" name="level" required>

            <option value="">Select Level</option>

            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="400">400</option>
            <option value="500">500</option>

        </select>


        <label for="gpa">
            GPA
        </label>

        <input
            type="number"
            id="gpa"
            name="gpa"
            min="0"
            max="5"
            step="0.01"
            required
        >


        <button type="submit" class="form-button">
            Add Student
        </button>

    </form>
    <a href="students.php" class="action-link back-link">
    ← Back to Students
</a>

</div>

</body>

</html>