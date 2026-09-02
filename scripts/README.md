# OdaKira Project Automation Scripts (Standalone - No XAMPP Required)

This directory contains standalone automation scripts to run the development web server and clean up the system without needing XAMPP or Apache.

---

## Script Index

| File | Type | Description |
| :--- | :--- | :--- |
| [`launch.bat`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/launch.bat) | **All-in-One Launcher & Setup** | Automatically detects or installs standalone PHP 8.x, configures `php.ini` extensions (`pdo_mysql`, `gd`, `mbstring`, `fileinfo`, `curl`, `openssl`), starts MySQL/Docker, imports database schema & seed data, starts the built-in development server from `src/` at `http://localhost:8000`, and opens the browser. |
| [`cleanup.bat`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/cleanup.bat) | **System Cleanup Utility** | Stops background PHP development servers, removes Docker containers, cleans temporary download caches in `%TEMP%`, and offers to remove portable runtime files to restore the system. |
| [`init_db.php`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/init_db.php) | **Database Provisioner** | Connects to MySQL, creates database `myblog_db`, and imports schema and seed data from `src/myblog_db.sql`. |
| [`router.php`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/router.php) | **Built-in Server Router** | Handles clean URL routing (`/home`, `/blogs`, `/login`, `/admin`) and static asset delivery from `src/` without needing Apache or `.htaccess`. |

---

## Quick Start

### 1. Launch the Website (Automatic Setup + Run)
Double-click [`launch.bat`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/launch.bat) or run from Command Prompt:

```cmd
scripts\launch.bat
```

The application will be live at: **[http://localhost:8000/home](http://localhost:8000/home)**

---

### 2. Clean Up the System
When you are finished testing and want to restore your system to normal:

Double-click [`cleanup.bat`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/cleanup.bat) or run from Command Prompt:

```cmd
scripts\cleanup.bat
```

---

## Alternative: Manual Commands

```bash
# 1. Provision database
php scripts/init_db.php

# 2. Start development server from src directory
php -S localhost:8000 -t src scripts/router.php
```
