<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Capstone Bank</title>
  <style>
    body {
      padding-top: 60px;
      font-size: 25px;
      background: #f5fce3;
      background: -webkit-linear-gradient(to right, #f5fce3, #e1e6d6);
      background: linear-gradient(to right, #f5fce3, #e1e6d6);
    }

    .center {
      padding-top: 5px;
      background: #d49024;
      display: block;
      margin-top: 20px;
      margin-left: auto;
      margin-right: auto;
      width: 50%;
    }

    .center img {
      display: block;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <?php include('navbar.php'); ?>

  <div class="center">
    <h1 style="text-align: center">Welcome to the Capstone Bank</h1>
    <!-- Use absolute path to reference the image -->
    <img src="/bankImage.png" alt="" width="150" height="300">
    <p style="text-align: center; font-size: 20px">Code Developed by Rayan, Priyanshu and Mahesh</p>

    <!-- User Registration Form -->
    <h2 style="text-align: center;">User Registration</h2>
    <form action="register.php" method="post" style="text-align: center;">
      <label for="name">Name:</label><br>
      <input type="text" id="name" name="name" required><br>

      <!-- Change the input field name from 'accountno' to 'accID' -->
      <label for="accID">AccountNo:</label><br>
      <input type="text" id="accID" name="accID" required><br>

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br>

      <label for="balance">Balance:</label><br>
      <input type="text" id="balance" name="balance" required><br>

      <!-- Change the input field name from 'password' to 'passwords' -->
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="passwords" required><br>

      <input type="submit" value="Register">
    </form>
    <!-- End of User Registration Form -->

  </div>
  <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyASpE-ZNTqnT5d65FvAHydEwgtK16mhGeI",
    authDomain: "bankingfrauddetection.firebaseapp.com",
    projectId: "bankingfrauddetection",
    storageBucket: "bankingfrauddetection.appspot.com",
    messagingSenderId: "137543429322",
    appId: "1:137543429322:web:3edc092b2d6a69dd95d833",
    measurementId: "G-LSQBKW5DR7"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>

</body>

</html>
