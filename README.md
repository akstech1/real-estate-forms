<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Laravel 10 Multilingual Admin Panel

A Laravel 10 application with a fully functional admin panel built with modern design and authentication.

## Features

- 🔐 **Authentication**: Built-in Laravel Breeze authentication
- 📊 **Admin Dashboard**: Statistics and overview
- 🎨 **Responsive Design**: Bootstrap 5 with custom styling
- 📱 **Mobile Friendly**: Responsive design for all devices

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Copy environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Configure your database in `.env` file

6. Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Default Login Credentials

After running the seeder, you can login with:
- **Email**: `admin@example.com`
- **Password**: `password`

## Usage

### Accessing the Application

- **Login Page**: `/` (redirects to `/login`)
- **Admin Dashboard**: `/admin` (requires authentication)
- **Profile**: `/profile` (requires authentication)



## File Structure

```
resources/
├── lang/
│   └── en/
│       └── admin.php          # English translations
└── views/
    ├── auth/                   # Authentication views (Breeze)
    └── admin/
        ├── layouts/
        │   └── app.blade.php  # Main admin layout
        └── admin/ # Admin panel views
    ├── dashboard.blade.php # Admin dashboard
    ├── layouts/
    │   └── app.blade.php # Admin layout with sidebar
    ├── banners/ # Banner management views
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── about/ # About Us management
        └── edit.blade.php

app/
├── Http/
│   ├── Controllers/
│   │   └── AdminController.php    # Admin functionality
│   └── Middleware/

database/
└── seeders/
    └── AdminUserSeeder.php        # Default admin user
```

## Middleware



## Controllers

### AdminController

Handles admin panel functionality:
- Dashboard statistics



## Routes

```php
// Root redirects to login
Route::get('/', function () {
    return redirect()->route('login');
});



// Dashboard routes (protected by auth) - Shows admin panel
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('index');
    
    // Home menu
    Route::prefix('home')->name('home.')->group(function () {
        // Banners
        Route::get('/banners', [AdminController::class, 'banners'])->name('banners');
        Route::get('/banners/create', [AdminController::class, 'createBanner'])->name('banners.create');
        Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
        Route::get('/banners/{banner}/edit', [AdminController::class, 'editBanner'])->name('banners.edit');
        Route::put('/banners/{banner}', [AdminController::class, 'updateBanner'])->name('banners.update');
        Route::delete('/banners/{banner}', [AdminController::class, 'deleteBanner'])->name('banners.delete');
        
        // About Us
        Route::get('/about', [AdminController::class, 'about'])->name('about');
        Route::put('/about', [AdminController::class, 'updateAbout'])->name('about.update');
    });
});

// Authentication routes (Breeze)
require __DIR__.'/auth.php';
```

## Customization

### Styling

The admin panel uses Bootstrap 5 with custom CSS and modern design principles.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
