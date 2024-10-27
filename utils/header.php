<?php include 'classes/db1.php'; ?>
<title>Sanchalana 2k20</title>
<style>
    .bgImage {
        background-image: url(images/cs03.jpg);
        background-size: cover;
        background-position: center center;
        height: 650px;
        margin-bottom: 25px;
    }

    .navbar {
        display: flex;
        align-items: center; /* Align items vertically */
    }

    .form-control {
        height: 40px; /* Set a fixed height */
        margin-right: 10px; /* Spacing between select and button */
        padding: 5px; /* Padding inside select */
        font-size: 14px; /* Font size */
    }

    .btn {
        height: 30px; /* Match the height with select */
        margin-left: 10px;/* Spacing between button and select */
        background-color: white; /* Same color as select */
        border-color: #007bff;/* Border color */
    }
    
    .btn:hover {
        background-color: #0056b3; /* Darker shade on hover */
        border-color: #0056b3; /* Match border color */
    }
    #eventTypeDropdown
    {
        height: 30px;
        margin-top:13px;
        width:75px;
    }
    
</style>
<header class="bgImage"> 
    <nav class="navbar">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand">
                   <h2> STEPCONE 2K25</h2>
                </a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php"><strong>Home</strong></a></li>
                <li><a href="register.php"><strong>Register</strong></a></li>
                <li><a href="contact.php"><strong>Contact Us</strong></a></li>
                <li><a href="aboutus.php"><strong>About us</strong></a></li>
                <li>
                    <select id="eventTypeDropdown" class="form-control" onchange="filterEvents()">
                        <option value="">ALL</option>
                        <option value="1">IT Events</option>
                        <option value="2">CSE Events</option>
                        <option value="3">Mechanical Events</option>
                        <option value="4">EEE Events</option>
                    </select>
                </li>
                <li class="btnlogout">
                    <a class="btn btn-default navbar-btn" href="login_form.php">Login <span class="glyphicon glyphicon-log-in"></span></a>
                </li>
            </ul>
        </div><!--container div-->
    </nav>
    <div class="col-md-12">
        <div class="container">
            <div class="jumbotron">
                <h1><strong>Explore<br></strong> Your Favorite Event</h1>
                <p style="font-style: bold">"Limitation-It's just your imagination, so just stop thinking about limitation and think about your goal and run towards it to achieve the peak of your goal:)"</p>
                <br>
                <br>
                <div class="browse d-md-flex col-md-14">
                    <div class="row">
                        <!-- Event list will be displayed here based on the selected event type -->
                        <div id="eventsContainer">
                            <?php include 'event_list.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function filterEvents() {
        const typeId = document.getElementById('eventTypeDropdown').value;
        if (typeId) {
            // Redirect to the specific event page based on the event type
            window.location.href = `http://localhost:8080/College-Event1/College-Event-Management-System-master/EventManagementSystems/viewEvent.php?id=${typeId}`;
        }
    }
</script>
