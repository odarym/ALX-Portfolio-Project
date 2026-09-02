# OdaKira Blog & CMS Platform

**OdaKira** is a dynamic blog and Content Management System (CMS) web application built with **PHP 8.x**, **MySQL/MariaDB**, and **Bootstrap 5.3**. It features front-controller routing, secure user authentication, role-based administration, image processing utilities, and a fully responsive theme supporting both **Light Mode** and **Dark Mode**.

---

## Getting Started / Setup

You can run OdaKira either **standalone using automated scripts (no XAMPP required)** or **using an existing XAMPP installation**.

---

### Option 1: Standalone Setup via Scripts *(Recommended - No XAMPP Required)*

OdaKira includes an all-in-one launcher script in the [`scripts/`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts) directory that sets up standalone PHP, configures extensions, provisions the database, and launches PHP's built-in development server.

#### Launching the Website
Double-click [`scripts/launch.bat`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/launch.bat) or run from your terminal:

```cmd
scripts\launch.bat
```

*This automatically:*
1. Detects or downloads official standalone **PHP 8.3** (if missing).
2. Configures required PHP extensions (`pdo_mysql`, `gd`, `mbstring`, `fileinfo`, `curl`, `openssl`).
3. Connects to MySQL/MariaDB and imports schema & seed data from [`src/myblog_db.sql`](file:///C:/dev/alx/ALX-Portfolio-Project/src/myblog_db.sql).
4. Starts the local development web server from `src/` and opens **[http://localhost:8000/home](http://localhost:8000/home)** in your browser.

---

### Option 2: Using XAMPP *(If already installed)*

If you already have XAMPP installed on your computer, you can run the project using Apache and MySQL:

#### Step 1: Place Project in `htdocs`
Copy or clone this repository into your XAMPP web root directory:
```
C:\xampp\htdocs\odakira
```

#### Step 2: Start Apache and MySQL
Open the **XAMPP Control Panel** and click **Start** next to both **Apache** and **MySQL**.

#### Step 3: Import the Database
1. Open your browser and go to `http://localhost/phpmyadmin/`.
2. Create a new database named `myblog_db`.
3. Select the `myblog_db` database and click the **Import** tab.
4. Choose the SQL dump file located at `src/myblog_db.sql` and click **Import**.

#### Step 4: Access the Website
Open your browser and navigate to:
```
http://localhost/odakira/src/home
```

---

## System Cleanup

When you are done testing and want to stop running servers, clean temporary caches, and restore your system to its original state:

Double-click [`scripts/cleanup.bat`](file:///C:/dev/alx/ALX-Portfolio-Project/scripts/cleanup.bat) or run from your terminal:

```cmd
scripts\cleanup.bat
```

---

## Project Structure

```
ALX-Portfolio-Project/
├── LICENSE                            # MIT License
├── README.md                          # Project documentation and setup guide
├── src/                               # Main Application Source Code
│   ├── index.php                      # Front controller & dynamic router
│   ├── home.php                       # Homepage view with carousel
│   ├── blogs.php                      # Interactive blog showcase
│   ├── login.php                      # User login view & authentication
│   ├── signup.php                     # User registration view
│   ├── admin.php                      # Admin dashboard (protected by RBAC)
│   ├── logout.php                     # Session termination & logout handler
│   ├── 404.php                        # Error fallback view
│   ├── myblog_db.sql                  # Database schema dump & seed records
│   ├── core/                          # Backend business logic
│   │   ├── config.php                 # Dynamic ROOT base URL configuration
│   │   ├── init.php                   # Session bootstrap & core loader
│   │   ├── functions.php              # Query helpers, sanitization, image utilities
│   │   └── db/
│   │       └── conn.php               # Database connection parameters
│   ├── includes/                      # Reusable UI component partials
│   │   ├── header.php                 # Global navigation bar & theme switcher
│   │   └── footer.php                 # Global theme-responsive footer
│   └── assets/                        # Static assets (CSS, JS, Fonts, Sliders)
└── scripts/                           # Standalone automation & launcher tools
    ├── launch.bat                     # All-in-one setup, DB provisioner, and server runner
    ├── cleanup.bat                    # System cleanup and process termination utility
    ├── init_db.php                    # Portable database provisioning script
    ├── router.php                     # Built-in PHP server URL router
    └── README.md                      # Scripts documentation
```

---

## Key Features

* **Light & Dark Mode**: Full Bootstrap 5.3 dark-mode support across all pages (Home, Blogs, Login, Sign Up, Admin).
* **Dynamic Front Controller**: Clean URL routing through [`src/index.php`](file:///C:/dev/alx/ALX-Portfolio-Project/src/index.php).
* **Database Abstraction Layer**: Secure parameterized queries using PHP PDO (`query()`, `query_row()`).
* **Authentication & RBAC**: Secure password hashing (`bcrypt`), session management, and admin route protection.
* **Image Processing**: Automatic thumbnail generation and sanitization for rich text uploads.

---

## Default Database Accounts

The sample database dump (`src/myblog_db.sql`) includes pre-seeded working test accounts:

| Role | Username | Email | Password | Access Level |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | `Admin` | `admin@odakira.com` | `password` | Full access (can view `/admin` dashboard) |
| **Admin** | `alisha` | `alisha@email.com` | `password` | Full access (can view `/admin` dashboard) |
| **User** | `Eathorne` | `email@email.com` | `password` | Standard user account |
| **User** | `Edd` | `ed@email.com` | `password` | Standard user account |
| **User** | `Mary` | `mary@email.com` | `password` | Standard user account |


---

## License

This project is licensed under the terms specified in the [LICENSE](LICENSE) file.
