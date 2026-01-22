<?php
// public/index1.php – Public Home Page

include 'header.php';
include 'nav.php';
?>

<div class="container my-5">

 <!-- HERO SECTION -->
<div class="row align-items-center mb-5">
    <div class="col-md-10">
        <h1 class="display-4 fw-bold mb-3">Welcome to Our Restaurant</h1>
        <h2 class="h4 text-muted mb-4">Come hang with us!</h2>
        <p class="lead mb-4">
            Serving up your favorites with fresh ingredients, big flavor, and good vibes.
            Whether you're craving burgers, wings, or something sweet, we’ve got you.
        </p>
        <div class="d-flex gap-3">
            <a href="menu.php" class="btn btn-primary btn-lg">
                View Menu
            </a>
            <a href="contactus.php" class="btn btn-outline-secondary btn-lg">
                Contact Us
            </a>
        </div>
    </div>
</div>


    <!-- FEATURED ITEMS SECTION -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Featured Items</h3>
        <a href="menu.php" class="text-decoration-none">See full menu →</a>
    </div>

    <div class="row g-4">
        <?php
        // Pull up to 4 most recent products as "featured"
        $featured_sql = "SELECT * FROM prj_t_product ORDER BY ID DESC LIMIT 4";
        $featured_res = isset($conn) ? $conn->query($featured_sql) : false;

        if ($featured_res && $featured_res->num_rows > 0):
            while ($p = $featured_res->fetch_assoc()):
        ?>
        <div class="col-12 col-sm-6 col-md-3">
            <a href="product_details.php?id=<?= $p['ID'] ?>" class="text-decoration-none text-dark">
                <div class="card h-100 border-0 shadow-sm">
                    <?php if (!empty($p['image'])): ?>
                        <!-- images folder is in ROOT, so from /public use ../images -->
                        <img src="../images/<?= htmlspecialchars($p['image']); ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($p['name']); ?>">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x220?text=No+Image"
                             class="card-img-top"
                             alt="No image">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title mb-1">
                            <?= htmlspecialchars($p['name']); ?>
                        </h5>
                        <p class="card-text text-muted mb-2">
                            $<?= number_format($p['price'], 2); ?>
                        </p>
                        <p class="card-text small text-muted">
                            <?= htmlspecialchars(substr($p['description'], 0, 60)); ?>...
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <?php
            endwhile;
        else:
        ?>
        <div class="col-12">
            <p class="text-muted">
                No featured items yet. Add products in the admin panel to see them here.
            </p>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php include 'footer.php'; ?>
