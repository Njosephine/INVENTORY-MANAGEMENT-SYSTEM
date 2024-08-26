<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('back.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .signup-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .signup-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .signup-container label {
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
            color: #555;
            text-align: left;
            text-transform: uppercase;
        }

        .signup-container input[type="text"],
        .signup-container input[type="email"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 12px;
            transition: border-color 0.3s;
        }

        .signup-container input[type="text"]:focus,
        .signup-container input[type="email"]:focus,
        .signup-container input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .signup-container .password-container {
            position: relative;
        }

        .signup-container .password-container input[type="password"],
        .signup-container .password-container input[type="text"] {
            padding-right: 40px;
        }

        .signup-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #555;
        }

        .signup-container button {
            width: 100%;
            padding: 12px;
            background-color: #e91e63;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .signup-container button:hover {
            background-color: #c2185b;
        }

        .signup-container .extra-links {
            margin-top: 15px;
            font-size: 14px;
        }

        .signup-container .extra-links a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .signup-container .extra-links a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <h2>Create Your Account</h2>

        
        <form id="signup-form" action="register.php" method="post" onsubmit="return validateForm()">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <span id="username-error" style="color: red; font-size: 0.9em; margin-top: 5px; display: none;"></span>
            <?php
             session_start();
             if (isset($_SESSION['error'])) {
             echo "<span style='color: red;'>" . $_SESSION['error'] . "</span>";
             unset($_SESSION['error']); // Clear the error message after displaying it
        }
        ?>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span id="toggle-password" class="toggle-password">&#128065;</span>
            </div>

            <span id="password-error" style="color: red; font-size: 0.9em; margin-top: 5px; display: block;"></span>

            <button type="submit" style="text-decoration: none; color: #fff;">REGISTER</button>
        </form>
       
        <div class="extra-links">
            <p>Already have an account? <a href="login_page.php">Sign In</a></p>
        </div>
    </div>
    <script>
        // AJAX function to check username availability
        function checkUsernameExists(username) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_username.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var usernameError = document.getElementById('username-error');
                    if (xhr.responseText === 'exists') {
                        usernameError.textContent = 'Username already exists.';
                        usernameError.style.display = 'block';  // Show error message
                    } else {
                        usernameError.style.display = 'none';  // Hide error message
                    }
                }
            };
            xhr.send('username=' + encodeURIComponent(username));
        }

        // Event listener for username input
        document.getElementById('username').addEventListener('input', function () {
            var username = this.value;
            if (username.length > 0) {
                checkUsernameExists(username);
            } else {
                document.getElementById('username-error').style.display = 'none';
            }
        });

        // Password validation
        function validatePassword() {
            var password = document.getElementById('password').value;
            var passwordError = document.getElementById('password-error');
            var strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?`~])[A-Za-z\d!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?`~]{8,}$/;

            if (!strongPasswordRegex.test(password)) {
                passwordError.textContent = 'Password must be at least 8 characters long and include uppercase, lowercase, a number, and a special character.';
                passwordError.style.display = 'block';
                return false;
            } else {
                passwordError.style.display = 'none';
                return true;
            }
        }
               // Form validation
        function validateForm() {
            return validatePassword();
        }

        

       
        // Toggle password visibility
        document.getElementById('toggle-password').addEventListener('click', function () {
            var passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '&#128065;'; // Show open eye
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '&#128065;/'; // Show closed eye with slash
            }
        });



    </script>
</body>

</html>