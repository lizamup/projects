<?php
// public/menu.php - list products in one category OR all products
include 'header.php';
include 'nav.php';

// If no ?cat is provided, show all products
$catID   = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
$showAll = ($catID === 0);

// Get category name only if a specific category was requested
$cat_name = "";
if (!$showAll) {
    $c = $conn->query("SELECT name FROM prj_t_catalog WHERE ID = $catID");
    if ($c && $c->num_rows > 0) {
        $cat_name = $c->fetch_assoc()['name'];
    }
}
?>

<div class="container my-5">
    <h2 class="mb-4">
        <?php
        if ($showAll) {
            echo "Menu";
        } elseif ($cat_name) {
            echo "Category: " . htmlspecialchars($cat_name);
        } else {
            echo "Category Not Found";
        }
        ?>
    </h2>

    <?php if (!$showAll && !$cat_name): ?>
        <p class="text-muted">Invalid category selected.</p>

    <?php else: ?>
        <div class="row g-4">
            <?php
            // Build SQL depending on whether we're showing all or one category
            if ($showAll) {
                $sql = "SELECT * FROM prj_t_product ORDER BY ID DESC";
            } else {
                $sql = "SELECT * FROM prj_t_product WHERE cat_id = $catID ORDER BY ID DESC";
            }

            $res = $conn->query($sql);

            if ($res && $res->num_rows > 0):
                while ($p = $res->fetch_assoc()):
            ?>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="product_details.php?id=<?= $p['ID'] ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <?php if (!empty($p['image'])): ?>
                            <!-- images folder is in ROOT, so use ../images from public/ -->
                            <img src="../images/<?= htmlspecialchars($p['image']); ?>" class="card-img-top" alt="">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x220?text=No+Image" class="card-img-top" alt="">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= htmlspecialchars($p['name']); ?></h5>
                            <p class="fw-bold mb-0">$<?= number_format($p['price'], 2); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
                endwhile;
            else:
            ?>
                <p class="text-muted">No products found.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
