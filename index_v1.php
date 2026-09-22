<?php
    //start the session so we can check who is logged in
    session_start();
    //if nobody is logged in, send them to the login page
    if(!isset($_SESSION['login_user'])) {
        header("location:index_v1.php");
        exit();
    }
    //if the logged in user is not Graeme, send them to the normal user home page
    if(strtolower($_SESSION['login_user']) !== "graeme") {
        header("location:page2_v1.php");
        exit();
    }
    //user is confirmed as the admin
    $User = $_SESSION['login_user'];
    //connect to php
    require "91902DatabaseAssesment_mysqli.php";
    //--- ADD USER ---
    if(isset($_POST['add_username']))
    {
        $UserID = mysqli_real_escape_string($conn, $_POST['add_username']);
        $PW = mysqli_real_escape_string($conn, $_POST['add_password']);
        //create a variable to store sql code for the 'Add Users' query
        $insertquery = "INSERT INTO users_id
        (User_ID, Password)
        VALUES
        ('$UserID', '$PW')";
        if(mysqli_query($conn,$insertquery))
        {
            echo "<p class='red'>Record inserted:</p>";
        }
        else
        {
            echo "<p class='red'>Error inserting record:</p>";
        }
    }
    //--- UPDATE USER ---
    if(isset($_POST['ExistingUserName']))
    {
        $ExistingUserID = mysqli_real_escape_string($conn, $_POST['ExistingUserName']);
        $NewPassword = mysqli_real_escape_string($conn, $_POST['NewPassword']);
        //create a variable to store sql code for the update query
        $updatequery = "UPDATE users_id
        SET Password = '$NewPassword'
        WHERE User_ID = '$ExistingUserID'";
        if(mysqli_query($conn,$updatequery))
        {
            echo "<p class='grey'>Password updated</p>";
        }
        else
        {
            echo "<p class='grey'>Error updating password</p>";
        }
    }
    //--- DELETE USER ---
    if(isset($_POST['UserName']))
    {
        $UserID = mysqli_real_escape_string($conn, $_POST['UserName']);
        //create a variable to store sql code for the 'delete users' query
        $deletequery = "DELETE FROM users_id
        WHERE User_ID = '$UserID'";
        if(mysqli_query($conn,$deletequery))
        {
            echo "<h3>Record deleted:</h3>";
        }
        else
        {
            echo "<h3>Error deleting record:</h3>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <!-- this is the lil blurb that shows up in Google or tabs -->
        <meta name="description" content="Graeme's Music Database - admin settings for managing user accounts">
        <!-- these are search keywords, not shown on the page, just helps people find it -->
        <meta name="keywords" content="admin settings, manage users, add user, update password, delete user, Graeme's Music">
        <!-- who made this website -->
        <meta name="author" content="Jabeen Jabbar">
        <title>Graeme's Music - Admin Settings</title>
        <!-- linking CSS -->
        <link rel="stylesheet" type="text/css" href="css/style5_v1.css">
    </head>
    <body class="black-bg">
        <main>
            <div class="nav"><!-- Holds the page navigation -->
                <a href="page2_v1.php">HOME</a>
                <a href="page3_v1.php">QUERY 1</a>
                <a href="page4_v1.php">QUERY 2</a>
                <a href="page5_v1.php">ADMIN SETTINGS</a>
                <a href="page6_v1.php">CONTACT</a>
                <a href="logout_v1.php">LOGOUT</a>
            </div>
            <div class="content"><!-- Holds the main page content -->
                <h1>ADMIN SETTINGS</h1>
                <div class="section3"><!-- Holds the view users list -->
                    <div class="user-columns"><!-- Holds usernames and passwords side by side -->
                        <div class="user-col">
                            <h5><user1>USERS</user1></h5>
                            <section1>
                                <?php
                                    //create a variable to store sql code for the "display all users" query
                                    $query = "SELECT * FROM users_id";
                                    //run the query
                                    $result = mysqli_query($conn,$query);
                                    while($output = mysqli_fetch_array($result))
                                    {
                                        echo "<user2>" .
                                        $output['User_ID'] .
                                        "</user2><br>";
                                    }
                                ?>
                            </section1>
                        </div>
                        <div class="user-col">
                            <h5><password1>PASSWORDS</password1></h5>
                            <section2>
                                <?php
                                    //run the query
                                    $result = mysqli_query($conn,$query);
                                    while($output = mysqli_fetch_array($result))
                                    {
                                        echo "<user2>" .
                                        $output['Password'] .
                                        "</user2><br>";
                                    }
                                ?>
                            </section2>
                        </div>
                    </div>
                </div>
                <div class="section3"><!-- Holds the add user form -->
                    <form method="post" id="admin_add_user">
                        <h4>
                            <label for="login">Username:</label><br/>
                            <input type="text"
                                name="add_username"
                                placeholder="Enter user name"
                                required/>
                        </h4><br/>
                        <h4>
                            <label for="login">Password:</label><br/>
                            <input type="password"
                                name="add_password"
                                placeholder="Enter user password"
                                required/>
                        </h4><br/>
                        <h4>
                            <input type="submit" value="Insert"/>
                        </h4>
                    </form>
                </div>
                <div class="section3"><!-- Holds the update user form -->
                    <form method="post" id="admin_update_user">
                        <h4>
                            <label for="ExistingUserName">User Name:</label>
                        </h4>
                        <input type="text"
                            name="ExistingUserName"
                            placeholder="Enter user name"
                            required/><br/><br/>
                        <h4>
                            <label for="NewPassword">New Password:</label>
                        </h4>
                        <input type="password"
                            name="NewPassword"
                            placeholder="Enter new password"
                            required/><br/><br/>
                        <input type="submit" value="Update Password"/>
                    </form>
                </div>
                <div class="section3"><!-- Holds the delete user form -->
                    <form method="post" id="admin_delete_user">
                        <h4>
                            <label for="login">Username:</label>
                        </h4>
                        <input type="text"
                            name="UserName"
                            placeholder="Enter user name"
                            required/><br/><br/>
                        <h4>
                            <input type="submit" value="Delete"/>
                        </h4>
                    </form>
                </div>
                <!-- === COPYRIGHT SECTION === -->
                <!-- update wording once the schedule is checked -->
                <footer class="copyright">
                    <p>&copy; 2026 Graeme's Music. All rights reserved.</p>
                </footer>
            </div>
        </main>
    </body>
</html>
