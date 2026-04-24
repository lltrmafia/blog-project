Blog Project (Laravel + Vue + Inertia)
🚀 Установка
git clone https://github.com/lltrmafia/blog-project.git
cd blog-project

composer install
npm install

cp .env.example .env
php artisan key:generate

# настроить базу данных в .env

php artisan migrate --seed

php artisan serve
vite

📌 Стек
Laravel
Vue 3 (Options API)
Inertia.js
Tailwind CSS
👤 Авторизация

ADMIN
email: admin@gmail.com
password: 123123123

MANAGER
email: manager@gmail.com
password: 123123123
