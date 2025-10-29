# Student Course Hub – Combined Project

This project combines three contributions—backend, frontend and JavaScript/security—to create a complete **Student Course Hub** application.  It is built in PHP using a simple MVC structure and demonstrates a full set of features: programme browsing with search and filters, detailed programme pages with module toggles, student registration with automatic account creation and login, a personalised dashboard, admin tools for managing programmes and modules, and staff pages that show modules taught by a staff member and the programmes they impact.

## Features

### Student‑facing

- **Programme List:** A public page that lists all published programmes.  Students can **search** by name or description and **filter by level** (Undergraduate/Postgraduate).  The results update instantly on the client side using JavaScript.
  The page now includes a welcoming **hero section** with a tagline and a set of quick‑action tiles (login, sign up and explore).  A “Featured Programmes” area highlights the first three courses and there is an “Upcoming Events” list inspired by the original assignment prototype.  These enhancements make the homepage more engaging while retaining full functionality.
- **Programme Details:** Clicking on a programme shows its description, the programme leader, and a list of modules grouped by year.  Each year heading toggles the visibility of its module list.
- **Register Interest:** Prospective students can register their interest in a programme by providing their name, email, selected programme and password.  The form includes client‑side validation (required fields, email format, password matching, consent checkbox) and a CSRF token for security.  On submission the application creates a student account, records the interest, logs the student in and redirects them to their personal dashboard.
- **Student Login/Dashboard:** Students can log in with their email and password.  After authentication they see a dashboard listing all programmes they have registered interest in.  They can also log out from this page.
- **Staff List:** A public page lists all staff members with their names, emails and bios.
- **Staff Pages:** Two additional pages let anyone (or a logged‑in staff member in a more advanced implementation) see which modules a staff member teaches and how many modules they teach in each programme.  These pages are accessible via `index.php?page=staffModules&id=STAFF_ID` and `index.php?page=staffImpact&id=STAFF_ID`.

### Admin‑facing

- **Dashboard:** Administrators can log in (basic admin login not implemented in this version but can be added) and view a dashboard listing programmes.  They can add, edit, delete and publish/unpublish programmes, manage modules for each programme and view a mailing list of interested students.
- **Programme Modules:** Admins can assign modules to programmes (with a year), assign module leaders, see which modules are shared across multiple programmes and remove modules.  Delete actions include confirmation prompts to prevent accidental deletion.
- **Mailing List Export:** Admins can export the list of interested students as a CSV file.

### Security and Best Practices

- **Password Hashing:** Student passwords are hashed on registration using PHP’s `password_hash()` and verified with `password_verify()` on login.
- **Prepared Statements:** All database interactions use prepared statements via PDO to prevent SQL injection.
- **Output Escaping:** Data displayed in views is escaped with `htmlspecialchars()` to mitigate cross‑site scripting (XSS).
- **CSRF Protection:** Every form includes a CSRF token stored in the session and validated in the controller.  Requests with missing or invalid tokens are rejected.
- **Client‑side Validation and Sanitisation:** JavaScript validates required fields, email format, matching passwords and user consent.  Basic client‑side sanitisation normalises inputs before submission.
- **Confirmation Prompts:** Delete and toggle actions in the admin interface ask for confirmation via JavaScript `confirm()` dialogs to avoid accidental changes.

## Setup Instructions

1. **Requirements**
   - PHP 7.4 or later with PDO MySQL extension
   - MySQL or MariaDB server
   - A web browser

2. **Database Setup**
   - Import the `setup.sql` file to create the `student_course_hub` database and populate it with sample data:

     ```sh
     mysql -u your_username -p < setup.sql
     ```

   - The script creates tables for levels, staff, modules, programmes, programme–module mappings, students and interested students.  It also inserts a few example records so you can explore the app immediately.

3. **Configure Database Connection**
   - Open `config/db.php` and set your MySQL credentials:

     ```php
     <?php
     $host = 'localhost';
     $dbname = 'student_course_hub';
     $user = 'your_username';
     $pass = 'your_password';
     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     ```

   - Save the file.

4. **Run the Application**
   - From the project root directory run PHP’s built‑in server, pointing the document root at the `public` folder:

     ```sh
     php -S localhost:8000 -t public
     ```

   - Open your browser and navigate to `http://localhost:8000/index.php?page=programmes`.

5. **Exploring the Site**
   - Browse programmes using the search bar and level filter.
   - Click **View details** for a programme to see its modules by year.
   - Register your interest to create a student account and be redirected to your dashboard.
   - Log out and log back in via `http://localhost:8000/index.php?page=studentLogin`.
   - Visit the staff list at `http://localhost:8000/index.php?page=staff`.
   - To see staff pages, append a staff ID: `http://localhost:8000/index.php?page=staffModules&id=1` and `http://localhost:8000/index.php?page=staffImpact&id=1`.
   - Admin pages (programme management, mailing list, etc.) are accessible via query parameters such as `index.php?page=adminDashboard` (no admin authentication provided here but can be extended).

## Notes and Extensibility

- This project uses a manual MVC pattern: controllers in `app/controllers/`, models in `app/models/`, and views in `app/views/`.  The entry point (`public/index.php`) routes requests based on a `page` query parameter.
- For simplicity there is no autoloading or dependency management.  Additional controllers and models must be included manually at the top of `public/index.php`.
- If you wish to secure the admin interface, you can adapt the student login mechanism for admins—create an `Admins` table, hash passwords, implement a login form and protect admin routes with session checks.
- The staff backend provided here does not include authentication.  To restrict access you could implement a similar login flow or integrate with your institution’s single sign‑on system.
- CSS styling is intentionally minimal (`public/assets/css/site.css`) but the application structure allows you to integrate richer stylesheets.  Similarly, only one JavaScript file (`student.js`) is included; you can expand this or add separate scripts for the admin and staff interfaces.

We hope this combined project provides a solid foundation for further development.  Feel free to extend and adapt it to meet your specific requirements.