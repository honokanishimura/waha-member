# Transformer Member Management System (Laravel Clone)

This project is a Laravel-based implementation of a full-featured member management system inspired by [Waha! Transformer](https://waha-transformer.com/).  
It faithfully recreates the UI and business logic of the actual system, with CSV batch processing, member registration, role-based control, and admin operations—all backed by a MySQL database via phpMyAdmin.



## Project Purpose

This system was developed to replicate the core functionality and UX of Waha Transformer’s member management interface in a full-stack Laravel environment.  
The project was built individually as a portfolio-grade application, simulating real-world internal business tools used by Japanese enterprise clients.

---

##  Key Features

- Full member list with status filtering (active, inactive, withdrawn, provisional)
- Member registration form with role, department, and contact fields
- Bulk registration via CSV upload
- CSV template download & validation
- Search and pagination of member list
- Last login & registration date tracking
- All records stored and managed via MySQL (phpMyAdmin)

---

## Tech Stack

| Layer       | Technology     |
|-------------|----------------|
| Framework   | Laravel 10     |
| Language    | PHP 8.x        |
| Database    | MySQL (phpMyAdmin for development) |
| Frontend    | Blade templating + Bootstrap |
| File upload | CSV Import via Laravel Excel |
| Architecture | MVC + Eloquent ORM |



## Screenshots

### Member List  
![Member List](https://github.com/user-attachments/assets/4c8eaf03-cb75-4cdd-8453-e93c9b86fdb3)


### Member Registration
![Register Mobile](https://github.com/user-attachments/assets/1341c32f-04e7-479b-bff2-b11377a2f89d)

### CSV Bulk Upload  
![CSV Upload](https://github.com/user-attachments/assets/1fdffab7-2521-42e1-896e-1a03d13d21fe)





##  Local Setup Instructions

```bash
git clone https://github.com/honokanishimura/waha-transformer-clone.git
cd waha-transformer-clone

cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
