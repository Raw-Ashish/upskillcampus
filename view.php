<?php
require_once __DIR__ . "/partials/header.php";
$slug = $_GET['slug'] ?? '';
$postsFile = __DIR__ . "/data/posts.json";
$posts = json_decode(file_get_contents($postsFile), true);
$post = null;
foreach($posts as $p){ if(($p['slug'] ?? '') === $slug){ $post = $p; break; }}

if(!$post){ echo "<div class='notice'>Post not found.</div>"; require_once __DIR__ . "/partials/footer.php"; exit; }

// premium gate
//if(!empty($post['premium']) && empty($_SESSION['premium'])){
//  echo "<div class='notice'><strong>Premium only.</strong> <a class='btn premium' href='/premium.php'>Unlock Premium</a></div>";
//  require_once __DIR__ . "/partials/footer.php"; exit;
//}

// increment views and persist
foreach($posts as &$p){ if(($p['slug'] ?? '') === $slug){ $p['views'] = intval($p['views'] ?? 0) + 1; } }
file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));

?>
<div class="content-wrap">
  <article>
    <div class="category-hero">
      <div class="bg" style="background-image:url('<?php echo htmlspecialchars($post['bg'] ?? ''); ?>')"></div>
      <div class="inner">
  <h1><?php echo htmlspecialchars($post['title']); ?></h1>
  <p><?php echo htmlspecialchars($post['description'] ?? ''); ?></p>

  <?php if (!empty($post['premium']) && !empty($post['price'])): 
    $orig = $post['price'];
    $discounted = $orig - ($orig * $GLOBAL_DISCOUNT / 100);
  ?>
    <p class="price">
      <span class="old-price" style="text-decoration:line-through;color:#999;">₹<?= $orig ?></span>
      <span class="new-price" style="font-weight:bold;color:#e60023;">₹<?= $discounted ?></span>
    </p>
  <?php endif; ?>
</div>

    </div>
    <div class="player">
  <?php if(!empty($post['premium'])): ?>
    <!-- Premium Preview -->
    <?php if(($post['type'] ?? '') === 'pdf'): ?>
      <img src="<?php echo htmlspecialchars($post['preview_thumb'] ?? $post['thumb']); ?>" 
           alt="Preview" 
           style="max-width:100%;border-radius:8px;">
    <?php else: ?>
      <video controls style="max-width:100%;border-radius:8px;">
        <source src="<?php echo htmlspecialchars($post['preview_video'] ?? $post['video_url']); ?>" type="video/mp4">
      </video>
    <?php endif; ?>

    <div style="margin-top:15px;text-align:center">
      <strong>This is a preview only.<br> all in 1 zip file </strong><br><br>
      <button class="btn premium" onclick="openPayment()">Buy Now</button>
    </div>
<?php else: ?>
    <!-- Normal Free Post -->
    <?php if(($post['type'] ?? '') === 'pdf'): ?> <iframe class="pdf" 
          src="/viewer.php?url=<?php echo urlencode($post['pdf_url']); ?>">
  </iframe> <?php else: ?> <video controls style="max-width:100%"> <source src="<?php echo htmlspecialchars($post['video_url']); ?>" type="video/mp4"> </video> <?php endif; ?> <?php endif; ?>



<!-- Payment Popup (Overlay) -->
<div id="paymentOverlay" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.7);z-index:1000;align-items:center;justify-content:center;">
  <div style="background:#fff;color:#000;width:80%;max-width:800px;display:flex;border-radius:10px;overflow:hidden;">
    
    <!-- Sidebar -->
    <div style="width:30%;background:#f4f4f4;padding:20px;">
      <h3>Payment Methods</h3>
      <ul style="list-style:none;padding:0;margin:0">
        <li><button onclick="showMethod('upi')">UPI</button></li>
        <li><button onclick="showMethod('binance')">Binance</button></li>
        <li><button onclick="showMethod('crypto')">Crypto Wallet</button></li>
      </ul>
    </div>

    <!-- Dynamic Details -->
    <div id="paymentDetails" style="flex:1;padding:20px;">
      <h3>Select a method</h3>
      <p>Details will appear here.</p>
    </div>

    <!-- Terms -->
    <div style="width:25%;background:#fafafa;padding:15px;font-size:12px;overflow:auto;">
      <h4>Terms & Conditions</h4>
      <p>No refunds. Payment verification may take time. Access will be given via Telegram or Email.</p>
    </div>
  </div>
</div>

<script>
function openPayment(){
  document.getElementById("paymentOverlay").style.display = "flex";
}
function showMethod(method){
  let box = document.getElementById("paymentDetails");
  if(method === "upi"){
    box.innerHTML = "<h3>Pay via UPI</h3><p>Scan this QR:</p><img src='/assets/qr.png' width='200'><p>or use UPI ID: <b>myupi@okbank</b></p>";
  }
  if(method === "binance"){
    box.innerHTML = "<h3>Binance Pay</h3><p>Wallet: <b>mybinance123</b></p>";
  }
  if(method === "crypto"){
    box.innerHTML = "<h3>Crypto Wallet</h3><p>BTC: <b>1Abc123...</b></p><p>ETH: <b>0xabc123...</b></p>";
  }
}
</script>

</div>




    <?php if (!empty($post['enable_buttons'])): ?>
  <div class="button-area" style="margin:20px 0; text-align:center">
    <?php if (!empty($post['button_text'])): ?>
      <p><?php echo nl2br(htmlspecialchars($post['button_text'])); ?></p>
    <?php endif; ?>

    <?php foreach (($post['buttons'] ?? []) as $b): ?>
      <a class="btn" style="display:inline-block;margin:5px;padding:10px 15px;background:#ff3e83;color:#fff;border-radius:6px;text-decoration:none" 
         href="<?php echo htmlspecialchars($b['url']); ?>" target="_blank">
        <?php echo htmlspecialchars($b['title']); ?>
      </a>
    <?php endforeach; ?>

    <div class="gif-box" style="margin-top:15px">
      <a href="YOUR_GLOBAL_REDIRECT_LINK" target="_blank">
        <img src="/assets/images/fixed.gif" alt="Promo GIF" style="max-width:100%;border-radius:8px">
      </a>
    </div>
  </div>
<?php endif; ?>



  </article>
  <aside class="sidebar">
    <div class="widget">
      <h4>Recent</h4>
      <?php $recent = array_slice(array_reverse($posts), 0, 6); foreach($recent as $rp): ?>
        <a class="item-sm" href="/view.php?slug=<?php echo urlencode($rp['slug']); ?>">
          <img src="<?php echo htmlspecialchars($rp['thumb']); ?>" alt="<?php echo htmlspecialchars($rp['title']); ?>">
          <div><?php echo htmlspecialchars($rp['title']); ?></div>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="widget">
      <h4>Popular</h4>
      <?php $popular = array_slice(array_values(array_filter($posts, fn($pp)=>!empty($pp['popular']))),0,6); foreach($popular as $pp): ?>
        <a class="item-sm" href="/view.php?slug=<?php echo urlencode($pp['slug']); ?>">
          <img src="<?php echo htmlspecialchars($pp['thumb']); ?>" alt="<?php echo htmlspecialchars($pp['title']); ?>">
          <div><?php echo htmlspecialchars($pp['title']); ?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </aside>
</div>
<?php require_once __DIR__ . "/partials/footer.php"; ?>
