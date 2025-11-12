# Solar E-commerce

Welcome to **Solar E-commerce**, an online store specialized in selling solar energy products!  
This project is built using **PHP** and **MySQL** to provide a simple and secure shopping experience.
![Homepage](images/sad.jpg)


---

## Features

- Homepage displaying available products  
- User registration and login system  
- Product details page and add-to-cart functionality  
- Checkout and order processing  
- Order management and tracking  
- Responsive and attractive design using HTML & CSS  

---

## Technologies Used

- **PHP** – Backend development and database interaction  
- **MySQL** – Database for users, products, and orders  
- **HTML & CSS** – Frontend design  
- **JavaScript (optional)** – For enhanced user experience  

---

## Requirements

- A web server like **XAMPP**, **WAMP**, or **Laragon**  
- PHP 7.4 or higher  
- MySQL or MariaDB  

---

## How to Run

1. Download or clone the project into your local server folder (e.g., `htdocs` in XAMPP).  
2. Import the database file `shop_dbn.sql` into MySQL.  
3. Open the database configuration file (e.g., `config.php`) and update your credentials:

   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "solar_ecommerce";
