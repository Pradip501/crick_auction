<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Step 1: Launch an EC2 Instance

-   Go to the AWS Management Console.
-   Launch a new EC2 instance with Ubuntu 22.04 (or any preferred version).
-   Choose an instance type (e.g., t2.micro for free tier).
-   Configure security groups :
    -   Allow SSH (port 22) for your IP.
    -   Allow HTTP (port 80) and HTTPS (port 443) for public access.
    -   Allow port 3306 if you plan to connect to a MySQL database remotely.

## Step 2: Connect to Your EC2 Instance

    ssh -i your-key.pem ubuntu@your-ec2-public-ip

## Step 3: Update and Install Required Packages

    sudo apt update && sudo apt upgrade -y
    sudo apt install -y apache2 unzip curl git

## Step 4: Install PHP & Required Extensions

    sudo apt install -y php-cli php-mbstring php-xml php-bcmath php-tokenizer php-zip php-curl php-common php-pdo php-mysql php-pear php-gd

**Verify PHP installation:**

    php -v

## Step 5: Install MySQL

    sudo apt install -y mysql-server
    sudo mysql_secure_installation

**Create a database and user:**

    sudo mysql -u root -p

    CREATE DATABASE crick_auction;
    CREATE USER 'crick_auction_user'@'localhost' IDENTIFIED BY 'your_password';
    GRANT ALL PRIVILEGES ON crick_auction.\* TO 'crick_auction_user'@'localhost';
    FLUSH PRIVILEGES;
    EXIT;

## Step 6: Install Composer

    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    composer -V

## Step 7: Clone or Upload Laravel Project

    cd /var/www/html
    git clone https://github.com/Pradip501/crick_auction.git
    cd crick_auction

**Or manually upload files using SFTP.**

## Step 8: Configure Laravel

    sudo cp .env.example .env
    sudo vim .env

**Update the database settings:**

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE="crick_auction"
    DB_USERNAME="crick_auction_user"
    DB_PASSWORD="your_password"

## Step 9: Install Dependencies & Set Permissions

    composer install --no-dev --optimize-autoloader
    php artisan key:generate

**Set correct permissions:**

    sudo chown -R www-data:www-data /var/www/html/laravel-project
    sudo chmod -R 775 /var/www/html/laravel-project/storage /var/www/html/laravel-project/bootstrap/cache

## Step 10: Run Migrations & Seed Data

    php artisan migrate --seed

## Step 11: Configure Apache for Laravel

**Create a new virtual host configuration file:**

    sudo nano /etc/apache2/sites-available/laravel.conf

**Add the following:**

    <VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/crick_auction/public

        <Directory /var/www/html/crick_auction>
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>

**Enable the configuration:**

    sudo a2ensite laravel.conf
    sudo a2enmod rewrite
    sudo systemctl restart apache2

## Step 12: Restart Services & Test

    sudo systemctl restart apache2

Visit http://your-ec2-public-ip in a browser.

## Disable Directory Listing

**To prevent users from seeing your project files:**

**Open the Apache configuration file**

    sudo vim /etc/apache2/apache2.conf

**Find this section:**

    <Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
    </Directory>

**Change Options Indexes FollowSymLinks to Options -Indexes +FollowSymLinks**

    <Directory /var/www/>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

**Save and exit the file.**

**clearing the cache:**

    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear

## Step 1: Disable the Default Apache Site

**Run the following command to check enabled sites:**

    ls /etc/apache2/sites-enabled/

**You should see laravel.conf (or your custom config file). If it’s missing, enable it manually:**

    sudo a2ensite laravel.conf
    sudo systemctl restart apache2

## Step 2: Check the Document Root

**Run this command to verify the content inside /var/www/html/:**

    ls -lah /var/www/html/crick_auction/

**Make sure you see the public folder inside it. If it’s missing, your Laravel project might not be properly placed.**

**You can also try setting the correct ownership and permissions:**

    sudo chown -R www-data:www-data /var/www/html/crick_auction
    sudo chmod -R 775 /var/www/html/crick_auction/storage /var/www/html/crick_auction/bootstrap/cache

**Restart Apache again:**

    sudo systemctl restart apache2

## Step 3: Check Apache’s Running Sites

    sudo apachectl -S

It should show your virtual host configuration. If you see the default Apache configuration as active, that means your custom configuration is not being used.

## Step 4: Clear Apache Cache & Laravel Cache

    sudo systemctl restart apache2
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear

Now, try accessing http://3.95.134.195/ again.

**Install the PHP 8.3 Apache Module (If Missing)**

    sudo apt update
    sudo apt install libapache2-mod-php8.3

    sudo a2enmod php8.3

**And restart Apache:**

    sudo systemctl restart apache2

**Verify the PHP Module is Enabled**

**Check the loaded modules:**

    apachectl -M | grep php

**You should see something like:**

    php8.3_module (shared)

**Restart Apache**

    sudo systemctl restart apache2

