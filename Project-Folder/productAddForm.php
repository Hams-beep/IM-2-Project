<?php
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'item'; // Use the new table name
$user = $_SESSION['user'];

$pageTitle = 'Add Product';
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
                        <h2 class="card-title m-2">Add Product</h2>
                    </div>
                    <div class="card-body p-5" style="max-height: calc(100vh - 300px); overflow-y: auto;">
                        <form action="database/product_DB_add.php" method="POST" class="AddForm">
                            <input type="hidden" name="itemID" id="item_id">
                            <div class="addFormContainer mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" name="itemName" id="itemName">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="unitOfMeasure" class="form-label">Unit of Measure</label>
                                <input type="text" class="form-control" name="unitOfMeasure" id="unitOfMeasure">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="itemType" class="form-label">Item Type</label>
                                <input type="text" class="form-control" name="itemType" id="itemType">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" step="1" min="0" max="99999" class="form-control" name="quantity" id="quantity">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="minStockLevel" class="form-label">Min Stock Level</label>
                                <input type="number" step="1" min="0" max="99999" class="form-control" name="minStockLevel" id="minStockLevel">
                            </div>
                            <div class="addFormContainer mb-3">
                                <!-- <label for="itemStatus" class="form-label">Item Status</label>
                                <input type="number" class="form-control" name="itemStatus" id="itemStatus">
                            </div> -->
                                <div class="addFormContainer mb-3">
                                    <label for="itemStatus" class="form-label">Item Status</label>
                                    <select class="form-control" name="itemStatus" id="itemStatus">
                                        <option value="Selling">Selling</option>
                                        <option value="Not selling">Not Selling</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-row-reverse flex-wrap">
                                    <button type="submit" class="btn btn-primary mx-1 mt-4">Submit</button>
                                    <a href="productAdd.php" class="btn btn-secondary mx-1 mt-4">Cancel</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>