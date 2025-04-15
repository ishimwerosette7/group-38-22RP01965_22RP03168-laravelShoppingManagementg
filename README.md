# Stock Management System

A Laravel-based stock management system for managing shoes and clothes inventory, with separate interfaces for buyers and sellers.

## Features

### For Sellers
- Register as a seller with business details
- Add, update, and delete products (shoes and clothes)
- View all registered customers
- Track customer activities and login times
- Generate and download reports
- View purchase history

### For Buyers
- Register as a buyer
- Browse available products
- Make purchases with automatic 10% discount
- Choose from multiple payment methods
- Leave comments on orders
- View order history

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user (buyer or seller)
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user

### Products (Protected)
- `GET /api/products` - List all products
- `POST /api/products` - Create a new product (seller only)
- `PUT /api/products/{product}` - Update a product (seller only)
- `DELETE /api/products/{product}` - Delete a product (seller only)

### Orders (Protected)
- `GET /api/orders` - List user's orders (buyer only)
- `POST /api/orders` - Create a new order (buyer only)

### User Activities (Protected)
- `GET /api/user-activities` - List all user activities (seller only)
- `GET /api/user-activities/{user}` - Get activities for a specific user (seller only)

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## Database Structure

### Users Table
- id
- full_name
- email
- account_type (buyer/seller)
- phone_number
- address
- business_name (nullable)
- business_type (nullable)
- password
- timestamps

### Products Table
- id
- seller_id
- type (shoes/clothes)
- name
- description
- price
- quantity
- image
- timestamps

### Orders Table
- id
- buyer_id
- total_amount
- discount_amount
- payment_method
- payment_status
- comments
- timestamps

### Order Items Table
- id
- order_id
- product_id
- quantity
- price
- timestamps

### User Activities Table
- id
- user_id
- action
- details
- ip_address
- login_time
- timestamps

## Security Features
- Password hashing
- API token authentication
- Role-based access control
- Input validation
- CSRF protection
- XSS protection

## Payment Methods
- Airtel Money
- Cash
- Mobile Money
- Bank of Kigali (BK)
- Other payment methods can be added as needed
