<?php
include_once 'classes/db1.php';

if (isset($_GET['id'])) {
    $event_id = (int)$_GET['id']; // Typecasting to an integer for safety

    // Fetch the event data to pre-fill the form
    $result = mysqli_query($conn, "
        SELECT e.event_title, e.event_price, ei.Date, ei.time, ei.location 
        FROM events e
        JOIN event_info ei ON e.event_id = ei.event_id
        WHERE e.event_id = $event_id
    ");

    if (mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        echo "Event not found!";
        exit();
    }
}

if (isset($_POST['update'])) {
    // Get the updated values from the form
    $event_title = mysqli_real_escape_string($conn, $_POST['event_title']);
    $event_price = (float)$_POST['event_price'];
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Prepare and execute the update queries
    $update_events_query = "
        UPDATE events 
        SET event_title='$event_title', event_price=$event_price 
        WHERE event_id=$event_id;
    ";

    $update_event_info_query = "
        UPDATE event_info 
        SET Date='$date', time='$time', location='$location' 
        WHERE event_id=$event_id;
    ";

    // Start the transaction
    mysqli_begin_transaction($conn);

    try {
        // Execute the queries
        if (mysqli_query($conn, $update_events_query) && mysqli_query($conn, $update_event_info_query)) {
            // Commit the transaction
            mysqli_commit($conn);
            echo "<script>
                    alert('Event updated successfully!');
                    window.location.href = 'adminPage.php';
                  </script>";
        } else {
            throw new Exception("Error updating record: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        mysqli_rollback($conn);
        echo "Failed to update event: " . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Event - Sanchanala 2k20</title>
    <?php include 'utils/styles.php'; ?> <!-- CSS links -->
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include 'utils/adminHeader.php'; ?>

    <div class="w3-container">
        <div class="content">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <h2 style="margin-bottom:30px">Update Event Details</h2>

                    <form method="POST">
                        <div class="form-group">
                            <label style="font-size: 18px;">Event Name:</label>
                            <input type="text" name="event_title" class="form-control" value="<?php echo htmlspecialchars($event['event_title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">Event Price:</label>
                            <input type="number" name="event_price" class="form-control" value="<?php echo htmlspecialchars($event['event_price']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">Date:</label>
                            <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($event['Date']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">Time:</label>
                            <input type="time" name="time" class="form-control" value="<?php echo htmlspecialchars($event['time']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">Location:</label>
                            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                        </div>

                        <button type="submit" name="update" class="btn btn-primary">Update Event</button>
                        <a href="adminPage.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'utils/footer.php'; ?>
</body>
</html>
