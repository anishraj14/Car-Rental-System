<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $booking_id = trim($_POST['booking_id']);
  $name = trim($_POST['name']);

  $stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ? AND name = ?");
  $stmt->bind_param("ss", $booking_id, $name);
  $stmt->execute();
  $result = $stmt->get_result();

  echo "<h2 style='text-align:center;'>Booking Details</h2>";
  if ($result->num_rows > 0) {
    echo "<table border='1' style='margin:auto; border-collapse:collapse; padding:10px;'>
            <tr>
              <th>Booking ID</th>
              <th>Name</th>
              <th>Car</th>
              <th>Date</th>
              <th>Status</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>{$row['booking_id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['car']}</td>
              <td>{$row['date']}</td>
              <td>{$row['status']}</td>
            </tr>";
    }
    echo "</table>";
  } else {
    echo "<p style='text-align:center; color:red;'>No booking found for the given ID and name.</p>";
  }

  $stmt->close();
}
$conn->close();
?>
