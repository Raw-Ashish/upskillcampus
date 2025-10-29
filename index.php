<?php
$pageTitle = "Home";
require_once __DIR__ . "/partials/header.php";

$postsFile = __DIR__ . "/data/posts.json";
$posts = file_exists($postsFile) ? json_decode(file_get_contents($postsFile), true) : [];

$recent = array_slice(array_reverse($posts), 0, 8);
$popular = array_values(array_filter($posts, fn($p) => !empty($p['popular'])));
$popular = array_slice($popular, 0, 6);
?>

<section class="hero">
  <h2>Welcome to <?php echo $SITE_NAME; ?></h2>
  <p class="muted">SupplyWalah Adult Comics. Clean layout. Fast browsing.</p>
</section>

<h3>Recent Uploads</h3>
<div class="grid">
  <?php if(empty($recent)): ?>
    <div class="notice">No posts yet. Use the <a class="btn" href="/admin/">CMS</a> to add your first comic.</div>
  <?php else: foreach ($recent as $p): ?>
    <a class="card" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">
      
      <!-- Thumbnail + Premium Lock -->
      <div class="thumb-box">
        <img class="thumb" src="<?php echo htmlspecialchars($p['thumb']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
        <?php if (!empty($p['premium']) && !empty($p['price'])): ?>
          <div class="lock-overlay">
            <span class="lock-icon">⭐ Premium</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Body -->
      <div class="body">
        <div><?php echo htmlspecialchars($p['title']); ?></div>
        <div class="meta">
          <span><?php echo htmlspecialchars($p['category']); ?></span>
          <span>Views: <?php echo intval($p['views'] ?? 0); ?></span>
        </div>

        <!-- Price -->
        <?php if (!empty($p['premium']) && !empty($p['price'])): 
          $orig = $p['price'];
          $discounted = $orig - ($orig * $GLOBAL_DISCOUNT / 100);
        ?>
          <div class="price">
            <span class="old-price" style="text-decoration:line-through;color:#999;">₹<?= $orig ?></span>
            <span class="new-price" style="font-weight:bold;color:#e60023;">₹<?= $discounted ?></span>
          </div>
        <?php endif; ?>
      </div>

    </a>
  <?php endforeach; endif; ?>
</div>

<h3>Popular</h3>
<div class="grid">
  <?php if(empty($popular)): ?>
    <div class="notice">No popular posts yet. Mark some as popular in CMS.</div>
  <?php else: foreach ($popular as $p): ?>
    <a class="card" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">
      
      <!-- Thumbnail + Premium Lock -->
      <div class="thumb-box">
        <img class="thumb" src="<?php echo htmlspecialchars($p['thumb']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
        <?php if (!empty($p['premium']) && !empty($p['price'])): ?>
          <div class="lock-overlay">
            <span class="lock-icon">⭐ Premium</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Body -->
      <div class="body">
        <div><?php echo htmlspecialchars($p['title']); ?></div>
        <div class="meta">
          <span><?php echo htmlspecialchars($p['category']); ?></span>
          <span>Views: <?php echo intval($p['views'] ?? 0); ?></span>
        </div>

        <!-- Price -->
        <?php if (!empty($p['premium']) && !empty($p['price'])): 
          $orig = $p['price'];
          $discounted = $orig - ($orig * $GLOBAL_DISCOUNT / 100);
        ?>
          <div class="price">
            <span class="old-price" style="text-decoration:line-through;color:#999;">₹<?= $orig ?></span>
            <span class="new-price" style="font-weight:bold;color:#e60023;">₹<?= $discounted ?></span>
          </div>
        <?php endif; ?>
      </div>

    </a>
  <?php endforeach; endif; ?>
</div>

<?php require_once __DIR__ . "/partials/footer.php"; ?>
