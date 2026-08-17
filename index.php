<?php

require_once "config/database.php";

// Get total number of students
$totalQuery = "SELECT COUNT(*) AS total FROM students";
$totalResult = $conn->query($totalQuery);
$totalStudents = $totalResult->fetch_assoc()["total"];

// Get average GPA
$gpaQuery = "SELECT AVG(gpa) AS average_gpa FROM students";
$gpaResult = $conn->query($gpaQuery);
$averageGpa = $gpaResult->fetch_assoc()["average_gpa"];

// Get number of 300-level students
$levelQuery = "SELECT COUNT(*) AS total FROM students WHERE level = 300";
$levelResult = $conn->query($levelQuery);
$level300 = $levelResult->fetch_assoc()["total"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Management System</title>
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


    <main class="container">

        <section class="welcome">

            <h1>Dashboard</h1>

            <p>
                Manage student records and academic information.
            </p>

        </section>


        <section class="cards">

            <div class="card">

                <h3>Total Students</h3>

                <div class="number">
                    <?= $totalStudents ?>
                </div>

            </div>


            <div class="card">

                <h3>Average GPA</h3>

                <div class="number">

                    <?= $averageGpa !== null
                        ? number_format($averageGpa, 2)
                        : "0.00"
                    ?>

                </div>

            </div>


            <div class="card">

                <h3>300 Level Students</h3>

                <div class="number">
                    <?= $level300 ?>
                </div>

            </div>

        </section>


        <section class="actions">

            <a
                href="add-student.php"
                class="button primary"
            >
                + Add Student
            </a>

            <a
                href="students.php"
                class="button secondary"
            >
                View Students
            </a>

        </section>

    </main>

</body>

</html>