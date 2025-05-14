# How to Run OdaKira Blog Website Using XAMPP

## Introduction
XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends, consisting mainly of the Apache HTTP Server, MariaDB database, and interpreters for scripts written in the PHP and Perl programming languages.

This guide will walk you through the steps to set up and run a PHP blog website locally on your computer using XAMPP.

## Prerequisites
- A computer with Windows, macOS, or Linux.
- Basic understanding of PHP and MySQL.
- XAMPP installed on your computer. You can download it from [Apache Friends](https://www.apachefriends.org/index.html).

## Steps

### 1. Install XAMPP
1. Download XAMPP from the [Apache Friends website](https://www.apachefriends.org/index.html).
2. Follow the installation instructions specific to your operating system.
3. Launch the XAMPP Control Panel and start the Apache and MySQL services.

### 2. Set Up Your Database
1. Open your browser and go to `http://localhost/phpmyadmin/`.
2. Click on the "Databases" tab.
3. Create a new database for your blog (e.g., `blogdb`).

### 3. Download or Create Your Blog Files
1. If you have an existing PHP blog, copy the files into a new directory within the `htdocs` directory of your XAMPP installation (e.g., `C:\xampp\htdocs\blog`).
2. If you don't have a blog, you can use a simple example provided below.

Configure Your Database
Navigate back to phpMyAdmin (http://localhost/phpmyadmin/).

Select your blogdb database.

Create a new table named posts with the following columns:

id (INT, AUTO_INCREMENT, PRIMARY KEY)

title (VARCHAR, 255)

content (TEXT)

Insert sample data into the posts table.

5. Access Your Blog
Open your browser and go to http://localhost/blog/.

You should see the blog page displaying the posts from your database.

Troubleshooting
Port Issues: If Apache won't start, check if another application is using port 80. You can change the port in the XAMPP Control Panel by clicking 'Config' next to Apache and editing the httpd.conf file.

Database Connection: Ensure your MySQL service is running and the database credentials in your PHP file are correct.

Permissions: Ensure your htdocs folder and its contents have the correct permissions for Apache to read them.
