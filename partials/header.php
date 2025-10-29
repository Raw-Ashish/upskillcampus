<?php
require_once __DIR__ . '/../config.php';
$categories = json_decode(file_get_contents(__DIR__ . '/../data/categories.json'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . " | " . $SITE_NAME : $SITE_NAME; ?></title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <!-- Logo / Site Name -->
    <a class="brand" href="/index.php"><?php echo htmlspecialchars($SITE_NAME); ?></a>

    <!-- Navigation -->
    <nav class="nav" id="mainNav">
      <ul class="nav-list">
        <?php foreach ($categories as $cat): ?>
          <li class="nav-item <?php echo !empty($cat['children']) ? 'has-dropdown' : ''; ?>">
            <a href="/category.php?slug=<?php echo urlencode($cat['slug']); ?>" class="nav-link">
              <?php echo htmlspecialchars($cat['name']); ?>
            </a>
            <?php if (!empty($cat['children'])): ?>
              <ul class="dropdown">
                <?php foreach ($cat['children'] as $sub): ?>
                  <li>
                    <a href="/category.php?slug=<?php echo urlencode($sub['slug']); ?>">
                      <?php echo htmlspecialchars($sub['name']); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <!-- Search + CTA -->
    <div class="header-cta">
      <form class="search" action="/search.php" method="get">
        <input type="text" name="q" placeholder="Search comics..." required />
      </form>
      <a class="btn premium" href="/premium.php">Premium</a>
    </div>

    <!-- Mobile menu toggle -->
    <button class="menu-toggle" id="menuToggle" aria-label="Open Menu">☰</button>
  </div>
</header>

<main class="site-main container">
