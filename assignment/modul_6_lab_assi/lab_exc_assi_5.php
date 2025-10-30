<?php
$success = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {
        $success = "🎉 Registration successful! Welcome, <strong>$name</strong>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <style>
body {
  font-family: Arial, sans-serif;
  background: #f4f6f8;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
}
.form-container {
  background: white;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
  width: 360px;
  text-align: center;
}

.form-container h2 {
  margin-bottom: 20px;
  color: #0077cc;
}
label {
  display: block;
  margin: 10px 0 5px;
  text-align: left;
  font-weight: bold;
  color: #333;
}

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #bbb;
  border-radius: 6px;
  margin-bottom: 15px;
  font-size: 16px;
  transition: border 0.3s;
}

input:focus {
  border-color: #0077cc;
  outline: none;
}

button {
  width: 100%;
  padding: 12px;
  background: #0077cc;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #005fa3;
}
.error-box {
  background: #ffe5e5;
  color: #cc0000;
  border: 1px solid #cc0000;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
  text-align: left;
}

.success-box {
  background: #e5ffe5;
  color: #006600;
  border: 1px solid #009900;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
}
  </style>
</head>
<body>
  <div class="form-container">
    <h2>User Registration</h2>

    <?php if (!empty($errors)): ?>
      <div class="error-box">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success-box">
        <p><?= $success ?></p>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Enter your name">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password">

      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>