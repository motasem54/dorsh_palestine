<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$page_title = 'Customers';
$current_page = 'customers';

$search = $_GET['search'] ?? '';

$where = [];
$params = [];

if ($search) {
    $where[] = "(CONCAT(first_name, ' ', last_name) LIKE ? OR email LIKE ?)";
    $search_term = "%{$search}%";
    $params[] = $search_term;
    $params[] = $search_term;
}

$where_clause = $where ? 'WHERE role = "customer" AND ' . implode(' AND ', $where) : 'WHERE role = "customer"';

$customers = $db->query(
    "SELECT u.*, 
    COUNT(DISTINCT o.id) as total_orders,
    COALESCE(SUM(o.total), 0) as total_spent
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    {$where_clause}
    GROUP BY u.id
    ORDER BY u.created_at DESC
    LIMIT 50",
    $params
)->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-users"></i> Customers</h1>
</div>

<div class="dashboard-card" style="margin-bottom: 20px;">
    <div class="card-body">
        <form method="GET">
            <div style="display: flex; gap: 10px;">
                <input type="text" name="search" class="form-control" placeholder="Search customers..." value="<?php echo htmlspecialchars($search); ?>" style="flex: 1;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                <a href="index.php" class="btn btn-outline"><i class="fas fa-times"></i> Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td><span class="badge badge-info"><?php echo $customer['total_orders']; ?></span></td>
                        <td><strong>$<?php echo number_format($customer['total_spent'], 2); ?></strong></td>
                        <td><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></td>
                        <td>
                            <a href="view.php?id=<?php echo $customer['id']; ?>" class="btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
