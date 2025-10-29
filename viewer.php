<?php
// Get URL safely
$url = $_GET['url'] ?? '';
$url = filter_var($url, FILTER_SANITIZE_URL);

// Detect type
$isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $url);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  html, body {
    margin: 0;
    padding: 0;
    background: #000;
    overflow-x: hidden;
    text-align: center;
  }
  img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
  }
  iframe {
    border: 0;
    width: 100%;
    height: 100vh;
  }
</style>
</head>
<body>
<?php if ($isImage): ?>
  <!-- Render image fullscreen -->
  <img src="<?php echo htmlspecialchars($url); ?>" alt="Document Page">
<?php else: ?>
  <!-- Assume it's an embeddable PDF or iframe -->
  <iframe src="<?php echo htmlspecialchars($url); ?>"></iframe>
<?php endif; ?>
</body>
</html>
