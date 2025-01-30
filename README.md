# Laravel Task Scheduler API  

## Overview  
This Laravel-based API allows scheduling and executing tasks. It provides endpoints to add tasks, update their status, and execute them while logging exceptions and sending email notifications upon execution.  

## Features  
- ✅ Schedule API requests with execution time  
- 🔄 Track task status (`completed`, `in queue`, `canceled`, `paused`)  
- 🛠️ Log exceptions in case of failures  
- 📧 Send email notifications upon execution  

## Installation  
```sh
git clone https://github.com/your-repo/scheduler-api.git
cd scheduler-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
