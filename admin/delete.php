<?php
require_once __DIR__ . "/../config.php";
if(empty($_SESSION['admin'])){ header('Location: /admin/'); exit; }
$slug = $_GET['slug'] ?? '';
$postsFile = __DIR__ . '/../data/posts.json';
$posts = json_decode(file_get_contents($postsFile), true);
$posts = array_values(array_filter($posts, fn($p)=>($p['slug'] ?? '') !== $slug));
file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));
header('Location: /admin/dashboard.php');
