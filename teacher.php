<?php
session_start();

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$teacher_name = $_SESSION['teacher_name'] ?? '';

// Function to save questions to the database using prepared statements
function saveQuestionsToDatabase($questions, $exam_title, $subject, $timer, $teacher_name, $conn) {
    // Prepare statement for inserting exam title into the exam table
    $stmt_exam = $conn->prepare("INSERT INTO exam (title, subject, timer, teacher) VALUES (?, ?, ?, ?)");
    if (!$stmt_exam) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_exam->bind_param("ssis", $exam_title, $subject, $timer, $teacher_name);
    $stmt_exam->execute();
    $exam_id = $stmt_exam->insert_id; // Get the inserted exam_id
    $stmt_exam->close();

    // Prepare statement for inserting assignments
    $stmt_assign = $conn->prepare("INSERT INTO assignments (qn, question, opt1, opt2, opt3, opt4, answer, title) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt_assign) {
        die("Error preparing statement: " . $conn->error);
    }

    // Execute the statement for inserting questions
    foreach ($questions as $question) {
        $qn = $question['qn'];
        $question_text = $question['question'];
        $opt1 = $question['opt1'];
        $opt2 = $question['opt2'];
        $opt3 = $question['opt3'];
        $opt4 = $question['opt4'];
        $answer = $question['answer'];

        // Bind parameters
        $stmt_assign->bind_param("isssssss", $qn, $question_text, $opt1, $opt2, $opt3, $opt4, $answer, $exam_title);

        // Execute the statement
        $stmt_assign->execute();
    }

    // Close the statement
    $stmt_assign->close();
}

// Check if the session variable containing the teacher's name is set
if (!isset($_SESSION['teacher_name'])) {
    // Redirect to signin page if session variable is not set
    header("Location: tea_signin.php");
    exit();
}

// Initialize variables
$num_questions = isset($_POST['num_questions']) ? (int)$_POST['num_questions'] : 0;
$exam_title = "";
$subject = "";
$timer = 0;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get number of questions entered by the user
    $num_questions = (int)$_POST['num_questions'];

    // Save questions to database only if the exam title, subject, and timer are provided
    if ($num_questions > 0 && isset($_POST['exam_title']) && isset($_POST['subject']) && isset($_POST['timer'])) {
        $exam_title = $_POST['exam_title'];
        $subject = $_POST['subject'];
        $timer = (int)$_POST['timer'];
        $questions = array();

        // Loop through submitted form data to extract questions and choices
        for ($i = 1; $i <= $num_questions; $i++) {
            $question_key = 'question_' . $i;
            $qn_key = 'qn_' . $i;
            if (isset($_POST[$question_key]) && isset($_POST[$qn_key])) {
                $qn = (int)$_POST[$qn_key];
                $question_text = $_POST[$question_key];
                $choices_key = 'choices_' . $i;
                $opt1 = $_POST[$choices_key][0];
                $opt2 = $_POST[$choices_key][1];
                $opt3 = $_POST[$choices_key][2];
                $opt4 = $_POST[$choices_key][3];

                // Get the selected answer
                $answer_key = 'correct_option_' . $i;
                if (isset($_POST[$answer_key])) {
                    $selected_option_index = $_POST[$answer_key];
                    $answer = $_POST[$choices_key][$selected_option_index - 1]; // Adjust index to match array
                } else {
                    $answer = ""; // If no answer selected, set it to empty string
                }

                // Save question and its answer
                $questions[] = array(
                    'qn' => $qn,
                    'question' => $question_text,
                    'opt1' => $opt1,
                    'opt2' => $opt2,
                    'opt3' => $opt3,
                    'opt4' => $opt4,
                    'answer' => $answer
                );
            }
        }

        // Save questions to database
        saveQuestionsToDatabase($questions, $exam_title, $subject, $timer, $teacher_name, $conn);

        // Redirect to teacher.html page
        header("Location: teacher.html");
        exit();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Generated Form</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
    }
    form {
        margin-top: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="radio"] {
        margin-right: 5px;
    }
    input[type="submit"] {
        background-color: #007bff; /* Blue color */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    input[type="submit"]:hover {
        background-color: #0056b3; /* Darker shade of blue for hover state */
    }
</style>

</head>
<body>
    <div class="container">
        <h1>User Generated Form</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="num_questions">Number of Questions:</label>
            <input type="number" id="num_questions" name="num_questions" value="<?php echo $num_questions; ?>" required><br>

            <?php
            // Display input fields for questions and choices based on user input
            for ($i = 1; $i <= $num_questions; $i++) {
                echo '<label for="qn_' . $i . '">Question Number ' . $i . ':</label>';
                echo '<input type="number" id="qn_' . $i . '" name="qn_' . $i . '" required><br>';
                
                echo '<label for="question_' . $i . '">Question ' . $i . ':</label>';
                echo '<input type="text" id="question_' . $i . '" name="question_' . $i . '" required><br>';
                
                echo '<label for="choices_' . $i . '">Choices:</label><br>';
                for ($j = 1; $j <= 4; $j++) { // Fixed 4 choices
                    echo '<input type="radio" id="choice_' . $i . '_' . $j . '" name="correct_option_' . $i . '" value="' . $j . '">';
                    echo '<input type="text" id="choice_' . $i . '_' . $j . '" name="choices_' . $i . '[]" placeholder="Option ' . $j . '">';
                    echo '<br>';
                }
                echo '<br>';
            }
            ?>

            <?php if ($num_questions > 0): ?>
            <label for="exam_title">Exam Title:</label>
            <input type="text" id="exam_title" name="exam_title" required><br>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required><br>
            <label for="timer">Timer (minutes):</label>
            <input type="number" id="timer" name="timer" required><br>
            <?php endif; ?>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
