<?php
// public/product_details.php - single product view
include 'header.php';
include 'nav.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT p.*, c.name AS cat_name 
        FROM prj_t_product p
        LEFT JOIN prj_t_catalog c ON p.cat_id = c.ID
        WHERE p.ID = $id";

$res = $conn->query($sql);
$p = $res && $res->num_rows > 0 ? $res->fetch_assoc() : null;
?>

<div class="container my-5">
    <?php if (!$p): ?>
        <h2>Product Not Found</h2>
        <p class="text-muted">The product you are looking for does not exist.</p>
    <?php else: ?>
        <div class="row">
            <div class="col-md-5">
                <div class="card product-card border-0 shadow-sm">
                    <?php if (!empty($p['image'])): ?>
                        <img src="../images/<?= htmlspecialchars($p['image']); ?>" class="card-img-top" alt="">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" alt="">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-7">
                <h2><?= htmlspecialchars($p['name']); ?></h2>
                <p class="fs-4 fw-bold text-primary">$<?= number_format($p['price'], 2); ?></p>

                <p class="mt-4">
                    <?= nl2br(htmlspecialchars($p['description'])); ?>
                </p>

                <p><strong>Category:</strong> <?= htmlspecialchars($p['cat_name']); ?></p>

                <?php if (!empty($p['cat_id'])): ?>
                    <a href="menu.php?cat=<?= $p['cat_id'] ?>" class="btn btn-secondary mt-3">
                        Back to Category
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
