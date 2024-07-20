<?php
// Completed -minor editing
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'purchase_requests';
$user = $_SESSION['user'];

$pageTitle = 'Create Purchase Request';
include('partials/header.php');
include('database/fetchOptions.php');
include('database/fetchSupplier.php'); // Include the file to fetch suppliers
$items = fetchItem();
?>

<div id="dashboardMainContainer">
    <?php include('partials/sideBar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/topNavBar.php') ?>

        <div class="dashboard_content d-flex justify-content-center">
            <div class="container">
                <div class="card m-5">
                    <div class="card-header p-3 bg-white d-flex justify-content-between">
                        <h2 class="card-title my-2 mx-4">Create Purchase Request</h2>
                        <?php include('partials/PRSuggestionsModal.php') ?>
                        <?php include('partials/PRCostsModal.php') ?>
                        <div class="mx-3">
                            <button type="button" class="btn btn-primary my-2 px-4" data-bs-toggle="modal" data-bs-target="#PRItemCosts">
                                Prices
                            </button>
                            <button type="button" class="btn btn-primary my-2 mx-2" data-bs-toggle="modal" data-bs-target="#PRSuggestions">
                                Suggestions
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-5" style="max-height: calc(100vh - 300px); overflow-y: auto;">
                        <form action="database/PR_DB_add.php" method="POST" class="AddForm">
                            <input type="hidden" name="PRStatus" id="PRStatus" value="pending">
                            <div class="addFormContainer mb-3">
                                <label for="date_needed" class="form-label">Date Needed</label>
                                <input type="date" class="form-control" name="dateNeeded" id="date_needed" required>
                            </div>
                            <div class="addFormContainer mb-4">
                                <label for="reason" class="form-label">Reason</label>
                                <input type="text" class="form-control" name="reason" id="reason" required>
                            </div>

                            <div id="productContainer">
                                <div class="d-flex justify-content-between mb-3">
                                    <label for="product" class="form-label pt-2">Product/s</label>
                                    <div class="d-flex align-items-center">
                                        <p class="text-muted mx-2"><small>Item not found? Add it <a href="productAddForm.php" class="product-add-shortcut">here</a>!</small></p>
                                        <button type="button" id="addProductButton" class="btn btn-primary mb-3">Add Product</button>
                                    </div>
                                </div>
                                <div class="productInput mb-2 d-flex">
                                    <select class="form-control item-select" name="itemID[]" placeholder="Item Name">
                                        <option value="" disabled selected>Select Item</option>
                                        <?php foreach ($items as $item) { ?>
                                            <option value="<?= htmlspecialchars($item['itemID']) ?>">
                                                <?= htmlspecialchars($item['itemName']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <select name="supplier[]" class="form-control mx-1 supplier-select" placeholder="Supplier">
                                        <option value="0" disabled selected>Select Supplier</option>
                                    </select>
                                    <input type="number" min="0" max="99999" class="form-control quantity-input" name="requestQuantity[]" placeholder="Quantity">
                                    <span class="form-control mx-1 item-cost-span text-muted"><span>Item Cost:</span> <span class="item-cost-value"></span></span>
                                    <span class="form-control total-cost-span text-muted"><span>Total:</span> <span class="total-cost-value"></span></span>
                                    <input type="hidden" name="estimatedCost[]" class="estimated-cost-input">
                                    <button type="button" class="btn btn-danger btn-sm removeProduct mx-2" disabled>Remove</button>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse flex-wrap">
                                <button type="submit" class="btn btn-primary mx-1 mt-4">Submit</button>
                                <a href="PR.php" class="btn btn-secondary mx-1 mt-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productContainer = document.getElementById('productContainer');
        const addProductButton = document.getElementById('addProductButton');
        const itemTemplate = document.querySelector('select[name="itemID[]"]').innerHTML;

        addProductButton.addEventListener('click', function() {
            const productInput = document.createElement('div');
            productInput.classList.add('productInput', 'mb-2', 'd-flex');
            productInput.innerHTML = `
                <select class="form-control item-select" name="itemID[]" placeholder="Item">
                    ${itemTemplate}
                </select>
                <select class="form-control mx-1 supplier-select" name="supplier[]" placeholder="Supplier">
                    <option value="0" disabled selected>Select Supplier</option>
                </select>
                <input type="number" min="0" max="99999" class="form-control quantity-input" name="requestQuantity[]" placeholder="Quantity">
                <span class="form-control mx-1 item-cost-span text-muted"><span>Item Cost:</span> <span class="item-cost-value"></span></span>
                <span class="form-control total-cost-span text-muted"><span>Total:</span> <span class="total-cost-value"></span></span>
                <input type="hidden" name="estimatedCost[]" class="estimated-cost-input">
                <button type="button" class="btn btn-danger btn-sm removeProduct mx-2">Remove</button>
            `;
            productContainer.appendChild(productInput);
            attachEventListeners(productInput);
        });

        productContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeProduct')) {
                e.target.parentElement.remove();
            }
        });

        function attachEventListeners(productInput) {
            const itemSelect = productInput.querySelector('select[name="itemID[]"]');
            const supplierSelect = productInput.querySelector('select[name="supplier[]"]');
            const quantityInput = productInput.querySelector('input[name="requestQuantity[]"]');
            const estimatedCostInput = productInput.querySelector('input[name="estimatedCost[]"]');

            itemSelect.addEventListener('change', updateSuppliers);
            supplierSelect.addEventListener('change', updateCost);
            quantityInput.addEventListener('input', updateTotal);

            function updateSuppliers() {
                const itemID = itemSelect.value;
                if (itemID) {
                    fetch(`database/fetchSupplier.php?itemID=${itemID}`)
                        .then(response => response.json())
                        .then(data => {
                            supplierSelect.innerHTML = '<option value="0" disabled selected>Select Supplier</option>';
                            data.forEach(supplier => {
                                const option = document.createElement('option');
                                option.value = supplier.supplierID;
                                option.textContent = `${supplier.companyName} - $${supplier.cost}`;
                                option.dataset.cost = supplier.cost;
                                supplierSelect.appendChild(option);
                            });
                        });
                }
            }

            function updateCost() {
                const selectedSupplier = supplierSelect.options[supplierSelect.selectedIndex];
                const itemCost = selectedSupplier ? selectedSupplier.dataset.cost : 0;
                const itemCostSpan = productInput.querySelector('.item-cost-value');
                itemCostSpan.textContent = itemCost;
                updateTotal();
            }

            function updateTotal() {
                const itemCost = parseFloat(productInput.querySelector('.item-cost-value').textContent) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                const totalCostSpan = productInput.querySelector('.total-cost-value');
                const estimatedCostInput = productInput.querySelector('.estimated-cost-input');
                const totalCost = itemCost * quantity;
                totalCostSpan.textContent = totalCost.toFixed(2);
                estimatedCostInput.value = totalCost.toFixed(2);
            }
        }

        document.querySelectorAll('.productInput').forEach(attachEventListeners);
    });
</script>

<?php include('partials/footer.php'); ?>