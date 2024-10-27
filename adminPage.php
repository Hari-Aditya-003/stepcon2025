<?php
include_once 'classes/db1.php';

// Check if a type_id is set in the URL
$type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : null;

// Prepare the SQL query to fetch event details along with internal and external participant counts
$sql = "
    SELECT e.event_title, e.event_id, e.event_price, ef.Date, ef.time, ef.location, 
           s.name AS staff_name, st.st_name AS student_name,
           et.type_title,
           COUNT(CASE WHEN p.student_type = 'Internal' THEN 1 END) AS internal_count,
           COUNT(CASE WHEN p.student_type = 'External' THEN 1 END) AS external_count
    FROM events e
    JOIN event_info ef ON e.event_id = ef.event_id
    JOIN student_coordinator st ON e.event_id = st.event_id
    JOIN staff_coordinator s ON e.event_id = s.event_id
    JOIN event_type et ON e.type_id = et.type_id
    LEFT JOIN registered r ON e.event_id = r.event_id
    LEFT JOIN participent p ON r.usn = p.usn"; // Join with the participent table to get participant types

if ($type_id) {
    $sql .= " WHERE e.type_id = $type_id"; // Add filter for type_id
}

$sql .= " GROUP BY e.event_id"; // Group by event to calculate participant counts

$result = mysqli_query($conn, $sql);

// Fetch distinct event types for the dropdown
$eventTypesResult = mysqli_query($conn, "
    SELECT DISTINCT e.type_id, et.type_title 
    FROM events e 
    JOIN event_type et ON e.type_id = et.type_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Sanchalana 2k20</title>
    <style>
        .btn {
            padding: 5px 10px;
            text-align: center;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            margin: 2px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .form-group {
            margin: 20px 0; /* Add some margin around the form group */
        }

        select {
            padding: 10px 15px; /* Add padding for better touch target */
            border-radius: 5px; /* Rounded corners */
            border: 1px solid #007bff; /* Border color */
            background-color: #f8f9fa; /* Light background */
            font-size: 16px; /* Font size */
            color: #333; /* Text color */
            appearance: none; /* Remove default dropdown arrow */
            -webkit-appearance: none; /* For Safari */
            -moz-appearance: none; /* For Firefox */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="5" viewBox="0 0 10 5"><polygon points="0,0 5,5 10,0" fill="%23007bff"/></svg>'); /* Custom arrow */
            background-repeat: no-repeat; /* No repeat */
            background-position: right 10px center; /* Position of the custom arrow */
            background-size: 10px; /* Size of the custom arrow */
            transition: border-color 0.3s ease; /* Transition effect on focus */
        }

        select:focus {
            outline: none; /* Remove outline */
            border-color: #0056b3; /* Change border color on focus */
        }

        label {
            font-size: 18px; /* Label font size */
            font-weight: bold; /* Bold label */
            margin-bottom: 10px; /* Margin below label */
            display: block; /* Make label block-level */
        }

        .table {
            width: 100%; /* Full width table */
            border-collapse: collapse; /* Merge borders */
            margin-top: 20px; /* Margin above table */
        }

        .table th, .table td {
            border: 1px solid #dee2e6; /* Border for table cells */
            padding: 12px; /* Padding for table cells */
            text-align: left; /* Left align text */
        }

        .table th {
            background-color: #007bff; /* Header background color */
            color: white; /* Header text color */
        }

        .table tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }
    </style>
</head>

<body>
    <?php include 'utils/adminHeader.php'; ?>

    <div class="content">
        <div class="container">
            <h1>Event Details</h1>

            <!-- Dropdown for selecting branch (type_id) -->
            <div class="form-group">
                <label for="eventTypeDropdown">Select Branch:</label>
                <select id="eventTypeDropdown" onchange="filterEvents()">
                    <option value="">All Events</option>
                    <?php while ($eventType = mysqli_fetch_array($eventTypesResult)): ?>
                        <option value="<?php echo $eventType['type_id']; ?>" <?php if ($eventType['type_id'] == $type_id) echo 'selected'; ?>>
                            <?php echo $eventType['type_title']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Internal Participants</th>
                            <th>External Participants</th>
                            <th>Price</th>
                            <th>Student Coordinator</th>
                            <th>Staff Coordinator</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                            <tr>
                                <td><?php echo $row['event_title']; ?></td>
                                <td><?php echo $row['internal_count']; ?></td> <!-- Display internal participant count -->
                                <td><?php echo $row['external_count']; ?></td> <!-- Display external participant count -->
                                <td><?php echo $row['event_price']; ?></td>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['staff_name']; ?></td>
                                <td><?php echo $row['Date']; ?></td>
                                <td><?php echo $row['time']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                                <td class="action-buttons">
                                    <a class="btn btn-danger" href="deleteEvent.php?id=<?php echo $row['event_id']; ?>">Delete</a>
                                    <a href="updateEventForm.php?id=<?php echo $row['event_id']; ?>" class="btn btn-primary">Update</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No events found.</p>
            <?php endif; ?>
            
            <a class="btn btn-default" href="createEventForm.php">Create Event</a>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>

    <script>
        function filterEvents() {
            const typeId = document.getElementById('eventTypeDropdown').value;
            // Redirect to the same page with the selected type_id as a query parameter
            window.location.href = `<?php echo $_SERVER['PHP_SELF']; ?>?type_id=${typeId}`;
        }
    </script>
</body>
</html>
