<?php
require_once __DIR__ . "/../config.php";
if(empty($_SESSION['admin'])){ header('Location: /admin/'); exit; }
$slug = $_GET['slug'] ?? '';
$postsFile = __DIR__ . '/../data/posts.json';
$posts = json_decode(file_get_contents($postsFile), true);
foreach($posts as &$p){ if(($p['slug'] ?? '') === $slug){ $p['popular'] = empty($p['popular']); } }
file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));
header('Location: /admin/dashboard.php');
