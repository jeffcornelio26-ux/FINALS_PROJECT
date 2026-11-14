Integrative Programming Final Project - XAMPP setup
1. Copy this folder (integrative_final) into C:\xampp\htdocs\
2. Start Apache in the XAMPP Control Panel (no MySQL needed; Exercises 3 and 4 use SQLite).
3. Open http://localhost/integrative_final/
4. Make sure the data/ folder is writable (it stores app.sqlite and student_data.xml).
5. Midterm Exercises 1 and 2 are standalone pages in midterm/ex1/ and midterm/ex2/ (Ex 2 stores users in the PHP session, so no database; Font Awesome icons in Ex 1 load from a CDN).
6. Labs 2 and 3 call jsonplaceholder.typicode.com, so you need internet access.
To use MySQL instead, edit includes/db.php (instructions at the top of the file).
