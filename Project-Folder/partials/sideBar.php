<div class="dashboard_sidebar" id="dashboard_sidebar">
    <div id="dashboard_logo" class="dashboard_logo pr-2">
        <a href="" id="logoWhite"><img src="images/Logo_White.png" id="logoImage" alt="Palm Grass Hotel White Logo"></a>
    </div>

    <div class="dashboard_sidebar_menus">
        <ul class="dashboard_menu_lists">
            <li class="menuActive">
                <a href="userAdd.php"><i class="fa fa-user sidebar-icon"></i> <span class="menuText"> Profile List</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="purchaseRequestDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-sticky-note sidebar-icon"></i> <span class="menuText">Inventory</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="purchaseRequestDropdown">
                    <li class="dropdown-item"><a href="productAdd.php">Item List</a></li>
                    <li class="dropdown-item"><a href="itemChanges.php">Changes</a></li>
                    <!-- Add more dropdown items as needed -->
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="purchaseRequestDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-sticky-note sidebar-icon"></i> <span class="menuText">Purchase Requests</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="purchaseRequestDropdown">
                    <li class="dropdown-item"><a href="PR.php">Pending</a></li>
                    <li class="dropdown-item"><a href="PRHistory.php">History</a></li>
                    <!-- Add more dropdown items as needed -->
                </ul>
            </li>
            <li class="menuActive">
                <a href="supplierAdd.php"><i class="fa fa-server sidebar-icon"></i> <span class="menuText"> Suppliers</span></a>
            </li>
        </ul>
    </div>
</div>