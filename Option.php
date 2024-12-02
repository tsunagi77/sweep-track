<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweepTrack</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #111;
            background: url("logBG.jpg") no-repeat center center/cover;
        }
        .wrapper {
            width: 350px;
            padding: 35px;
            text-align: center;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(100px);
            background-color: #ffffff;
            position: relative;
        }
        .profile-circle {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 113px;
            height: 113px;
            background-color: #3498db;
            border-radius: 50%;
            border: 1px solid white;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/0/0a/Metro_Manila_Development_Authority_%28MMDA%29.svg/490px-Metro_Manila_Development_Authority_%28MMDA%29.svg.png');
            background-size: cover;
            background-position: center;
        }
        h4 {
            color: red;
            margin-top: 35px;
            margin-bottom: 10px;
        }
        .options {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .option {
            cursor: pointer;
            text-align: center;
            border: 2px solid transparent;
            padding: 10px;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }
        .option:hover {
            border-color: #007bff;
        }
        .option img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        button {
            background-color: navy;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="profile-circle"></div>
    <h4>Please Select Your Role</h4>
    <div class="options">
        <div class="option" onclick="selectRole('supervisor')">
            <img src="Supervisor.jpg" alt="Supervisor">
            <button>Supervisor</button>
        </div>
        <div class="option" onclick="selectRole('sweeper')">
            <img src="Sweepers.png" alt="Employee">
            <button>Sweeper</button>
        </div>
    </div>
</div>
<script>
    function selectRole(role) {
        if (role === 'sweeper') {
            window.location.href = "empLog.php";
        } else if (role === 'supervisor') {
            window.location.href = "log.php";
        } else {
            alert("Invalid Role Selected");
        }
    };
    export.build = series(scssTask,jsTask);
</script>
</body>
</html>
