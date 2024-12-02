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
  <button id="docBtn" onclick="setActive(this, 'Documentation.php')">
    <span style="margin-left: 10px;">Documentation</span>
  </button>
  <button id="feedbackBtn" class="active" onclick="setActive(this, 'Assessment.php')">
    <span style="margin-left: 10px;">Assessment</span>
  </button>
</div>

<main class="content">
    <div class="top"> Assessment </div>
        <br>
<div class="assessment">
        <div class="top">Health Monitoring Form</div>
        <div class="bottom">
        <div class="healthcontent">
            <p>This is our Health Monitoring Form for MMDA Sweepers, designed to track key health indicators and support the well-being of our team. Please fill out all sections accurately to help us maintain a comprehensive health record for our workforce.</p><br>
            <p style="font-weight: bold; font-size: 20px; text-align: center;">MMDA Sweeper Weekly Health Monitoring Form</p><br>
            <form id="healthForm" onsubmit="submitHealthAssessment(event)">
                <p>1. How have you been feeling physically at the start of your shifts this past week?<br>
                    <label><input type="radio" name="q1" value="good" required /> Good, energized, or neutral</label><br>
                    <label><input type="radio" name="q1" value="tired" /> A bit tired but okay </label><br>
                    <label><input type="radio" name="q1" value="unwell" /> Feeling unwell</label><br>
                </p>
                <hr>
                <p>2. Have you experienced any pain or discomfort while working this week?<br>
                    <label><input type="radio" name="q2" value="no_pain" required /> No pain or discomfort</label><br>
                    <label><input type="radio" name="q2" value="mild_discomfort" /> Yes, mild discomfort </label><br>
                    <label><input type="radio" name="q2" value="severe_discomfort" /> Yes, severe discomfort</label><br>
                </p>
                <hr>
                <p>3. Have you experienced symptoms like headache, dizziness, or nausea due to heat or outdoor conditions this week?<br>
                    <label><input type="radio" name="q3" value="no_symptoms" required /> No symptoms</label><br>
                    <label><input type="radio" name="q3" value="mild_symptoms" /> Yes, mild symptoms </label><br>
                    <label><input type="radio" name="q3" value="severe_symptoms" /> Yes, severe symptoms</label><br>
                </p>
                <hr>
                <p>4. How much water do you typically drink during a shift?<br>
                    <label><input type="radio" name="q4" value="less_2_glasses" required /> Less than 2 glasses</label><br>
                    <label><input type="radio" name="q4" value="2_4_glasses" /> 2-4 glasses </label><br>
                    <label><input type="radio" name="q4" value="5_more_glasses" /> 5 or more glasses</label><br>
                </p>
                <hr>
                <p>5. Did you have enough breaks in shaded or cool areas this week?<br>
                    <label><input type="radio" name="q5" value="enough_breaks" required /> Yes, I’ve had enough breaks</label><br>
                    <label><input type="radio" name="q5" value="short_breaks" /> I had only short breaks </label><br>
                    <label><input type="radio" name="q5" value="not_enough_breaks" /> No, I didn’t have enough breaks</label><br>
                </p>
                <hr>
                <p>6. Have you encountered any hazards while sweeping this week, such as sharp objects, waste, or traffic-related dangers?<br>
                    <label><input type="radio" name="q6" value="no_hazards" required /> No hazards encountered</label><br>
                    <label><input type="radio" name="q6" value="minor_hazards" /> Yes, minor hazards </label><br>
                    <label><input type="radio" name="q6" value="serious_hazards" /> Yes, serious hazards</label><br>
                </p>
                <hr>
                <p>7. Did you experience any breathing issues or chest tightness this week, possibly due to pollution?<br>
                    <label><input type="radio" name="q7" value="no_issues" required /> No issues</label><br>
                    <label><input type="radio" name="q7" value="mild_issues" /> Yes, mild issues </label><br>
                    <label><input type="radio" name="q7" value="severe_issues" /> Yes, severe issues</label><br>
                </p>
                <hr>
                <p>8. Did you feel safe and comfortable with the tools or equipment you used this week?<br>
                    <label><input type="radio" name="q8" value="tools_working" required /> Yes, everything is working well</label><br>
                    <label><input type="radio" name="q8" value="tools_need_repair" /> Some tools need repairs or replacements </label><br>
                    <label><input type="radio" name="q8" value="need_different_tools" /> No, I need different tools or equipment</label><br>
                </p>
                <hr>
                <p>9. How would you rate your energy levels throughout your shifts this week?<br>
                    <label><input type="radio" name="q9" value="high_energy" required /> High energy</label><br>
                    <label><input type="radio" name="q9" value="moderate_energy" /> Moderate energy </label><br>
                    <label><input type="radio" name="q9" value="low_energy" /> Low energy, feeling tired</label><br>
                </p>
                <hr>
                <p>10. Do you have any health-related concerns or requests for support based on your work this week?<br>
                    <label><input type="radio" name="q10" value="no_concerns" required /> None</label><br>
                    <label><input type="radio" name="q10" value="yes_concerns" /> Yes</label><br>
                </p>
                <button type="submit">Submit</button>
            </form>
            <p id="message" style="display: none; color: green;">Thank you for Answering!</p>
        </div>
        </div>
    </div>
    <script>
        function submitHealthAssessment(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById("healthForm"));

            fetch('healthformSubmit.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').style.display = 'block';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('There was a problem with your submission: ' + error.message);
            });
        }
    </script>

<div class="container">
    <div class="suggestion" style="font-family: cursive;">
        <h1>What's Your Suggestion?</h1>
        <p>We value your feedback! Please share any suggestions you have below.</p>
        
        <form id="suggestionForm" onsubmit="submitSuggestion(event)">
            <p><label for="employeeId">Employee ID:</label>
            <input type="text" id="employeeId" name="employeeId" required placeholder="Enter your Employee ID"></p>
            <label for="suggestionText">Your Suggestions:</label>
            <textarea id="suggestionText" name="suggestionText" rows="4" required placeholder="Enter your suggestions here"></textarea>
            <button type="submit">Submit</button>
        </form>
        
        <p id="confirmationMessage" style="display: none; color: green;">Thank you for your suggestion!</p>
    </div>
    <script language="javascript">
    function submitSuggestion(event) {
        event.preventDefault();
        const employeeId = document.getElementById("employeeId").value;
        const suggestionText = document.getElementById("suggestionText").value;
        const confirmationMessage = document.getElementById("confirmationMessage");

        if (employeeId && suggestionText) {
            fetch('suggests.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `employeeId=${encodeURIComponent(employeeId)}&suggestionText=${encodeURIComponent(suggestionText)}`
            })
            .then(response => response.text())
            .then(data => {
                confirmationMessage.style.display = "block";
                confirmationMessage.textContent = data;
                document.getElementById("suggestionForm").reset();
            })
            .catch(error => {
                confirmationMessage.style.display = "block";
                confirmationMessage.textContent = "Error submitting suggestion.";
                console.error(error);
            });
        } else {
            confirmationMessage.style.display = "block";
            confirmationMessage.textContent = "Please fill out all fields.";
        }
    }
    </script>
</div>
</main>
</body>
</html>
