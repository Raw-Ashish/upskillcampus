<?php
require_once __DIR__ . "/../config.php";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $password = $_POST['password'] ?? '';
  if($password === $PREMIUM_PASS){
    $_SESSION['admin'] = true;
    header('Location: /admin/dashboard.php');
    exit;
  } else {
    $err = "Wrong password.";
  }
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>CMS Login</title>
<link rel="stylesheet" href="/assets/css/style.css" /></head>
<body class="container">
  <div class="hero">
    <h2>CMS Login</h2>
    <form method="post" style="display:flex;gap:10px;margin-top:12px">
      <input type="password" name="password" placeholder="Enter CMS password" required style="padding:10px;border-radius:10px;border:1px solid #23233a;background:#10101a;color:#fff">
      <button class="btn" type="submit">Login</button>
    </form>
    <?php if(!empty($err)) echo "<p style='color:#ff7f7f;margin-top:10px'>$err</p>"; ?>
  </div>
</body></html>
