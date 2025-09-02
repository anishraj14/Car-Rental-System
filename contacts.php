<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$greeting = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['contact-name'] ?? '';
    $email = $_POST['contact-email'] ?? '';
    $phone = $_POST['contact-phone'] ?? '';
    $message = $_POST['contact-message'] ?? '';

    // DB credentials
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "car_rental";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($stmt->execute()) {
        $greeting = "Thank you, $name! Your message has been successfully submitted.";
    } else {
        $greeting = "Execute failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Me</title>
  <style>
    /* (Your existing styles remain unchanged) */
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f9;
      color: #333;
    }
    header {
      background-color: #2c3e50;
      color: white;
      padding: 1rem 2rem;
      text-align: center;
    }
    nav {
      background-color: #1a252f;
      display: flex;
      justify-content: center;
      padding: 0.5rem 0;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin: 0 1rem;
      padding: 0.5rem 1rem;
      font-weight: 500;
      transition: background-color 0.3s;
      border-radius: 6px;
    }
    nav a:hover {
      background-color: #34495e;
    }
    .contact-section {
      background-color: #f9fbfc;
      padding: 3rem 1rem;
    }
    .contact-container {
      max-width: 700px;
      margin: auto;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      text-align: center;
    }
    .contact-container h2 {
      color: #2c3e50;
      margin-bottom: 0.5rem;
    }
    .contact-container p {
      color: #555;
      margin-bottom: 2rem;
    }
    .contact-container form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .contact-container input,
    .contact-container textarea {
      width: 100%;
      max-width: 500px;
      margin: 0.5rem 0;
      padding: 0.75rem;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s ease;
    }
    .contact-container input:focus,
    .contact-container textarea:focus {
      border-color: #3498db;
      outline: none;
    }
    .contact-container button {
      margin-top: 1rem;
      padding: 0.75rem 2rem;
      font-size: 1rem;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .contact-container button:hover {
      background-color: #2980b9;
    }
    footer {
      text-align: center;
      padding: 1rem;
      background: #2c3e50;
      color: white;
      margin-top: 2rem;
    }
    .greeting-message {
      color: green;
      font-weight: bold;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <header>
    <h1>Contact ME</h1>
    <p>Get In Touch</p>
  </header>

  <nav>
    <a href="Frontpage.html">Home</a>
    <a href="login.html">Login</a>
  </nav>

  <section id="contact" class="contact-section">
    <div class="contact-container">
      <h2>Contact Us</h2>
      <?php if (!empty($greeting)) echo "<p class='greeting-message'>$greeting</p>"; ?>
      <p>If you have any questions or need assistance, feel free to reach out!</p>
      <form method="post" action="">
        <input type="text" name="contact-name" placeholder="Your Name" required />
        <input type="email" name="contact-email" placeholder="Your Email" required />
        <input type="tel" name="contact-phone" placeholder="Your Phone Number" pattern="\d{10}" required />
        <textarea name="contact-message" placeholder="Your Message" rows="5" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Pro Car Rental. All rights reserved.</p>
  </footer>

</body>
</html>
