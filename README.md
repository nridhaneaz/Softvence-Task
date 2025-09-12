Course Creator - Laravel + jQuery

A dynamic course creation platform built with Laravel for the backend and HTML/CSS + jQuery for the frontend. Users can create courses with multiple modules, each containing multiple content items (text, video, image, or external link).

Features
Frontend

Dynamic course form with modules and contents.

Add/remove modules and contents on the fly.

Content type selection toggles between text and media input fields.

Smooth animations for adding/removing items.

Frontend validation for required fields (course title, module title, content title, media URL for non-text contents).

Modern, responsive UI with cards, colored borders, and clean typography.

Backend

Built with Laravel (Controllers, Requests, Models).

Store courses, modules, and contents in MySQL.

Validates incoming data with Form Requests.

Handles dynamic nested inputs for modules and contents.

Ready for extension to edit/delete courses or integrate with a dashboard.

Tech Stack

Backend: PHP 8+, Laravel 11

Frontend: HTML5, CSS3, jQuery

Database: MySQL

Optional: Tailwind CSS (can replace inline CSS for cleaner design)




Install dependencies

composer install



Set up environment

cp .env.example .env
php artisan key:generate


Configure database
Update .env with your MySQL credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=course_creator
DB_USERNAME=root
DB_PASSWORD=


Run migrations

php artisan migrate


Run the development server

php artisan serve


Frontend assets
No special build required for jQuery frontend; the scripts are included in Blade files. If using npm/Tailwind, run:

npm run dev

Usage

Open the app in your browser:

http://127.0.0.1:8000/courses/create


Create a course:

Enter Course Title, Description, Category.

Click Add Module to create a module.

Inside each module, click Add Content.

Choose Content Type: text, video, image, or link.

Enter Content Title and either Body or Media URL.

Repeat for multiple modules/contents.

Click Save Course.
<img width="1024" height="1024" alt="roberw" src="https://github.com/user-attachments/assets/535c2d1a-31d0-4602-97a8-25ff7be38a61" />

