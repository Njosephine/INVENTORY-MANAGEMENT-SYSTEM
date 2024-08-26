<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var usernameExists = false;

            // Check if username exists when focus leaves the input
            $("#username").on("blur", function () {
                var username = $(this).val();

                $.ajax({
                    url: "login.php",
                    type: "POST",
                    data: { check_username: true, username: username },
                    dataType: "json",
                    success: function (response) {
                        if (response.exists) {
                            usernameExists = true;
                            $("#username-error").text("");
                        } else {
                            usernameExists = false;
                            $("#username-error").text("Username doesn't exist.");
                        }
                    },
                    error: function () {
                        $("#username-error").text("Error checking username.");
                    }
                });
            });

            // Handle form submission
            $("form").on("submit", function (event) {
                event.preventDefault(); // Prevent default form submission

                if (!usernameExists) {
                    $("#username-error").text("Please enter a valid username.");
                    return;
                }

                var username = $("#username").val();
                var password = $("#password").val();

                $.ajax({
                    url: "login.php",
                    type: "POST",
                    data: {
                        login: true,
                        username: username,
                        password: password
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            window.location.href = "Dashboard.php"; // Redirect on successful login
                        } else {
                            if (response.error === 'username') {
                                $("#username-error").text("Invalid username.");
                            } else if (response.error === 'password') {
                                $("#password-error").text("Invalid password.");
                            }
                        }
                    },
                    error: function () {
                        $("#password-error").text("Error logging in.");
                    }
                });
            });
        });

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
        }

        window.togglePasswordVisibility = togglePasswordVisibility;
    </script>
</head>

<body>
    <div class="overlay">
        <div class="header-container">
            <h2>INVENTORY TRACKING SYSTEM</h2>
        </div>

        <div class="login-container">
            <form action="login.php" method="post">
                <label for="username">USERNAME</label>
                <input type="text" id="username" name="username" required>
                <span id="username-error" style="color: red; font-size: 0.9em; margin-top: 5px; display: block;"></span>

                <label for="password">PASSWORD</label>
             
                    <input type="password" id="password" name="password" required>
                    <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('password')"></i>
                    <span id="password-error" style="color: red; font-size: 0.9em; margin-top: 5px; display: block;"></span>
            

                <button type="submit">LOGIN</button>
                <p class="reset-message">Forgot Password?<a href="forgot_password.php" class="forgot_password-link">Reset here</a></p>
                <p class="register-message">Don't have an account? <a href="registers.php" class="register-link">Register</a></p>
            </form>

            <?php
            session_start();
            if (isset($_SESSION['success'])) {
                echo "<span style='color: red;'>" . $_SESSION['success'] . "</span>";
                unset($_SESSION['success']); // Clear the success message after displaying it
            }
            ?>
        </div>
    </div>
</body>

</html>
