<?php
require_once __DIR__ . "/partials/header.php";

$postsFile = __DIR__ . "/data/posts.json";
$posts = json_decode(file_get_contents($postsFile), true);

// filter only premium posts
$premiumPosts = array_filter($posts, function($p) {
    return !empty($p['premium']) && !empty($p['price']);
});
?>

<div class="category-hero">
  <div class="inner">
    <h1>Premium Comics</h1>
    <p>Exclusive paid comics with special discounted prices.</p>
  </div>
</div>

<div class="grid">
  <?php if(empty($premiumPosts)): ?>
    <div class="notice">No premium comics available.</div>
  <?php else: foreach ($premiumPosts as $p): ?>
    <a class="card" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">
      
      <!-- Thumbnail with Premium badge -->
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

        <?php 
          $orig = $p['price'];
          $discounted = $orig - ($orig * $GLOBAL_DISCOUNT / 100);
        ?>
        <div class="price">
          <span class="old-price" style="text-decoration:line-through;color:#999;">₹<?= $orig ?></span>
          <span class="new-price" style="font-weight:bold;color:#e60023;">₹<?= $discounted ?></span>
        </div>
      </div>
    </a>
  <?php endforeach; endif; ?>
</div>

<?php
require_once __DIR__ . "/partials/footer.php";
?>
