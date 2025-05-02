# Laravel Livewire Task List

A simple and responsive task management application built with **Laravel** and **Livewire**. This project demonstrates the power of Livewire for building dynamic interfaces without writing custom JavaScript.

## 🚀 Features

- Add, edit, and delete tasks
- Real-time updates with Livewire
- Mark tasks as completed or active
- Responsive and clean UI
- Lightweight and fast

## 🛠️ Built With

- [Laravel](https://laravel.com/)
- [Livewire](https://livewire.laravel.com/)
- [Bootstrap](https://getbootstrap.com/) (optional: mention if you're using it)
- PHP 8+

## 📦 Installation

Make sure you have PHP, Composer, and Laravel installed.

```bash
# Clone the repository
git clone https://github.com/kemo-byte/Laravel-livewire-task-list.git

# Navigate into the project
cd Laravel-livewire-task-list

# Install dependencies
composer install

# Copy .env file and set your environment variables
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Serve the app
php artisan serve
