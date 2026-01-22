<?php
// public/product.php - all products or search results
include 'header.php';
include 'nav.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$where = "1=1";

if ($search !== '') {
    $safe = $conn->real_escape_string($search);
    $where .= " AND (p.name LIKE '%$safe%' OR p.description LIKE '%$safe%')";
}

$sql = "SELECT p.*, c.name AS cat_name
        FROM prj_t_product p
        LEFT JOIN prj_t_catalog c ON p.cat_id = c.ID
        WHERE $where
        ORDER BY p.ID DESC";

$res = $conn->query($sql);
?>

<div class="container my-5">
    <h2 class="mb-4">
        <?php if ($search !== ''): ?>
            Search Results for "<?= htmlspecialchars($search); ?>"
        <?php else: ?>
            All Products
        <?php endif; ?>
    </h2>

    <div class="row g-4">
        <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($p = $res->fetch_assoc()): ?>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <?php if (!empty($p['image'])): ?>
                        <img src="../images/<?= htmlspecialchars($p['image']); ?>" class="card-img-top" alt="">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x220?text=No+Image" class="card-img-top" alt="">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['name']); ?></h5>
                        <p class="fw-bold mb-1">$<?= number_format($p['price'], 2); ?></p>
                        <?php if (!empty($p['cat_name'])): ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($p['cat_name']); ?></span>
                        <?php endif; ?>

                        <div class="mt-2">
                            <a href="product_details.php?id=<?= $p['ID'] ?>" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

