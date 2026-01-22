<?php
// nav.php - Public navigation bar

// db connection should already be available from header.php
// but we include this check to avoid errors
if (!isset($conn)) {
    require_once "../dbconn.php";
}

// Fetch categories for dropdown
$cat_sql = "SELECT * FROM prj_t_catalog ORDER BY name ASC";
$cat_res = $conn->query($cat_sql);

// Detect current page for "active" styling
$current = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">

    <!-- BRAND -->
    <a class="navbar-brand fw-bold" href="index1.php">Liza's Place</a>

    <!-- Mobile menu toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- HOME -->
        <li class="nav-item">
          <a class="nav-link <?= $current === 'index1.php' ? 'active' : '' ?>" href="index1.php">
            Home
          </a>
        </li>

        <!-- MENU DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $current === 'menu.php' ? 'active' : '' ?>"
             href="menu.php" id="menuDropdown" role="button" data-bs-toggle="dropdown">
            Menu
          </a>
          <ul class="dropdown-menu" aria-labelledby="menuDropdown">
            
            <!-- Show all items -->
            <li><a class="dropdown-item" href="menu.php">All Items</a></li>
            <li><hr class="dropdown-divider"></li>

            <!-- Dynamic categories -->
            <?php if ($cat_res && $cat_res->num_rows > 0): ?>
              <?php while ($cat = $cat_res->fetch_assoc()): ?>
                <li>
                  <a class="dropdown-item" href="menu.php?cat=<?= $cat['ID'] ?>">
                    <?= htmlspecialchars($cat['name']); ?>
                  </a>
                </li>
              <?php endwhile; ?>
            <?php else: ?>
              <li><span class="dropdown-item-text text-muted">No categories available</span></li>
            <?php endif; ?>
          </ul>
        </li>

        <!-- CONTACT -->
        <li class="nav-item">
          <a class="nav-link <?= $current === 'contactus.php' ? 'active' : '' ?>" href="contactus.php">
            Contact Us
          </a>
        </li>

      </ul>

      <!-- SEARCH FORM -->
      <form class="d-flex" action="product.php" method="get">
        <input class="form-control me-2" type="search" name="q" placeholder="Search products">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>

    </div>
  </div>
</nav>

<br>
