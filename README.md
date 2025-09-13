# Course Creator Web App

**Laravel (Backend) + HTML/CSS  (Frontend)**

> A simple and efficient Course Creation Web App — allowing a Course to contain unlimited Modules, and each Module to contain unlimited Content. All data is stored properly in the database with frontend/backend validation and error handling.

---

## ✨ Overview

This project provides a Course Creation page where users can:

* Create courses (title, description, category, etc.)
* Add unlimited modules to each course
* Add unlimited content items inside each module (text, image, video, link, etc.)
* Store everything in a relational database (Course → Modules → Contents)
* Use a clean UI with dynamic add/remove functionality powered by JS/jQuery

---

## 🔧 Features

* Course CRUD (create, read — focus on create and view for this project)
* Unlimited modules per course
* Unlimited contents per module
* Nested UI: Course → Modules → Contents
* Frontend validation (required fields, basic formats)
* Backend validation (Laravel Form Requests)
* Database relationships with cascading deletes
* User-friendly error messages

---

## 🧩 Tech Stack

* Backend: PHP 8.1+, Laravel 12 (recommended)
* Frontend: HTML5, CSS3
* Database: MySQL / MariaDB
* Tools: Composer, NPM (optional for assets), Git

---

## 🗂 Database Schema (Recommended)

* `courses`:

  * id, title, slug, description, category, status, created\_at, updated\_at
* `modules`:

  * id, course\_id (FK), title, position, created\_at, updated\_at
* `contents`:

  * id, module\_id (FK), type (text/image/video/link), title, body, url, meta, position, created\_at, updated\_at

> Foreign keys: `modules.course_id` → `courses.id`, `contents.module_id` → `modules.id` (on delete cascade)

---

## ⚙️ Installation & Setup

1. **Clone repo**

git clone <your-repo-url>.git
cd <repo-folder>

2. **Install composer packages**

```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. **Configure `.env`**

* Set DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD (MySQL)

4. **Migrate & Seed (optional)**

```bash
php artisan migrate
php artisan db:seed # if seeders are included
```

5. **Serve app**

```bash
php artisan serve
```

---

## 🧭 Usage Flow

1. Visit **/courses/create** (route name as per setup).
2. Fill in course details (title, description, category).
3. Click **Add Module** → a new module form will appear.
4. Inside each module, click **Add Content** to add multiple types of content (text/image/video/link).
5. After filling in inputs, click **Save Course**.
6. Data will be validated and saved to the database (Course → Modules → Contents).

---

## 🛡 Validation & Error Handling

* **Frontend validation**: required fields, prevent empty inputs, basic URL checks
* **Backend validation**: Laravel FormRequest rules, for example:

```php
'course.title' => 'required|string|max:255',
'modules.*.title' => 'required|string|max:255',
'modules.*.contents.*.type' => 'required|in:text,image,video,link',
'modules.*.contents.*.url' => 'nullable|url',
```

* **Error handling**: Controllers use try/catch and DB transactions (`DB::transaction`) to ensure rollback on failure.

---

## 🧱 Backend Design Pattern

* Controller: `CourseController`

  * `create()` — show form
  * `store(StoreCourseRequest $request)` — validate & save
  * `show($id)` — view course (optional)

* Request: `StoreCourseRequest` centralizes validation.

* Models:

  * `Course` hasMany `Module`
  * `Module` belongsTo `Course` and hasMany `Content`
  * `Content` belongsTo `Module`

* Saving nested data inside transaction:

```php
DB::transaction(function () use ($data) {
    $course = Course::create($data['course']);
    foreach ($data['modules'] as $moduleData) {
        $module = $course->modules()->create($moduleData);
        foreach ($moduleData['contents'] as $contentData) {
            $module->contents()->create($contentData);
        }
    }
});
```

---

## 🧾 Frontend Implementation Notes

* Use jQuery/JS to dynamically add/remove modules and contents.
* Input naming should be array-based to allow nested data:

```html
<input name="course[title]" />
<input name="modules[0][title]" />
<input name="modules[0][contents][0][title]" />
<input name="modules[0][contents][0][type]" />
```

* Clear UI hierarchy: Course → Module → Content
* File uploads (images) via file input, validate size/type

---

## ✅ Example Routes (web.php)

```php
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
```

---

## 🧪 Testing

* Create courses with multiple modules and contents
* Check DB for correct FK relationships and cascade behavior
* Test frontend validation & backend validation rules

---

## 📁 Suggested Project Structure

```
app/Models/Course.php
app/Models/Module.php
app/Models/Content.php
app/Http/Controllers/CourseController.php
resources/views/courses/create.blade.php
public/js/course-create.js
database/migrations/*
```

---

## 👥 Contribution

* Fork the repo → create a feature branch → submit PR
* Use clear commit messages, include migrations/seeders if required

---


