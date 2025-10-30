🚀 Lightweight Blog CMS with Premium Access

A Database-Free Content Management System

Project Status: Completed (Industrial Internship Project)

Detail

Status

Live Demo

[Insert Live Demo URL Here]

GitHub Repository

https://github.com/ashishrawat/upskillcampus

Final Report

[Internship Report PDF Link]

Technology Stack

PHP, JSON, HTML/CSS

✨ Overview

This project is a lightweight, database-free Content Management System (CMS) designed specifically for small-scale blogs and platforms hosted on resource-constrained environments (like free hosting).

The core innovation is replacing traditional SQL databases (like MySQL) with JSON file storage, managed securely via PHP's file handling functions. This simplifies deployment and drastically reduces hosting overhead.

A key feature is the Premium Access Module, which allows administrators to monetize content by restricting access to specific posts, making it a viable, industrial-relevant solution.

💡 Key Features & Industrial Relevance

Feature

Description

Industrial Relevance

Database-Free Architecture

All content (posts, settings) is stored and retrieved from a single JSON file.

Ideal for Microservices and Serverless/Edge architectures where lightweight persistence is prioritized over heavy database infrastructure.

Data Integrity (flock())

Implemented PHP's flock() (File Locking Protocol) to prevent concurrent write conflicts and data corruption during simultaneous Admin updates.

Demonstrates understanding of Concurrency and Data Durability—a critical issue in any real-time data environment.

Full CRUD Functionality

Admin panel supports Create, Read, Update, and Delete operations for posts.

Essential skill validation for any Full-Stack Developer role.

Premium Content Module

Posts can be flagged as premium, triggering server-side logic to display only a teaser unless a valid session token is detected.

Practical exposure to implementing Monetization and Access Control logic.

🛠️ Technology Stack

Component

Technology

Purpose

Backend Logic

PHP

Core application logic, file I/O, JSON encoding/decoding, and security controls.

Data Storage

JSON

Lightweight, human-readable data persistence (acting as the database).

Frontend

HTML, CSS (Vanilla)

User interface and admin forms.

⚙️ Installation and Setup

Prerequisites

A web server running PHP 7.4 or higher.

File system write permissions for the PHP script to access the data directory.

Steps

Clone the Repository:

git clone [https://github.com/ashishrawat/upskillcampus.git](https://github.com/ashishrawat/upskillcampus.git)
cd upskillcampus


Deployment: Place the project files onto your web server's public directory (e.g., htdocs or public_html).

Ensure Permissions: Verify that the PHP script has write access to the directory where the posts-data.json file is located (or will be created).

Access: Navigate to the project's root URL in your browser to view the blog. Navigate to /admin to access the Content Management interface.

🎯 Future Work Scope

Future enhancements to improve the scalability and robustness of the CMS include:

Payment Gateway Integration: Implementing a live payment service (e.g., Stripe) to replace the current token-based premium access simulation.

Data Structure Optimization: Refactoring the single JSON file structure into multiple files (one per post ID) to reduce JSON Parsing Latency and Memory Buffer requirements for large blogs.

User Roles: Introducing multi-user administration roles (Admin, Editor, Contributor).

Developed as an Industrial Internship Project by Ashish Rawat
In collaboration with UniConverge Technologies Pvt. Ltd. (UCT), Upskill Campus, and The IoT Academy.
