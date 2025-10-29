<?php
require_once __DIR__ . "/../config.php";
if (empty($_SESSION['admin'])) { header('Location: /admin/'); exit; }

$cats = json_decode(file_get_contents(__DIR__ . '/../data/categories.json'), true);
$postsFile = __DIR__ . '/../data/posts.json';
$posts = file_exists($postsFile) ? json_decode(file_get_contents($postsFile), true) : [];

// Helper to flatten categories
function flatCats($cats) {
  $out = [];
  foreach ($cats as $c) {
    $out[] = ['slug' => $c['slug'], 'name' => $c['name']];
    foreach (($c['children'] ?? []) as $s) {
      $out[] = ['slug' => $s['slug'], 'name' => $c['name'].' / '.$s['name'], 'parent' => $c['slug']];
    }
  }
  return $out;
}
$flat = flatCats($cats);

// If editing existing post
$editing = false;
$editPost = null;
if (isset($_GET['id']) && isset($posts[$_GET['id']])) {
  $editing = true;
  $editPost = $posts[$_GET['id']];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo $editing ? "Edit Post" : "New Post"; ?></title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body class="container">
  <div class="hero">
    <h2><?php echo $editing ? "Edit Post" : "Create New Post"; ?></h2>
    <form method="post" action="/admin/save-post.php" style="display:grid;gap:10px;max-width:760px">
      <?php if ($editing): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
      <?php endif; ?>

      <input name="title" placeholder="Title" required
             value="<?php echo htmlspecialchars($editPost['title'] ?? ''); ?>">

      <input name="slug" placeholder="Slug (auto if empty)"
             value="<?php echo htmlspecialchars($editPost['slug'] ?? ''); ?>">

      <input name="thumb" placeholder="Thumbnail URL" required
             value="<?php echo htmlspecialchars($editPost['thumb'] ?? ''); ?>">

      <input name="bg" placeholder="Background image URL (for header)"
             value="<?php echo htmlspecialchars($editPost['bg'] ?? ''); ?>">

      <select name="category" required>
        <option value="">Choose category</option>
        <?php foreach ($flat as $c): ?>
          <option value="<?php echo htmlspecialchars($c['slug']); ?>"
            <?php if (($editPost['category'] ?? '') === $c['slug']) echo "selected"; ?>>
            <?php echo htmlspecialchars($c['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <textarea name="description" placeholder="Short description"><?php echo htmlspecialchars($editPost['description'] ?? ''); ?></textarea>
      <input name="tags_csv" placeholder="Tags (comma separated)"
             value="<?php echo htmlspecialchars($editPost['tags_csv'] ?? ''); ?>">

      <label><input type="checkbox" name="premium" value="1" onchange="togglePrice(this)"> Premium</label>
<div id="priceBox" style="display:none;">
  <label>Price (₹): <input type="number" name="price"></label>
</div>

<script>
function togglePrice(el){
  document.getElementById("priceBox").style.display = el.checked ? "block" : "none";
}
</script>


      <label><input type="checkbox" name="popular" value="1"
        <?php if (!empty($editPost['popular'])) echo "checked"; ?>> Mark as Popular?</label>

      <select name="type" required>
        <option value="pdf" <?php if (($editPost['type'] ?? '') === 'pdf') echo "selected"; ?>>PDF</option>
        <option value="video" <?php if (($editPost['type'] ?? '') === 'video') echo "selected"; ?>>Video</option>
      </select>

      <select name="delivery" required>
        <option value="embed" <?php if (($editPost['delivery'] ?? '') === 'embed') echo "selected"; ?>>Embed</option>
        <option value="direct" <?php if (($editPost['delivery'] ?? '') === 'direct') echo "selected"; ?>>Direct</option>
        <option value="premium" <?php if (($editPost['delivery'] ?? '') === 'premium') echo "selected"; ?>>Premium (locked)</option>
      </select>

      <input name="pdf_url" placeholder="PDF URL (if type=pdf)"
             value="<?php echo htmlspecialchars($editPost['pdf_url'] ?? ''); ?>">

      <input name="video_url" placeholder="Video URL (if type=video)"
             value="<?php echo htmlspecialchars($editPost['video_url'] ?? ''); ?>">

      <hr>
      <h3>Button Area</h3>
      <label><input type="checkbox" name="enable_buttons" value="1"
        <?php if (!empty($editPost['enable_buttons'])) echo "checked"; ?>> Enable Button Area?</label>
      <textarea name="button_text" placeholder="Optional text before buttons"><?php echo htmlspecialchars($editPost['button_text'] ?? ''); ?></textarea>

      <h4>Default Buttons</h4>
      <input name="button1_title" value="Download Link" readonly>
      <input name="button1_url" placeholder="Download Link URL"
             value="<?php echo htmlspecialchars($editPost['buttons'][0]['url'] ?? ''); ?>">

      <input name="button2_title" value="How to Open Link" readonly>
      <input name="button2_url" placeholder="How to Open Link URL"
             value="<?php echo htmlspecialchars($editPost['buttons'][1]['url'] ?? ''); ?>">

      <h4>Extra Buttons (optional)</h4>
      <div id="extraButtons">
        <?php if (!empty($editPost['buttons'])): ?>
          <?php foreach (array_slice($editPost['buttons'], 2) as $i => $btn): ?>
            <div>
              <input name="extra_buttons[<?php echo $i; ?>][title]" placeholder="Button Title" value="<?php echo htmlspecialchars($btn['title']); ?>">
              <input name="extra_buttons[<?php echo $i; ?>][url]" placeholder="Button URL" value="<?php echo htmlspecialchars($btn['url']); ?>">
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <button type="button" onclick="addButton()">+ Add More Button</button>

      <script>
      function addButton(){
        const div=document.getElementById('extraButtons');
        const i=div.children.length;
        div.insertAdjacentHTML('beforeend',`
          <div>
            <input name="extra_buttons[${i}][title]" placeholder="Button Title">
            <input name="extra_buttons[${i}][url]" placeholder="Button URL">
          </div>
        `);
      }
      </script>

      <button class="btn" type="submit">Save</button>
    </form>
  </div>
</body>
</html>
