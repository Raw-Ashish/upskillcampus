<?php
$postsFile = __DIR__ . "/data/posts.json";
$posts = json_decode(file_get_contents($postsFile), true);
?>
<div class="grid">
  <?php if(empty($posts)): ?>
    <div class="notice">No posts yet.</div>
  <?php else: foreach ($posts as $p): ?>
    <a class="card" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">
      <div class="thumb-wrap">
  <img class="thumb" src="<?php echo htmlspecialchars($p['thumb']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
  <?php if (!empty($p['premium']) && !empty($p['price'])): ?>
    <span class="badge">Premium</span>
  <?php endif; ?>
</div>

      <div class="body">
        <div><?php echo htmlspecialchars($p['title']); ?></div>
        <div class="meta">
          <span><?php echo htmlspecialchars($p['category']); ?></span>
          <span>Views: <?php echo intval($p['views'] ?? 0); ?></span>
        </div>

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
