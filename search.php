<?php
$pageTitle = "Search";
require_once __DIR__ . "/partials/header.php";
$q = strtolower(trim($_GET['q'] ?? ''));
$posts = json_decode(file_get_contents(__DIR__ . "/data/posts.json"), true);
$results = [];
if($q !== ''){
  foreach($posts as $p){
    $hay = strtolower(($p['title'] ?? '') . ' ' . ($p['description'] ?? '') . ' ' . ($p['tags_csv'] ?? ''));
    if(strpos($hay, $q) !== false){ $results[] = $p; }
  }
}
?>
<h2>Search results for: "<?php echo htmlspecialchars($q); ?>"</h2>
<div class="grid">
  <?php if(empty($results)): ?>
    <div class="notice">No results.</div>
  <?php else: foreach ($results as $p): ?>
    <a class="card" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">
      <img class="thumb" src="<?php echo htmlspecialchars($p['thumb']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
      <div class="body">
        <div><?php echo htmlspecialchars($p['title']); ?></div>
        <div class="meta"><span><?php echo htmlspecialchars($p['category']); ?></span><span>Views: <?php echo intval($p['views'] ?? 0); ?></span></div>
      </div>
    </a>
  <?php endforeach; endif; ?>
</div>
<?php require_once __DIR__ . "/partials/footer.php"; ?>
