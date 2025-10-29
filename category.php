<?php
require_once __DIR__ . "/partials/header.php";
$slug = $_GET['slug'] ?? '';
$cats = json_decode(file_get_contents(__DIR__ . "/data/categories.json"), true);
$catMeta = null;
foreach($cats as $c){
  if($c['slug'] === $slug){ $catMeta = $c; break; }
  foreach(($c['children'] ?? []) as $child){
    if($child['slug'] === $slug){ $catMeta = $child + ['bg'=>$c['bg'], 'description'=>$c['description']]; break 2; }
  }
}
if(!$catMeta){ $catMeta = ['name'=>'Unknown','bg'=>'','description'=>'']; }

$posts = json_decode(file_get_contents(__DIR__ . "/data/posts.json"), true);
$filtered = array_values(array_filter($posts, fn($p) => ($p['category'] ?? '') === $slug || ($p['parentCategory'] ?? '') === $slug));
?>
<section class="category-hero">
  <div class="bg" style="background-image:url('<?php echo htmlspecialchars($catMeta['bg'] ?? ''); ?>')"></div>
  <div class="inner">
    <h1><?php echo htmlspecialchars($catMeta['name']); ?></h1>
    <p><?php echo htmlspecialchars($catMeta['description'] ?? ''); ?></p>

    <?php if(!empty($post['premium'])): 
  $orig = $post['price'];
  $discounted = $orig - ($orig * $GLOBAL_DISCOUNT / 100);
?>
  <p class="price">
    <span class="old-price">₹<?= $orig ?></span>
    <span class="new-price">₹<?= $discounted ?></span>
  </p>
<?php endif; ?>

  </div>
</section>

<div class="grid">
  <?php if(empty($filtered)): ?>
    <div class="notice">No posts in this category yet.</div>
  <?php else: foreach ($filtered as $p): ?>
    <a class="card" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">
      
      <!-- Thumbnail with lock overlay -->
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


</div>
<?php require_once __DIR__ . "/partials/footer.php"; ?>
