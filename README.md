# AgriConnect - Farm to Consumer Marketplace

<div align="center">

![AgriConnect](https://img.shields.io/badge/AgriConnect-Laravel%2012-green)
![PHP Version](https://img.shields.io/badge/PHP-%5E8.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Active-brightgreen)

A modern web application connecting local farmers directly with consumers for fresh, organic, and sustainable agricultural products.

[Features](#features) • [Installation](#installation) • [Usage](#usage) • [Database](#database) • [Admin Panel](#admin-panel)

</div>

---

## 📋 Overview

**AgriConnect** is a comprehensive farm-to-consumer marketplace built with Laravel 12. It enables local farmers to list and manage their products while allowing consumers to discover, browse, and purchase fresh agricultural goods directly from source. The platform also features a community section where customers can meet the farmers behind their produce.

### Core Purpose
- **Connect Farmers & Consumers** - Create direct marketplace relationships
- **Sustainable Agriculture** - Promote organic and locally-grown products  
- **Farm Management** - Easy product and farmer profile management
- **Shopping Experience** - Intuitive cart and checkout system

---

## ✨ Features

### 🏠 **Frontend Features**
- **Homepage** with featured products and promotions
- **Products Catalog** - Browse by category with detailed product information
- **Community Section** - Meet local farmers and their stories
- **Shopping Cart** - Frontend-only cart management (JavaScript-based)
- **Checkout System** - Complete purchase flow with order tracking
- **About & Contact** - Learn more and reach out
- **Responsive Design** - Mobile-friendly Bootstrap 5 UI

### 🛠️ **Admin Panel**
- **Dashboard** - Overview of products, farmers, and statistics
- **Product Management** - Full CRUD operations
  - Add, edit, view, and delete products
  - Upload product images (JPG, PNG, WebP - max 1MB)
  - Manage stock quantities and status
  - Track harvest dates and organic certification
  - Associate products with farmers
  
- **Farmer Management** - Complete farmer CRUD
  - Manage farmer profiles with profile images
  - Track farm name, location, and contact info
  - Add farmer biography and specialization
  - View associated products per farmer
  - Activate/deactivate farmer listings

### 📊 **Data Features**
- **Real-Time Database Integration** - All data pulled from MySQL database
- **Product Categories** - Vegetables, Fruits, Dairy, Grains, Eggs, Honey, Meat
- **Farmer Profiles** - Complete profiles with images and contact information
- **Order Management** - Track customer orders and inventory
- **Image Optimization** - Support for JPG, PNG, WebP formats with compression

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Framework** | Laravel 12 |
| **Language** | PHP 8.2+ |
| **Database** | MySQL/MariaDB 10.4.32 |
| **Frontend** | Bootstrap 5, JavaScript, Tailwind CSS |
| **Template Engine** | Blade |
| **ORM** | Eloquent |
| **Build Tool** | Vite |
| **Package Manager** | Composer, NPM |

---

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/MariaDB (port 3308)
- XAMPP or similar local environment

### Setup Steps

1. **Clone the Repository**
```bash
git clone https://github.com/devd-328/SCD-Project.git
cd SCD-Project-main
```

2. **Install PHP Dependencies**
```bash
composer install
```

3. **Configure Environment**
```bash
cp .env.example .env
```
Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=agriconnect
DB_USERNAME=root
DB_PASSWORD=
```

4. **Generate Application Key**
```bash
php artisan key:generate
```

5. **Run Database Migrations**
```bash
php artisan migrate
```

6. **Seed Initial Data (Admin User)**
```bash
php artisan db:seed --class=AdminUserSeeder
```

7. **Install Frontend Dependencies**
```bash
npm install
npm run build
```

8. **Create Required Directories**
```bash
mkdir -p public/assets/images/{products,farmers}
chmod -R 755 public/assets/images storage
```

9. **Start Development Server**
```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000`

---

## 🚀 Usage

### **Admin Access**
- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@example.com`
- **Password**: `password`

### **Admin Sections**

#### Dashboard (`/admin/dashboard`)
- Overview of all products and farmers
- Quick statistics and recent activity
- Quick action buttons for common tasks

#### Product Management (`/admin/products`)
- **View All Products** - List with pagination
- **Add Product** - Create new product with:
  - Name, description, category, price, unit
  - Stock quantity and harvest date
  - Organic certification toggle
  - Farmer association
  - Product image upload
- **Edit Product** - Modify product details and image
- **Delete Product** - Remove products from catalog

#### Farmer Management (`/admin/farmers`)
- **View All Farmers** - List with pagination and status
- **Add Farmer** - Create new farmer profile with:
  - Name, farm name, location
  - Contact information (phone, email)
  - Biography and specialization
  - Profile image upload
  - Status (active/inactive/pending)
  - User association (optional)
- **Edit Farmer** - Update farmer details
- **Delete Farmer** - Remove farmer profile
- **View Details** - See farmer info and associated products

---

## 📊 Database

### **Database Schema**

#### Users Table
```
- id (bigint, primary key)
- name (string)
- email (string, unique)
- password (string)
- is_admin (boolean)
- created_at, updated_at (timestamps)
```

#### Farmers Table
```
- id (bigint, primary key)
- user_id (bigint, nullable, foreign key)
- name (string)
- farm_name (string)
- location (string)
- bio (text, nullable)
- phone (string)
- email (string, nullable)
- profile_image (string, nullable)
- specialization (string, nullable)
- status (enum: active, inactive, pending)
- created_at, updated_at (timestamps)
```

#### Products Table
```
- id (bigint, primary key)
- farmer_id (bigint, foreign key)
- name (string)
- description (text, nullable)
- category (string)
- price (decimal 8,2)
- unit (string: kg, liter, dozen, piece, bundle, box)
- quantity_available (integer)
- image_path (string, nullable)
- status (string: active, inactive, out_of_stock)
- is_organic (boolean)
- harvest_date (date, nullable)
- created_at, updated_at (timestamps)
```

#### Orders & OrderItems Tables
```
- Orders: id, user_id, total_amount, status, created_at, updated_at
- OrderItems: id, order_id, product_id, quantity, price, created_at, updated_at
```

### **Key Relationships**
- **User → Farmer** (one-to-one, optional)
- **Farmer → Products** (one-to-many)
- **Product → OrderItems** (one-to-many)
- **Order → OrderItems** (one-to-many)

---

## 🎨 Frontend Routes

| Route | Description |
|-------|-------------|
| `/` | Homepage with featured products |
| `/about` | About AgriConnect |
| `/products` | Products catalog |
| `/community` | Meet our farmers |
| `/contact` | Contact form |
| `/cart` | Shopping cart |
| `/checkout` | Checkout page |

---

## 🔧 Admin Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/admin/dashboard` | GET | Admin dashboard |
| `/admin/products` | GET | Products list |
| `/admin/products/create` | GET | Create product form |
| `/admin/products` | POST | Store new product |
| `/admin/products/{id}` | GET | View product |
| `/admin/products/{id}/edit` | GET | Edit product form |
| `/admin/products/{id}` | PUT | Update product |
| `/admin/products/{id}` | DELETE | Delete product |
| `/admin/farmers` | GET | Farmers list |
| `/admin/farmers/create` | GET | Create farmer form |
| `/admin/farmers` | POST | Store new farmer |
| `/admin/farmers/{id}` | GET | View farmer |
| `/admin/farmers/{id}/edit` | GET | Edit farmer form |
| `/admin/farmers/{id}` | PUT | Update farmer |
| `/admin/farmers/{id}` | DELETE | Delete farmer |

---

## 📁 Project Structure

```
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── ProductController.php
│   │   │   │   └── FarmerController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   ├── FarmerController.php
│   │   │   ├── ContactController.php
│   │   │   └── CheckoutController.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Farmer.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   └── AdminUserSeeder.php
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── products/
│   │   │   ├── farmers/
│   │   │   └── layouts/
│   │   ├── farmers/
│   │   ├── products/
│   │   ├── home.blade.php
│   │   └── layouts/
│   ├── css/
│   ├── js/
│   └── components/
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   │       ├── products/
│   │       └── farmers/
│   └── index.php
├── .env.example
├── composer.json
├── package.json
└── vite.config.js
```

---

## 📝 Key Features Details

### **Image Upload & Management**
- Supported formats: JPG, JPEG, PNG, WebP
- Maximum file size: 1MB
- Automatic file naming with timestamps
- Images stored in:
  - Products: `public/assets/images/products/`
  - Farmers: `public/assets/images/farmers/`

### **Form Validation**
- All inputs validated server-side
- Error messages displayed to users
- Required fields marked with asterisks
- Real-time validation feedback

### **Frontend Cart System**
- JavaScript-based cart (no server session required)
- Local storage persistence
- Real-time cart updates
- Cart count displayed in navbar

---

## 🔐 Security Features

- **Admin Authentication** - Protected admin routes
- **Input Validation** - All user inputs validated
- **CSRF Protection** - Laravel CSRF tokens on forms
- **Password Hashing** - Secure password storage
- **File Upload Security** - Restricted to allowed formats/sizes
- **SQL Injection Prevention** - Eloquent ORM protection

---

## 📧 Contact & Support

- **Email**: info@agriconnect.pk
- **Phone**: +92 300 1234567
- **Address**: 123 Farm Road, Karachi, Pakistan
- **Hours**: Mon - Sat, 9AM - 6PM

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🎯 Future Enhancements

- [ ] Payment gateway integration (Stripe, JazzCash)
- [ ] User registration and profiles
- [ ] Order tracking system
- [ ] Review and ratings system
- [ ] Wishlist feature
- [ ] Email notifications
- [ ] SMS alerts for new products
- [ ] Analytics dashboard
- [ ] API for mobile app
- [ ] Multi-language support

---

## 👥 Project Team

**Developer**: [devd-328](https://github.com/devd-328)  
**Project**: AgriConnect - Sustainable Farm to Consumer Marketplace

---

**Last Updated**: December 3, 2025  
**Current Version**: 1.0.0  
**Status**: Active Development


