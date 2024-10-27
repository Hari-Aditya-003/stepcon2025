<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sanchalana 2K20 Event Registration - Crypto Hunt</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        /* SOP container styling */
        .sop-container {
            background-color: #e9ecef;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sop-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .sop-container p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        /* Form container styling */
        .form-container {
            background-color: #f8f9fa;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .form-container label {
            font-weight: bold;
            color: #333;
        }

        .form-container input[type="text"], 
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php require 'utils/header.php'; ?>

    <div class="content">
        <div class="container">
            <!-- SOP Section for Crypto Hunt -->
            <div class="col-md-10 col-md-offset-1 sop-container">
                <h2> Standard Operating Procedure (SOP)</h2>
                <p>
                    This event is a thrilling and intellectually stimulating challenge that involves solving cryptographic puzzles and clues hidden in a series of digital and physical locations. 
                    Participants are expected to utilize their analytical, problem-solving, and code-breaking skills to decipher clues that lead to the next stage of the hunt.
                </p>
                <p>
                    <strong>Objective:</strong> The goal of this event is to find hidden messages or codes that unlock the next clue, ultimately leading to the final location or solution. 
                    Participants must solve a sequence of puzzles in the shortest time possible to win the challenge.
                </p>
                <p>
                    <strong>Rules and Guidelines:</strong>
                    <ul>
                        <li>Teams can consist of up to 4 members.</li>
                        <li>All participants must bring their own devices (laptops or smartphones) with internet connectivity.</li>
                        <li>Use of external help or collaboration with other teams is strictly prohibited.</li>
                        <li>The event is time-bound, and the team with the fastest completion time wins.</li>
                    </ul>
                </p>
                <p>
                    <strong>Judging Criteria:</strong>
                    <ul>
                        <li>Accuracy of answers.</li>
                        <li>Time taken to solve all clues and reach the final solution.</li>
                        <li>Penalties will be given for wrong answers or attempts.</li>
                    </ul>
                </p>
            </div>

            <!-- Registration Form Section -->
            <div class="col-md-6 col-md-offset-3 form-container">
                <form method="POST" id="registrationForm" action="redirect_to_stripe.php">
                    <label for="usn">Student USN:</label>
                    <input type="text" name="usn" id="usn" class="form-control" required><br>

                    <label for="event_id">Event:</label>
                    <select name="event_id" id="event_id" class="form-control" required>
                        <option value="">Select Event</option>
                        <?php
                        include 'classes/db1.php';
                        $event_query = "SELECT event_id, event_title FROM events";
                        $event_result = mysqli_query($conn, $event_query);

                        if (mysqli_num_rows($event_result) > 0) {
                            while ($row = mysqli_fetch_assoc($event_result)) {
                                echo "<option value='" . $row['event_id'] . "'>" . $row['event_title'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No events available</option>";
                        }
                        ?>
                    </select><br>

                    <button type="submit" class="btn btn-primary">Pay & Register</button>
                    <a href="usn.php">Already registered?</a>
                </form>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>
</html>
