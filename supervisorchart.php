<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, employee_id, suggestion_text, submitted_at FROM suggestions ORDER BY submitted_at ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <title>MMDA</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<style>
    .table{
        padding: 20px;
        font-family:Arial;
        text-align: center;
    }
    .table table {
      width: 100%;
      border: 3px solid black;
      margin-top: 20px;
    }
    .table th, td {
      padding: 10px;
      text-align: left;
      border: 1px solid black;
    }
    .question {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }
    .question-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        max-width: 600px;
        position: relative;
    }
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }
    #openQuestion{
        background-color: navy;
        position: absolute; 
        top: 90px; 
        right: 20px; 
        padding: 10px;
        color: white;
        cursor: pointer;
    }
    .question-content p{
        font-size: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
    }
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
  <button id="homeBtn" onclick="setActive(this, 'supervisorannounce.php')">
    <span style="margin-left: 10px;">Home</span>
  </button>
  <button id="docBtn" onclick="setActive(this, 'supervisorDocs.php')">
    <span style="margin-left: 10px;">Documentation</span>
  </button>
  <button id="feedbackBtn" class="active" onclick="setActive(this, 'supervisorchart.php')">
    <span style="margin-left: 10px;">Assessment</span>
  </button>
</div>

<main class="content">
    <div>
    <h1 style="text-align: center;">Supervisor Assessment Dashboard</h1><br>
    <button id="openQuestion">Open Health Assessment</button>
    <div id="questionContainer" class="question">
    <div class="question-content">
        <button id="closeQuestion" class="close">&times;</button>
        <h4> Health Assessment Questions</h4><br>
            <p>1. How have you been feeling physically at the start of your shifts this past week?</p>
            <p>2. Have you experienced any pain or discomfort while working this week?</p>
            <p>3. Have you experienced symptoms like headache, dizziness, or nausea due to heat or outdoor conditions this week?</p>
            <p>4. How much water do you typically drink during a shift?</p>
            <p>5. Did you have enough breaks in shaded or cool areas this week?</p>
            <p>6. Have you encountered any hazards while sweeping this week, such as sharp objects, waste, or traffic-related dangers?</p>
            <p>7. Did you experience any breathing issues or chest tightness this week, possibly due to pollution?</p>
            <p>8. Did you feel safe and comfortable with the tools or equipment you used this week?</p>
            <p>9. How would you rate your energy levels throughout your shifts this week?</p>
            <p>10. Do you have any health-related concerns or requests for support based on your work this week?</p>
        <p id="message" style="display: none;">Thank you for Answering!</p>
    </div>
    </div>
    <script type="text/javascript">
        document.getElementById("openQuestion").addEventListener("click", () => {
            document.getElementById("questionContainer").style.display = "flex";
        });

        document.getElementById("closeQuestion").addEventListener("click", () => {
            document.getElementById("questionContainer").style.display = "none";
        });
    </script>
    <p style="text-align: center;">
        Below is the visualization of the health assessment responses submitted by the MMDA Sweepers!
    </p>
    <div id="chartContainer" style="width: 80%; margin: auto; margin-top: 50px; color: black; background-color: #f1f2f6;">
        <canvas id="resultsChart"></canvas>
    </div>
    <script>
        function renderChart() {
            fetch('formresults.php')
                .then(response => response.json())
                .then(data => {
                    const questions = {};
                    data.forEach(item => {
                        const qNum = `Question ${item.question_number}`;
                        if (!questions[qNum]) {
                            questions[qNum] = {};
                        }
                        questions[qNum][item.answer] = item.count;
                    });

                    const labels = Object.keys(questions);
                    const datasets = [];
                    const answers = [...new Set(data.map(item => item.answer))];

                    answers.forEach(answer => {
                        datasets.push({
                            label: answer,
                            data: labels.map(q => questions[q][answer] || 0),
                            backgroundColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 10)`,
                        });
                    });

                    const ctx = document.getElementById('resultsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: datasets,
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Assessment Results Overview',
                                },
                            },
                        },
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', renderChart);
    </script>
</div>
<div class="assessment" style="display: flex; justify-content: center; background-color: #F8EFBA;">
    <div style="background-color: navy;">
        <img src="suggestPIc.jpg" style="width:100%; height:160px;object-fit: cover;">
        <h1 style="text-align:center; color: white;"><i>Suggestions</i></h1>
    </div>
    <div class="table">
    <table border="1">
        <tr>
            <th style="background-color: green; color: white; text-align: center;">ID</th>
            <th style="background-color: green; color: white; text-align: center;">Employee ID</th>
            <th style="background-color: green; color: white; text-align: center;">Suggestion</th>
            <th style="background-color: green; color: white; text-align: center;">Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['employee_id']}</td>
                    <td>{$row['suggestion_text']}</td>
                    <td>{$row['submitted_at']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No suggestions found.</td></tr>";
        }
        ?>
    </table>
</div>
</main>
</body>
</html>
<?php
$conn->close();
?>
