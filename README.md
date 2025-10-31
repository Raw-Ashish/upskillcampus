# 🧩 Content Management System (CMS) with Premium Access Feature

A lightweight, database-free **Content Management System (CMS)** built using **PHP, HTML, CSS, and JavaScript**, designed for small-scale blogs and websites hosted on **free servers** (like InfinityFree).  
This CMS uses **JSON files** instead of a traditional database, making it fast, portable, and easy to maintain — while also supporting **premium content access** for paid users.

---

## 🚀 Live Demo

🔗 **Demo URL:** [View Live Project](https://your-demo-link-here.com)


---

## 📖 Project Overview

This CMS allows admin users to **create, edit, and delete posts** from a dashboard interface.  
All post data is stored in a JSON file (`posts-data.js`) instead of MySQL.  
The frontend dynamically fetches and displays posts using JavaScript, while **premium posts** remain locked until unlocked through a **payment token**.

---

## 🧱 Core Features

✅ Admin dashboard to manage posts (title, description, category, and image).  
✅ Dynamic JSON-based data storage (no MySQL required).  
✅ Frontend fetches and displays posts automatically.  
✅ Premium content lock/unlock feature.  
✅ Category-wise and recent-post display.  
✅ Fully responsive design for mobile and desktop.  
✅ Lightweight — perfect for free hosting services like InfinityFree.

---

## 🧩 Architecture Overview

**1. Presentation Layer (Frontend):**
- HTML, CSS, and JavaScript
- Displays posts, handles interactions, and manages premium content lock/unlock UI.

**2. Application Layer (Backend):**
- PHP-based CMS logic (CRUD operations)
- Validates input, encodes data to JSON, and manages file operations.

**3. Data Layer (Storage):**
- `posts-data.js` stores all post metadata.
- Acts as a lightweight alternative to a database.

---

## 📂 Folder Structure

/cms-project
│
├── index.html                # Homepage (shows posts dynamically)
├── admin.php                 # Admin dashboard (form interface)
├── posts-data.js             # JSON file storing all posts
│
├── assets/
│   ├── css/                  # Stylesheets
│   ├── js/                   # Frontend scripts
│   └── images/               # Thumbnails / uploaded images
│
└── includes/
    └── functions.php         # PHP file handling logic

## 🧠 Technologies Used
Frontend: HTML5, CSS3, JavaScript  
Backend: PHP  
Storage: JSON File System  
Hosting: InfinityFree (Free PHP Hosting)

## 🌱 Future Enhancements
🔒 Payment Gateway Integration (Razorpay/Stripe)  
👥 Multi-Admin Role Management  
📊 Post Analytics Dashboard  
💾 Migration to MySQL or Firebase  
🛡️ Enhanced Security & Session Management

