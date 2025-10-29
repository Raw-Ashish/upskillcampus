<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../config.php";
if(empty($_SESSION['admin'])){ header('Location: /admin/'); exit; }

function slugify($text){
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/','-',$text);
    $text = trim($text,'-');
    if($text===''){ $text = 'post-' . time(); }
    return $text;
}

// Collect POST data
$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$thumb = trim($_POST['thumb'] ?? '');
$bg = trim($_POST['bg'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$tags_csv = trim($_POST['tags_csv'] ?? '');
$type = $_POST['type'] ?? 'pdf';
$delivery = $_POST['delivery'] ?? 'embed';
$pdf_url = trim($_POST['pdf_url'] ?? '');
$video_url = trim($_POST['video_url'] ?? '');
$premium = !empty($_POST['premium']);
$enable_buttons = !empty($_POST['enable_buttons']);
$button_text = trim($_POST['button_text'] ?? '');

$premium = !empty($_POST['premium']);
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0; // NEW


// Buttons
$buttons = [];
if (!empty($_POST['button1_url'])) $buttons[] = ["title"=>"Download Link","url"=>$_POST['button1_url']];
if (!empty($_POST['button2_url'])) $buttons[] = ["title"=>"How to Open Link","url"=>$_POST['button2_url']];
if (!empty($_POST['extra_buttons']) && is_array($_POST['extra_buttons'])){
    foreach($_POST['extra_buttons'] as $btn){
        if(!empty($btn['title']) && !empty($btn['url'])){
            $buttons[] = ["title"=>$btn['title'], "url"=>$btn['url']];
        }
    }
}

if($title==='' || $thumb==='' || $category===''){
    die("Missing required fields.");
}

if($slug===''){ $slug = slugify($title); }

// Determine parent category
$cats = json_decode(file_get_contents(__DIR__ . '/../data/categories.json'), true);
$parentCategory = '';
foreach($cats as $c){
    if($c['slug']===$category){ $parentCategory = ''; break; }
    foreach(($c['children'] ?? []) as $s){
        if($s['slug']===$category){ $parentCategory = $c['slug']; break 2; }
    }
}

$postsFile = __DIR__ . '/../data/posts.json';
$posts = file_exists($postsFile) ? json_decode(file_get_contents($postsFile), true) : [];

if($id !== null && isset($posts[$id])){
    // Update existing post by ID
    $posts[$id] = array_merge($posts[$id], [
    "title"=>$title,
    "slug"=>$slug,
    "thumb"=>$thumb,
    "bg"=>$bg,
    "category"=>$category,
    "parentCategory"=>$parentCategory,
    "description"=>$description,
    "tags_csv"=>$tags_csv,
    "type"=>$type,
    "delivery"=>$delivery,
    "pdf_url"=>$pdf_url,
    "video_url"=>$video_url,
    "premium"=>$premium,
    "price"=>$price, // NEW
    "enable_buttons"=>$enable_buttons,
    "button_text"=>$button_text,
    "buttons"=>$buttons,
]);
} else {
    // Create new post
    $posts[] = [
    "title"=>$title,
    "slug"=>$slug,
    "thumb"=>$thumb,
    "bg"=>$bg,
    "category"=>$category,
    "parentCategory"=>$parentCategory,
    "description"=>$description,
    "tags_csv"=>$tags_csv,
    "type"=>$type,
    "delivery"=>$delivery,
    "pdf_url"=>$pdf_url,
    "video_url"=>$video_url,
    "premium"=>$premium,
    "price"=>$price, // NEW
    "views"=>0,
    "created_at"=>date('c'),
    "enable_buttons"=>$enable_buttons,
    "button_text"=>$button_text,
    "buttons"=>$buttons,
];

}

file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));
header('Location: /admin/dashboard.php');
exit;
