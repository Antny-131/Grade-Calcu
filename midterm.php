/*
	Program:		Computation of Grades using function
	Programmer:		Mark Anthony G. Petrimetre
	Section:		AN-21
	Start Date:		May 31, 2025
	End Date:		June 7, 2025

*/




<?php session_start(); ?>
<html>
<head>
    <title>Student Assessments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-row label {
            width: 220px;
            font-size: 14px;
			white-space: nowrap;
			margin-right: 10px;
        }

        .form-row input[type="text"],
        .form-row input[type="number"] {
            flex: 1;
            padding: 6px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        input[name="submit"] {
            background-color: #28a745;
            color: white;
        }

        input[name="reset"] {
            background-color: #dc3545;
            color: white;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
        }

        th, td {
            border: 2px solid gray;
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }

        th {
            background-color: #d4edda;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Enter Student Assessments</h2>

   <form method="post">
    <div class="form-section">
        <div class="form-row">
            <label>Enter the name of the student:</label>
            <input type="text" name="student_name" required>
        </div>

        <?php
        for ($i = 1; $i <= 5; $i++) {
            echo "<div class='form-row'>
                    <label>Enter enabling assessment $i:</label>
                    <input type='number' name='enabling[]' step='any' required>
                  </div>";
        }

        for ($i = 1; $i <= 3; $i++) {
            echo "<div class='form-row'>
                    <label>Enter summative assessment $i:</label>
                    <input type='number' name='summative[]' step='any' required>
                  </div>";
        }

        echo "<div class='form-row'>
                <label>Enter major exam grade:</label>
                <input type='number' name='major_exam' step='any' required>
              </div>";
        ?>
    </div>

        <input type="submit" name="submit" value="Calculate">
        <input type="submit" name="reset" value="Reset Table" formnovalidate>
    </form>

    <?php
    if (!isset($_SESSION['grades'])) {
        $_SESSION['grades'] = [];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['reset'])) {
            $_SESSION['grades'] = [];
        }

        if (isset($_POST['submit']) && isset($_POST['enabling']) && isset($_POST['summative']) && isset($_POST['major_exam'])) {
            $enabling = $_POST['enabling'];
            $summative = $_POST['summative'];
            $major_exam = round($_POST['major_exam']);
            $student_name = $_POST['student_name'];

            if (count($enabling) == 5 && count($summative) == 3) {
                $enabling_average = round(array_sum($enabling) / 5);
                $summative_average = round(array_sum($summative) / 3);
                $overall_average = round(($enabling_average + $summative_average + $major_exam) / 3);

                if ($overall_average >= 90) {
                    $letter_grade = "A";
                } elseif ($overall_average >= 80) {
                    $letter_grade = "B";
                } elseif ($overall_average >= 70) {
                    $letter_grade = "C";
                } elseif ($overall_average >= 60) {
                    $letter_grade = "D";
                } else {
                    $letter_grade = "F";
                }

                $_SESSION['grades'][] = [
                    "name" => $student_name,
                    "parti" => $enabling_average,
                    "summa" => $summative_average,
                    "major" => $major_exam,
                    "overall" => $overall_average,
                    "letter" => $letter_grade
                ];
            }
        }
    }
    ?>

    <?php if (!empty($_SESSION['grades'])): ?>
        <table>
            <tr>
                <th>Name of Student</th>
                <th>Class Participation</th>
                <th>Summative Assessment</th>
                <th>Exam Grade</th>
                <th>Grade Score</th>
                <th>Letter Grade</th>
            </tr>
            <?php foreach ($_SESSION['grades'] as $grade): ?>
                <tr>
                    <td><?= $grade['name'] ?></td>
                    <td><?= $grade['parti'] ?></td>
                    <td><?= $grade['summa'] ?></td>
                    <td><?= $grade['major'] ?></td>
                    <td><?= $grade['overall'] ?></td>
                    <td><?= $grade['letter'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
