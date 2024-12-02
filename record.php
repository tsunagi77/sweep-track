<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script language="javascript">
      function setActive(button, url) {
        document.querySelectorAll(".sidebar button").forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");
      
        localStorage.setItem("activeButton",button.id);
        if (url) {
            window.location.href = url;
        }
    }
    window.onload = function() {
        const activeButtonId = localStorage.getItem("activeButton");
        if (activeButtonId) {
            const activeButton = document.getElementById(activeButtonId);
            if (activeButton) {
                document.querySelectorAll(".sidebar button").forEach(btn => btn.classList.remove("active"));
                activeButton.classList.add("active");
            }
        }
    }
    </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="design.css">
  <title>View Attendance Record</title>
    <style>
    .dropdown {
      position: fixed;
      top: 60px;
      right: 20px;
      background-color: #444;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      padding: 10px 0;
      z-index: 1000;
    }
    .dropdown ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .dropdown li button{
      display:block;
      width:100%;
      padding: 10px 20px;
      justify-content: center;
      background-color: #444;
      border: none;
      color: white;
      cursor: pointer;
    }
    .dropdown li button:hover {
      background-color: #555;
    }
    .hidden {
      display: none;
    }
     #popup-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 600px;
      max-width: 90%;
      background: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 10px;
      padding: 20px;
      display: none;
      z-index: 1000;
    }
    #popup-content {
      margin-bottom: 20px;
    }
    #popup-container button {
      padding: 10px 20px;
      background-color: navy;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    #popup-container button:hover {
      background-color: #0056b3;
    }
    #popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      z-index: 999;
    }
  </style>
</head>
<body>
  <header class="topbar">
  <img src="logoGreen.png" class="logo">
  <button class="menu-btn" onclick="toggleMenu()">☰</button>
</header>
<nav id="dropdown-menu" class="dropdown hidden">
  <ul>
    <li><button onclick="aboutUS()">About Us</button></li>
    <li><button onclick="feedback()">Feedback</button></li>
    <li><button onclick="logOut()">Log Out</button></li>
  </ul>
</nav>
<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
  <div id="popup-content"></div>
  <button onclick="closePopup()" style="padding: 10px 20px; border: none; background-color: navy; color: white; cursor: pointer; display: block; margin: 10px auto; width: 100px;">Close</button>
</div>

<script>
  function aboutUS() {
    const popupContent = document.getElementById('popup-content');
    popupContent.innerHTML = `
    <h2>About Us</h2><br>
        <img src="aboutsweep.jpg" style="width:100%; height:160px;border-radius:10px;object-fit: cover;"><br>
        <br><p> &nbsp &nbsp The MMDA Pateros Sweep Track: Work Monitoring and Health Tracking System with Statistical Tool are essential in maintaining the cleanliness and order of public spaces in Metro Manila. Despite their significant contributions, the current management system used to oversee their operations is hindered by inefficiencies, primarily caused by manual processes. These inefficiencies manifest in the areas of document delivery, communication, and health tracking, which ultimately affect the productivity and well-being of the sweepers.</p>
        <br>
        <p>&nbsp &nbsp This study aims to address these issues by developing an integrated monitoring system that will streamline the processes of document delivery, communication, and health tracking. The proposed solution will enable simplified report management through digital means, allowing for timely and organized data submission. By consolidating multiple communication methods into a unified platform, the system will reduce communication problems and ensure clear, effective exchanges between supervisors and employees. Additionally, the system will include a real-time health monitoring feature, providing supervisors with the necessary tools to oversee the health of their workers. This integrated approach is designed to enhance both operational efficiency and employees well-being, ultimately providing a comprehensive solution to the challenges faced by MMDA Sweepers.</p>`;
    openPopup();
  }

  function feedback() {
    const popupContent = document.getElementById('popup-content');
    popupContent.innerHTML = `
      <h2>Feedback</h2>
      <form>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" style="padding:5px;width:280px;height:27px;margin-bottom:10px;" required><br>
        <label for="message">Your Feedback:</label><br>
        <textarea id="message" name="message" rows="4" style="width:100%;margin-bottom:10px;" required></textarea><br>
        <button type="submit" style="width:100%;">Submit</button>
      </form>`;
    openPopup();
  }

  function openPopup() {
    document.getElementById('popup-container').style.display = 'block';
    document.getElementById('popup-overlay').style.display = 'block';
  }

  function closePopup() {
    document.getElementById('popup-container').style.display = 'none';
    document.getElementById('popup-overlay').style.display = 'none';
  }

  function logOut() {
    alert("You have been logged out.");
    window.location.href = 'empLog.php';
  }

  function toggleMenu() {
    const menu = document.getElementById('dropdown-menu');
    menu.classList.toggle('hidden');
  }
</script>

<div class="sidebar" id="sidebar">
  <button id="homeBtn" onclick="setActive(this, 'Homepage.php')">
    <span style="margin-left: 10px;">Home</span>
  </button>
  <button id="docBtn" class="active" onclick="setActive(this, 'Documentation.php')">
    <span style="margin-left: 10px;">Documentation</span>
  </button>
  <button id="feedbackBtn" onclick="setActive(this, 'Assessment.php')">
    <span style="margin-left: 10px;">Assessment</span>
  </button>
</div>

<main class="content">
<div class="rec" style="height: 100vh;">
    <div class="record">
        <h1 style="display: inline; color: black;">Attendance Records</h1>
        <button onclick="goBack()">Back to Documentation</button>
        <div id="records" style="background-color: #f1f2f6;">
            <table border="1">
                <thead>
                    <tr>
                        <th style="background-color: green; color: white;">Date</th>
                        <th style="background-color: green; color: white;">Time In</th>
                        <th style="background-color: green; color: white;">Time Out</th>
                        <th style="background-color: green; color: white;">Status</th>
                    </tr>
                </thead>
                <tbody id="attendance-records"></tbody>
            </table>
        </div>
    </div>
</div>
</main>
    <script>
        function goBack() {
            window.history.back();
        }

        const urlParams = new URLSearchParams(window.location.search);
        const employeeId = urlParams.get('employee_id');

        if (!employeeId) {
            alert("Employee ID is missing! Returning to the main page.");
            window.location.href = 'Documentation.html';
        } else {
            loadAttendance(employeeId);
        }

        function loadAttendance(employeeId) {
            fetch(`view.php?employee_id=${employeeId}`)
                .then(response => response.json())
                .then(data => {
                    const records = document.getElementById('attendance-records');
                    records.innerHTML = '';

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.date}</td>
                            <td>${row.time_in || 'N/A'}</td>
                            <td>${row.time_out || 'N/A'}</td>
                            <td>${row.status}</td>
                        `;
                        records.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Error fetching attendance:', error);
                    alert('Failed to connect attendance records. Please check your Employee ID if its correct');
                });
        }
    </script>
</body>
</html>
