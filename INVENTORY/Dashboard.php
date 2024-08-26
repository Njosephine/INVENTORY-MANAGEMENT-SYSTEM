<?php
session_start();
$firstname = htmlspecialchars($_SESSION['firstname']);
$lastname = htmlspecialchars($_SESSION['lastname']);

// Check if the user is logged in by checking if 'user_id' session variable is set
if (!isset($_SESSION['user_id'])) {
    // If not, redirect to login page
    header("Location: login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=1.0">
    <script src="https://kit.fontawesome.com/a906cfb875.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="dashboardMainContainer">
        <div class="dashboard_sidebar" id="dashboard_sidebar">
            <h3 class="dashboard_logo" id="dashboard_logo">IMS</h3>
            <div class="dashboard_sidebar_user">
                <img src="manager.jpg" alt="User image" id="userImage" />
                <span><?= $firstname . ' ' . $lastname ?></span>
            </div>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive"><a href="#"><i class="fa fa-dashboard menuIcons"></i> Dashboard</a></li>
                    
                    <!-- Updated "Reports" menu item with dropdown -->
                    <li class="menuDropdown"><a href="#"><i class="fa fa-file menuIcons"></i> Reports <i class="fa fa-chevron-down dropdown-icon"></i></a>
                        <ul class="submenu">
                            <li><a href="#">Report 1</a></li>
                            <li><a href="#">Report 2</a></li>
                        </ul>
                    </li>

                    <!-- Updated "Product" menu item with dropdown -->
                    <li class="menuDropdown"><a href="#"><i class="fa fa-tags menuIcons"></i> Product <i class="fa fa-chevron-down dropdown-icon"></i></a>
                        <ul class="submenu">
                            <li><a href="#">View Products</a></li>
                            <li><a href="#">Add Product</a></li>
                        </ul>
                    </li>

                    <!-- Updated "Supplier" menu item with dropdown -->
                    <li class="menuDropdown"><a href="#"><i class="fa fa-truck menuIcons"></i> Supplier <i class="fa fa-chevron-down dropdown-icon"></i></a>
                        <ul class="submenu">
                            <li><a href="#">View Suppliers</a></li>
                            <li><a href="#">Add Supplier</a></li>
                        </ul>
                    </li>

                    <!-- Updated "Purchase Order" menu item with dropdown -->
                    <li class="menuDropdown"><a href="#"><i class="fa fa-shopping-cart menuIcons"></i> Purchase Order <i class="fa fa-chevron-down dropdown-icon"></i></a>
                        <ul class="submenu">
                            <li><a href="#">View Orders</a></li>
                            <li><a href="#">Create Order</a></li>
                        </ul>
                    </li>

                    <!-- Updated "User" menu item with dropdown -->
                    <li class="menuDropdown"><a href="#"><i class="fa fa-user menuIcons"></i> User <i class="fa fa-chevron-down dropdown-icon"></i></a>
                        <ul class="submenu">
                            <li><a href="#">View Users</a></li>
                            <li><a href="#">Add User</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href="#" id="toggleBtn"><i class="fa fa-navicon"></i></a>
                <a href="Index.php" id="logoutBtn"><i class="fa fa-power-off"></i> LogOut</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <!-- Main content goes here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let sideBarIsOpen = true;

        toggleBtn.addEventListener('click', (event) => {
            event.preventDefault();
            if (sideBarIsOpen) {
                dashboard_sidebar.style.width = '10%';
                dashboard_sidebar.style.transition = '0.3s all';
                dashboard_content_container.style.width = '90%';
                dashboard_logo.style.fontSize = '60px';
                userImage.style.width = '60px';

                let menuIcons = document.getElementsByClassName('menuIcons');
                for (let i = 0; i < menuIcons.length; i++) {
                    menuIcons[i].style.display = 'none';
                }
                sideBarIsOpen = false;
            } else {
                dashboard_sidebar.style.width = '20%';
                dashboard_content_container.style.width = '80%';
                dashboard_logo.style.fontSize = '80px';
                userImage.style.width = '80px';

                let menuIcons = document.getElementsByClassName('menuIcons');
                for (let i = 0; i < menuIcons.length; i++) {
                    menuIcons[i].style.display = 'inline-block';
                }
                sideBarIsOpen = true;
            }
        });

        // JavaScript for dropdown toggle for all menus
        document.querySelectorAll('.menuDropdown > a').forEach(menu => {
            menu.addEventListener('click', (event) => {
                event.preventDefault();
                const parentLi = menu.parentElement;
                parentLi.classList.toggle('open');
            });
        });
    </script>
</body>
</html>
