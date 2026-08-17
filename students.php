<?php

require_once "config/database.php";

$search = "";

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

if ($search !== "") {

    $sql = "SELECT * FROM students
            WHERE student_id LIKE ?
            OR first_name LIKE ?
            OR last_name LIKE ?
            OR email LIKE ?
            OR department LIKE ?
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "sssss",
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT * FROM students ORDER BY id DESC";

    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Students</title>

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

    <div class="header">

        <h1>Students</h1>

        <a
            href="add-student.php"
            class="add-button"
        >
            + Add Student
        </a>

    </div>
    <form method="GET">

    <input
        type="text"
        name="search"
        placeholder="Search students..."
        value="<?= htmlspecialchars($search) ?>"
        
    >

    <button
        type="submit"
        class="search-button"
    >
        Search
    </button>

</form>


    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Level</th>
                    <th>GPA</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php if ($result->num_rows > 0): ?>

                    <?php while ($student = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($student["student_id"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $student["first_name"] . " " . $student["last_name"]
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["email"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["department"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["level"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["gpa"]) ?>
                            </td>
                               <td>

                                    <a href="edit-student.php?id=<?= $student["id"] ?>"
                                         class="action-link edit-link"
                                     >
                                         Edit
                                     </a>

                                     <a href="delete-student.php?id=<?= $student["id"] ?>"
                                             class="action-link delete-link"
                                                onclick="return confirm('Are you sure you want to delete this student?')"
                                     >
                                         Delete
                                    </a>

                                </td>
                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="7"
                            class="empty"
                        >
                            No students found.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>