<?php
require_once __DIR__ . "/../config.php";
if (empty($_SESSION['admin'])) { header('Location: /admin/'); exit; }
$posts = json_decode(file_get_contents(__DIR__ . '/../data/posts.json'), true);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CMS Dashboard</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body class="container">
  <div class="hero">
    <h2>CMS Dashboard</h2>
    <p>
      <a class="btn" href="/admin/new-post.php">+ New Post</a> 
      <a class="btn" href="/index.php">View Site</a>
    </p>
  </div>
  <div class="grid">
    <?php foreach (array_reverse($posts, true) as $id => $p): ?>
      <div class="card">
        <img class="thumb" src="<?php echo htmlspecialchars($p['thumb']); ?>" alt="">
        <div class="body">
          <strong><?php echo htmlspecialchars($p['title']); ?></strong>
          <div class="meta">
            <span><?php echo htmlspecialchars($p['category']); ?></span>
            <span>Views: <?php echo intval($p['views'] ?? 0); ?></span>
          </div>
          <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap">
            <a class="btn" href="/view.php?slug=<?php echo urlencode($p['slug']); ?>">Open</a>
            <a class="btn" href="/admin/new-post.php?id=<?php echo $id; ?>">Edit</a>
            <a class="btn" href="/admin/delete.php?slug=<?php echo urlencode($p['slug']); ?>" onclick="return confirm('Delete this post?')">Delete</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
