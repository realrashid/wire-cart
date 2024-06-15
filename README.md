# Getting Started with WireCart

Welcome to WireCart, a demo app showcasing the powerful features of the [Cart](https://github.com/realrashid/Cart) package for Laravel. Follow these steps to set up WireCart on your local machine and explore seamless shopping cart management:

## Step 1: Clone the Repository

Begin by cloning the WireCart repository. Open your terminal or command prompt and run the following command:

```bash
git clone https://github.com/realrashid/wire-cart.git
```

## Step 2: Install Dependencies

Navigate to the project directory and install the necessary dependencies using Composer and npm:

```bash
cd wire-cart
composer install && npm install && npm run build
```

## Step 3: Set Up Environment Variables

Copy the `.env.example` file and rename it to `.env`. Open the file and configure your database settings and other environment variables:

```bash
cp .env.example .env
```

## Step 4: Generate Application Key

Generate a unique application key:

```bash
php artisan key:generate
```

## Step 5: Migrate the Database

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

## Step 6: Seed the Database

Seed the database with initial data:

```bash
php artisan db:seed
```

## Step 7: Start the Application

Start the development server:

```bash
php artisan serve
```

## Step 8: Access the Application

Open your web browser and go to `http://localhost:8000` to access the WireCart demo app.

## Step 9: Explore and Test

WireCart demonstrates the capabilities of Cart for Laravel, offering features like flexible cart configuration, dynamic tax calculations, and intuitive API integration. Explore how Cart simplifies shopping cart operations and enhances user experience in your e-commerce applications.

> Note: Please remember that WireCart is a demo app for showcasing purposes and may not include full production-level functionality.
