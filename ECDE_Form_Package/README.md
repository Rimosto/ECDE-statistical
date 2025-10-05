ECDE Form Package

Files:
- index.php        -> form front-end (place in web root)
- process.php      -> form processor (handles DB inserts and file uploads)
- admin.php        -> simple admin dashboard with ward/subcounty summaries & charts
- db.sql           -> SQL file to create database and tables
- uploads/         -> folder for uploaded files (create and chmod 775)
- README.txt       -> this file

Setup:
1. Import db.sql into MySQL (e.g., via MySQL Workbench or `mysql < db.sql`).
2. Place index.php, process.php, admin.php in your web server folder (e.g., /var/www/html/ecde/).
3. Create uploads/ directory and make writable: `mkdir uploads && chmod 775 uploads`.
4. Update DB credentials in process.php and admin.php if needed.
5. Open index.php in your browser, submit a test form, then visit admin.php to see summaries.

Security notes:
- For production, restrict upload size and allowed file types, add CSRF protection,
  and run over HTTPS.
- Sanitize and validate inputs more strictly as needed.
