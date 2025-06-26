<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <?php
    session_start();

    // Initialize session variables
    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";

    // Set the timezone
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $_SESSION["date"] = $date;

    // Import database connection
    include("connection.php");

    // Initialize error message
    $error = '<label for="promter" class="form-label">&nbsp;</label>';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contact = $_POST['usercontact']; 
        $password = $_POST['userpassword'];

        // Validate input (basic validation)
        if (empty($contact) || empty($password)) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Please fill in all fields.</label>';
        } else {
            // Fetch user type from webuser table
            $stmt = $database->prepare("SELECT usertype FROM webuser WHERE contact = ?");
            $stmt->bind_param("s", $contact);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $utype = $result->fetch_assoc()['usertype'];

                // Check user type and validate credentials
                if ($utype == 'p') {
                    // Patient login
                    $stmt = $database->prepare("SELECT pcontact FROM patient WHERE pcontact = ? AND ppassword = ?");
                    $stmt->bind_param("ss", $contact, $password);
                    $stmt->execute();
                    $checker = $stmt->get_result();

                    if ($checker->num_rows == 1) {
                        $_SESSION['user'] = $contact;
                        $_SESSION['usertype'] = 'p';
                        header('location: patient/index.php');
                        exit();
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid contact number or password</label>';
                    }
                } elseif ($utype == 'a') {
                    // Admin login
                    $stmt = $database->prepare("SELECT * FROM admin WHERE acontact = ? AND apassword = ?");
                    $stmt->bind_param("ss", $contact, $password);
                    $stmt->execute();
                    $checker = $stmt->get_result();

                    if ($checker->num_rows == 1) {
                        $row = $checker->fetch_assoc();
                        $_SESSION['acontact'] = $row['acontact']; 
                        $_SESSION['role'] = $row['role']; 
                        $_SESSION['user'] = $contact;
                        $_SESSION['usertype'] = 'a';
                        header('location: admin/index.php');
                        exit();
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid contact number or password</label>';
                    }
                } elseif ($utype == 'd') {
                    // Doctor login
                    $stmt = $database->prepare("SELECT doccontact FROM doctor WHERE doccontact = ? AND docpassword = ?");
                    $stmt->bind_param("ss", $contact, $password);
                    $stmt->execute();
                    $checker = $stmt->get_result();

                    if ($checker->num_rows == 1) {
                        $_SESSION['user'] = $contact;
                        $_SESSION['usertype'] = 'd';
                        header('location: doctor/index.php');
                        exit();
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid contact number or password</label>';
                    }
                }
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We can\'t find any account for this contact number.</label>';
            }
        }
    }
    ?>

    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td>
                            <p class="sub-text">Login with your details to continue</p>
                        </td>
                    </tr>
                    <tr>
                        <form action="" method="POST">
                            <td class="label-td">
                                <label for="usercontact" class="form-label">Contact Number: </label>
                            </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="text" name="usercontact" class="input-text" placeholder="Contact Number" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <label for="userpassword" class="form-label">Password: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="password" name="userpassword" class="input-text" placeholder="Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td><br>
                            <?php echo $error; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Login" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                </div>
                <tr>
                    <td>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                        <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                        <br><br><br>
                    </td>
                </tr>
                </form>
            </table>
        </div>
    </center>
</body>
</html>