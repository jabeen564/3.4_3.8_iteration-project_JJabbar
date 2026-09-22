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
            header("location:page2_v1.php");
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
        <!-- this is the lil blurb that shows up in Google or tabs -->
        <meta name="description" content="Graeme's Music Database login page">
        <!-- these are search keywords, not shown on the page, just helps people find it -->
        <meta name="keywords" content="music, music database, login, sign in, songs, genres, artists, Graeme's Music">
        <!-- who made this website -->
        <meta name="author" content="Jabeen Jabbar">
        <title>Graeme's Music - Login</title>
        <!-- linking CSS -->
        <link rel="stylesheet" type="text/css" href="css/style_v1.css">
    </head>
    <body>
        <main>
            <!-- Holds the login page -->
            <section class="login-page">
                <!-- Holds the music database title -->
                <div class="music-title">
                    <h1>GRAEME'S<br>MUSIC</h1>
                </div>
                <!-- Holds the login form -->
                <div class="login-box">
                    <h2>WELCOME BACK</h2>
                    <form method="post" id="index_v1.php">
                        <label for="username">USERNAME</label>
                        <input type="text"
                            name="username"
                            id="username"
                            placeholder="Enter username..."
                            required />
                        <label for="password">PASSWORD</label>
                        <input type="password"
                            name="password"
                            id="password"
                            placeholder="Enter password..."
                            required />
                        <input type="submit" value="Login" />
                    </form>
                    <?php
                        if($error != NULL)
                        {
                            echo "<p class='error'>$error</p>";
                        }
                    ?>
                </div>
            </section>
            <!-- === COPYRIGHT SECTION === -->
            <!-- update wording once the schedule is checked -->
            <footer class="copyright">
                <p>&copy; 2026 Graeme's Music. All rights reserved.</p>
            </footer>
        </main>
    </body>
</html>
