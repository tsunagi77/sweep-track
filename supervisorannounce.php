<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="design.css">
  <title>MMDA</title>
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
    window.location.href = 'log.php';
  }

  function toggleMenu() {
    const menu = document.getElementById('dropdown-menu');
    menu.classList.toggle('hidden');
  }
</script>

<div class="sidebar" id="sidebar">
  <button id="homeBtn" class="active" onclick="setActive(this, 'supervisorannounce.php')">
    <span style="margin-left: 10px;">Home</span>
  </button>
  <button id="docBtn" onclick="setActive(this, 'supervisorDocs.php')">
    <span style="margin-left: 10px;">Documentation</span>
  </button>
  <button id="feedbackBtn" onclick="setActive(this, 'supervisorchart.php')">
    <span style="margin-left: 10px;">Assessment</span>
  </button>
</div>
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
<main class="content">
  <div class="head">
    <h1>Welcome to SweepTrack!</h1>
    <br>
    <p>This is the MMDA Pateros Sweep Track System. We’re here to support you in monitoring your health, etc. Remember to log in regularly to update your health status, report issues, and stay informed on important announcements. Thank you for helping keep our streets clean and safe!</p>
  </div>
  <div class="top"> Metropolitan Manila Development Authority: Sweepers</div>
<div class="announcement" style="width: 60%;">
    <div class="top"></div>
    <div style="display: flex; flex-direction: row;">
        <div style="background-color: #F8EFBA; margin-top: 0px; padding: 20px; font-family: cursive;"><br>
            <h1 style="text-align: center;">Upload Current Announcement</h1><br>
            <form id="upload-form" enctype="multipart/form-data">
                <p><label for="announcement">Select Image:</label></p><br>
                <input type="file" name="announcement" id="announcement" accept="image/*" required>
                <br><br>
                <button type="submit" style="padding: 10px 20px; border: none; background-color: navy; color: white; cursor: pointer; display: block; margin: 10px auto; width: 200px;">Upload and Announce</button>
            </form>
            <div id="upload-message" style="text-align: center; margin-top: 10px; color: green;"></div>
            <button id="delete-button" type="submit" style="padding: 10px 20px; border: none; background-color: navy; color: white; cursor: pointer; display: block; margin: 10px auto; width: 200px;" onclick="deleteAnnouncement()">Delete Announcement</button>
        </div>
        <div style="background-color: navy;">
            <img src="announcePic.jpg" style="width:100%; height:385px; object-fit: cover;">
        </div>
    </div>
</div>

<script>
    document.getElementById('upload-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('supervisorannounceUP.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const messageElement = document.getElementById('upload-message');
            if (data.success) {
                messageElement.style.color = 'green';
                messageElement.textContent = data.message;
            } else {
                messageElement.style.color = 'red';
                messageElement.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('upload-message').textContent = 'An error occurred. Please try again.';
        });
    });

    function deleteAnnouncement() {
        const confirmDelete = confirm("Are you sure you want to delete this announcement?");
        if (confirmDelete) {
            fetch('deleteUP.php', { method: 'POST' })
            .then(response => response.text())
            .then(result => {
                alert(result);
                window.location.reload();
            })
            .catch(error => console.error('Error deleting announcement:', error));
        }
    }
</script>


  <div class="announcement" style="display:block; max-width: 500px;">
        <div class="top" style="background-color: #c23616; color: white;"><i>Hotlines</i></div>
        <div class="bottom"><img src="emergency.jpg" class="pic"></div>
  </div>
  <div class="weatherrs">
    <h1>Weather in Your City</h1><br>
    <div id="weather" style="text-align: center;">
        <p>Loading weather...</p>
    </div>
  </div>
  <div style="text-align: center;">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15447.781513611293!2d121.05939037993632!3d14.545116244132036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c89ab827dc07%3A0xcc609a1a7ca227d1!2sPateros%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1731548051574!5m2!1sen!2sph" width="600" height="450" style="border: 2px dashed #333;
  border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</main>
<script language="javascript">
      document.addEventListener("DOMContentLoaded", function() {
        const apiKey = "f41c6fe007854c98a4761800241411"
        const location = "Pateros";

        fetch(`http://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${location}`)
            .then(response => response.json())
            .then(data => {
                const weatherDiv = document.getElementById("weather");
                const temp = data.current.temp_c;
                const condition = data.current.condition.text;
                const icon = "https:" + data.current.condition.icon;


                weatherDiv.innerHTML = `
                    <h2>${data.location.name}</h2>
                    <p>Temperature: ${temp} °C</p>
                    <p>Condition: ${condition}</p>
                    <img src="${icon}" alt="Weather icon">
                `;
            })
            .catch(error => {
                console.error("Error fetching the weather data:", error);
                document.getElementById("weather").innerHTML = `<p>Error loading weather data</p>`;
            });
    });
</script>
</body>
</html>