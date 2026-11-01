# 🌸 Blossom Flower Shop — Setup Guide

A complete online flower shop built with **PHP, MySQL (PDO), HTML5, CSS3, JavaScript, Bootstrap 5 and Font Awesome**, with four panels: **Guest, Customer, Admin, and Delivery Staff**.

This project has been fully tested end-to-end (syntax-checked across all 54 PHP files, and run against a live MySQL database covering guest browsing, registration/login, cart, wishlist, checkout, order placement, admin order assignment, and delivery status updates).

---

## 1. Requirements

- **XAMPP** (or any stack with PHP 7.4+/8.x, MySQL/MariaDB, and Apache) — download from https://www.apachefriends.org
- A modern browser

---

## 2. Folder Placement

1. Install and open **XAMPP**.
2. Locate your XAMPP `htdocs` folder:
   - Windows: `C:\xampp\htdocs\`
   - macOS: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`
3. Copy the entire `flower_shop` folder into `htdocs`, so you end up with:
   ```
   htdocs/
     └── flower_shop/
           ├── admin/
           ├── user/
           ├── delivery/
           ├── assets/
           ├── config/
           ├── includes/
           ├── database/
           ├── index.php
           └── ... (all other files)
   ```

---

## 3. Create the Database in phpMyAdmin

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Open your browser and go to **http://localhost/phpmyadmin**.
3. Click **New** (top-left) to create a database — OR simply skip this, because the SQL file below creates the database for you.
4. Click the **Import** tab at the top.
5. Click **Choose File** and select `flower_shop/database/flower_shop.sql`.
6. Scroll down and click **Go**.
7. You should now see a new database called **`flower_shop`** in the left sidebar with 15 tables (users, admins, delivery_staff, categories, products, product_images, cart, wishlist, orders, order_items, payments, reviews, enquiries, offers, notifications) — pre-loaded with sample categories, products, and demo accounts.

> If your MySQL `root` user has a password, or you're using a different username, update the credentials in `config/database.php` (see Step 4).

---

## 4. Configure the Database Connection

Open `flower_shop/config/database.php` and confirm/update:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'flower_shop');
define('DB_USER', 'root');
define('DB_PASS', '');   // add your MySQL password here if you have one

define('BASE_URL', 'http://localhost/flower_shop/');
```

If you placed the project in a differently-named folder, update `BASE_URL` to match.

---

## 5. Set Upload Folder Permissions

The `assets/uploads/` folder must be writable so the admin panel can upload flower/category images.

- **Windows (XAMPP):** usually works out of the box.
- **macOS/Linux:** run `chmod -R 777 flower_shop/assets/uploads` from a terminal if uploads fail.

---

## 6. Run the Project

Open your browser and visit:

```
http://localhost/flower_shop/
```

You should see the Blossom Flower Shop homepage with the hero banner, categories, best sellers, and featured products.

---

## 7. Demo Login Accounts

| Role | URL | Email | Password |
|---|---|---|---|
| **Customer** | `http://localhost/flower_shop/login.php` | `customer@blossom.com` | `customer123` |
| **Admin** | `http://localhost/flower_shop/admin/login.php` | `admin@blossom.com` | `admin123` |
| **Delivery Staff** | `http://localhost/flower_shop/delivery/login.php` | `delivery@blossom.com` | `delivery123` |

You can also register a brand-new customer account from the **Register** page.

---

## 8. Testing the Full Order Flow

1. Browse flowers as a guest, or log in as the demo customer.
2. Add a flower to your cart (or click **Buy Now** on a product page).
3. Go to **Cart → Checkout**, fill in the delivery address, choose a payment method (Cash on Delivery / UPI / Card — all are simulated, no real payment gateway), and place the order.
4. Log in as **Admin**, go to **Manage Orders**, and assign the order to the demo delivery staff member while updating its status.
5. Log in as **Delivery Staff**, go to **Assigned Orders**, and update the order through Processing → Shipped → Out for Delivery → Delivered.
6. Log back in as the customer and use **My Orders → Track Order** to see the live status timeline update.

---

## 9. Project Structure

```
flower_shop/
│
├── admin/                  # Admin panel (dashboard, CRUD, orders, reports...)
│   └── includes/           # Admin sidebar + layout footer
├── user/                   # Customer panel (cart, checkout, orders, profile...)
├── delivery/                # Delivery staff panel
│   └── includes/
├── assets/
│   ├── css/style.css       # Pink/white floral theme
│   ├── js/script.js        # AJAX cart/wishlist, toasts, quantity selectors
│   ├── images/
│   └── uploads/            # Uploaded product/category images land here
├── config/
│   └── database.php        # DB connection + BASE_URL config
├── includes/
│   ├── header.php / navbar.php / footer.php   # Guest/customer shared layout
│   ├── auth.php            # Session bootstrap, loads config + functions
│   ├── functions.php       # Helpers: e(), redirect(), csrf, price formatting...
│   └── product-card.php    # Reusable product card partial
├── database/
│   └── flower_shop.sql     # Full schema + sample data
├── index.php, about.php, products.php, product-details.php,
│   categories.php, search.php, contact.php, login.php,
│   register.php, logout.php
```

---

## 10. Key Features Implemented

- **Guest:** Home, About, Flowers/Products, Categories, Product Details, Search, Contact, Login, Register.
- **Customer:** Dashboard, browse/search/filter, product details with reviews, cart (AJAX add/update/remove), wishlist (AJAX toggle), checkout with address + COD/UPI/Card (simulated), order confirmation, order tracking (visual timeline), order history + cancel, profile edit, change password.
- **Admin:** Dashboard with live Chart.js sales & order-status charts, Categories CRUD (with image upload), Flowers CRUD (with image upload, discount pricing, featured/bestseller flags, stock), Order management (status update + delivery staff assignment), Customers (block/unblock), Payments log, Offers/discount codes, Contact enquiries, Review moderation, Sales reports by date range/category, Settings, Admin profile + password change.
- **Delivery Staff:** Dashboard with assigned/delivered/pending counts, Assigned Orders list with inline status updates, Order Details, Profile + password change.
- **Security:** Password hashing (bcrypt), CSRF tokens on all state-changing forms, prepared statements (PDO) everywhere, role-based session guards (`require_login`, `require_admin`, `require_delivery`) preventing cross-panel access.
- **Order flow:** Guest → Product → Login/Register → Add to Cart → Checkout → Address → Payment → Place Order → Order Confirmation → My Orders → Track Order → Admin assigns delivery staff → Delivery staff updates status → Customer sees live tracking.

---

## 11. Notes

- Payments are **simulated** for demo purposes — no real payment gateway is integrated. Swap in Razorpay/Stripe/PayU in `user/checkout.php` for production use.
- Product images fall back to a stock Unsplash floral photo if no image has been uploaded, so the site looks complete even before you upload real product photos via the admin panel.
- All navigation links are functional — there are no placeholder/dead buttons.
