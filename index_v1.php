<?php
//start the session so the user can stay logged in
session_start();
$error = NULL;
if($_SERVER["REQUEST_METHOD"] == "POST") {
        //connect.php (tells where to connect servername, dbaseName, username, password)
        require "91902DatabaseAssesment_mysqli.php";
        //username and password sent from the form
        $myusername = mysqli_real_escape_string($conn, $_POST['username']);
        $mypassword = mysqli_real_escape_string($conn, $_POST['password']);
        //create a variable to store sql code for the login query
        $query = "SELECT User_ID
               FROM users_id
               WHERE User_ID = '$myusername'
               AND Password = '$mypassword'";
        //run the query
        $result = mysqli_query($conn,$query);
        //count how many matching records were found
        $count = mysqli_num_rows($result);
        if($count == 1) {
               //store the username in the session
               $_SESSION['login_user'] = $myusername;
               //send everyone to the home page first, admin included
               header("location:page2_v2.php");
               exit();
        }
        else {
               //display an error if the username or password is incorrect
               $error = "Error Invalid username or password";
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- this is the lil blurb that shows up in Google or tabs -->
<meta name="description" content="Graeme's Music Database login page">
<!-- these are search keywords, not shown on the page, just helps people find it -->
<meta name="keywords" content="music, music database, login, sign in, songs, genres, artists, Graeme's Music">
<!-- who made this website -->
<meta name="author" content="Jabeen Jabbar">
<title>Graeme's Music - Login</title>
<!-- linking CSS -->
<link rel="stylesheet" type="text/css" href="css/style_v2.css">
</head>
<body>
<!-- Icon sprite - holds the eye icons so the toggle can just switch which one it points to -->
<svg style="display:none">
        <symbol id="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
stroke-linejoin="round">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                <circle cx="12" cy="12" r="3"></circle>
        </symbol>
        <symbol id="icon-eye-slash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
stroke-linejoin="round">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                <circle cx="12" cy="12" r="3"></circle>
                <line x1="2" y1="2" x2="22" y2="22"></line>
        </symbol>
</svg>
<main>
        <button class="menu_toggle" id="menu_toggle" type="button" aria-label="Open navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
        </button>
        <div class="navigation_overlay" id="navigation_overlay"></div>
        <div class="nav" id="navigation_menu"><!-- Holds the page navigation -->
                <a href="index_v2.php" class="active">Login</a>
                <a href="page2_v2.php">Home</a>
                <a href="page3_v2.php">Songs by Title</a>
                <a href="page4_v2.php">Songs by Genre</a>
                <a href="page6_v2.php">Contact</a>
        </div>
        <!-- Holds the login page -->
        <section class="login-page">
                <!-- left side = heading and login form -->
                <div class="login-left">
                        <h1>Welcome back</h1>
                        <p class="login-subtitle">Login to access the music database</p>
                        <!-- Holds the login form -->
                        <form method="post" id="index_v2.php">
                                <label for="username">USERNAME</label>
                                <input type="text"
                                       name="username" id="username"
                                       placeholder="Enter username..."
                                       required />
                                <label for="password">PASSWORD</label>
                                <div class="password-field"><!-- Holds the password input and the show/hide icon -->
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               placeholder="Enter Password..."
                                               required />
                                        <!-- clicking this swaps the password between hidden and visible -->
                                        <span class="toggle-password" id="togglePassword">
                                                <svg width="20" height="20"><use id="eyeIconUse" href="#icon-eye"></use></svg>
                                        </span>
                                </div>
                                <input type="submit" value="Login" />
                        </form>
                        <?php
                        if($error != NULL)
                        {
                                echo "<p class='error'>$error</p>";
                        }
                        ?>
                </div>
                <!-- right side = big placeholder image -->
                <div class="login-image-box">
                        <img src="images/placeholder.png" alt="Placeholder">
                </div>
        </section>
        <!-- === COPYRIGHT SECTION === -->
        <!-- update wording once the schedule is checked -->
        <footer class="copyright">
                <p>&copy; 2026 Graeme's Music. All rights reserved.</p>
        </footer>
</main>
<!-- My javascript links -->
<script src="js/navigation.js"></script>
<script src="js/passwordtoggle.js"></script>
</body>
</html>
