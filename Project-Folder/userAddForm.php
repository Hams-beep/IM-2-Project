<?php
// session start
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];

$pageTitle = 'Add User';
include('partials/header.php');
?>

<div id="dashboardMainContainer">
    <?php include('partials/sideBar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/topNavBar.php') ?>

        <div class="dashboard_content d-flex justify-content-center">
            <div class="container">
                <div class="card m-5">
                    <div class="card-header p-3 bg-white">
                        <h2 class="card-title m-2">Add User</h2>
                    </div>
                    <div class="card-body p-5" style="max-height: calc(100vh - 300px); overflow-y: auto;">
                        <form action="database/user_DB_add.php" method="POST" class="AddForm">
                            <input type="hidden" name="userID" id="user_id">
                            <div class="addFormContainer mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" name="department" id="department">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="permissions" class="form-label">Position</label>
                                <select class="form-control" name="permissions" id="permissions">
                                    <option value="Purchasing Head">Purchasing Head</option>
                                    <option value="Admin">Admin</option>
                                    <option value="IT">IT</option>
                                </select>
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="workStatus" class="form-label">Work Status</label>
                                <select class="form-control" name="workStatus" id="workStatus">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row-reverse flex-wrap">
                                <button type="submit" class="btn btn-primary mx-1 mt-4">Submit</button>
                                <a href="userAdd.php" class="btn btn-secondary mx-1 mt-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function script() {
        this.initialize = function() {
            this.registerEvents();
        };

        this.registerEvents = function() {
            document.addEventListener('click', function(e) {
                let targetElement = e.target;
                let classList = targetElement.classList;

            });
        };

        this.initialize();
    }

    new script();
</script>

<?php include('partials/footer.php'); ?>