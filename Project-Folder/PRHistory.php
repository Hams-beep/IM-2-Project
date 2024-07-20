<?php
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'purchase_requests';
$user = $_SESSION['user'];

include('database/showPRs.php');
$purchaseRequests = showCompleted();

$pageTitle = 'Purchase Requests';
include('partials/header.php');
?>

<div id="dashboardMainContainer">
    <?php include('partials/sideBar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/topNavBar.php') ?>

        <div class="dashboard_content d-flex justify-content-center p-0">
            <div class="container m-0 p-0 mw-100">
                <div class="card h-100 m-2">
                    <div class="card-header p-3 bg-white d-flex justify-content-between">
                        <h2 class="card-title m-2"><i class="fa fa-list"></i> Purchase History</h2>
                        <div class="d-flex m-2">
                            <?php include('partials/PRSuggestionsModal.php') ?>
                            <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#PRSuggestions">
                                Suggestions
                            </button>
                            <a href="PRAddForm.php" class="btn btn-primary mx-2">
                                Create Purchase Request
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive flex-grow-1" style="max-height: calc(100vh - 230px); overflow-y: auto;">
                            <table class="table table-hover table-striped border-top">
                                <thead class="bg-white">
                                    <tr class="purchaseRequestAdd sticky-top">
                                        <th>ID</th>
                                        <th>Requested By</th>
                                        <th>Date Requested</th>
                                        <th>Date Needed</th>
                                        <th>Estimated Cost</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($purchaseRequests as $request) { ?>
                                        <tr>
                                            <td class="pt-3"><?= htmlspecialchars($request['PRID']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['requestedBy']) ?></td>
                                            <td class="pt-3"><?= date('M d, Y', strtotime($request['PRDateRequested'])) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['dateNeeded']) ?></td>
                                            <td class="pt-3">₱<?= htmlspecialchars($request['estimatedCost']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['PRStatus']) ?></td>
                                            <td class="text-center m-1">
                                                <?php include('partials/PRItemDetailsModal.php') ?>
                                                <button type="button" class="btn btn-sm btn-outline-info m-1" data-bs-toggle="modal" data-bs-target="#PRItemDetails" data-pr-id="<?= $request['PRID'] ?>">
                                                    <i class="fa fa-eye"></i> Details
                                                </button>
                                                <a href="#" class="btn btn-sm btn-outline-danger deleteRequest m-1" data-request-id="<?= $request['PRID'] ?>" data-stats="<?= $request['PRStatus'] ?>">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted mt-0 mx-3"><?= count($purchaseRequests) ?> Items</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "alert('" . addslashes($_SESSION['success_message']) . "');";
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo "alert('Error: " . addslashes($_SESSION['error_message']) . "');";
            unset($_SESSION['error_message']);
        }
        ?>
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteRequest')) {
                e.preventDefault();
                const deleteButton = e.target.closest('.deleteRequest');
                const requestId = deleteButton.dataset.requestId;
                const statsus = deleteButton.dataset.stats;

                if (confirm(`Are you sure you want to delete this purchase request?`)) {
                    fetch('database/deletePR.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                request_id: requestId,
                                statses: statsus
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) {
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            }
        });
    });
</script>

<?php include('partials/footer.php'); ?>