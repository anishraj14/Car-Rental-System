<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";  // your DB password
$dbname = "car_rental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Basic validation
    if (empty($user) || empty($phone) || empty($pass)) {
        echo "Please fill all fields.";
        exit;
    }

    // Prepare and bind (use prepared statements for security)
    $stmt = $conn->prepare("INSERT INTO users (username, phone, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }

    $stmt->bind_param("sss", $user, $phone, $pass);

    if ($stmt->execute()) {
    // Success popup HTML + JS
    echo '
    <!DOCTYPE html>
    <html>
    <head>
      <title>Registration Successful</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background: #f4f4f9;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
        }
        .popup {
          background: white;
          padding: 2rem 3rem;
          border-radius: 12px;
          box-shadow: 0 5px 15px rgba(0,0,0,0.3);
          text-align: center;
        }
        .popup h2 {
          margin-bottom: 1rem;
          color: #2ecc71;
        }
        .popup button {
          padding: 0.75rem 2rem;
          font-size: 1rem;
          background: #3498db;
          color: white;
          border: none;
          border-radius: 8px;
          cursor: pointer;
          transition: background 0.3s ease;
        }
        .popup button:hover {
          background: #2980b9;
        }
      </style>
    </head>
    <body>
      <div class="popup">
        <h2>User registered successfully!</h2>
        <button onclick="window.location.href=\'login.html\'">Login Now</button>
      </div>
    </body>
    </html>';
} else {
    echo "Error: " . $stmt->error;
}


    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
