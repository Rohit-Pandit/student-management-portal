1. I created a folder named student-mangement-portal
2. I spinned my vsc 
3. created 5 folders, 2 files  under student-mangement-portal
folders(public,includes,databse,actions,views) files(index.php,style.css)
4. wrote a basic code in the index.php file which has two buttons (login, sign up)
5. linked my style.css file to the index.php
6. check whether php exists in my system or not
7. if not then i installed and configured it .
8. now i started my php server using commad.
     php -S localhost:8000
     and later in the browser opened http://localhost:8000/index.php to check whether it is working or not.

9. now lets configure database 
    Open phpMyAdmin (if using XAMPP, go to http://localhost/phpmyadmin/).
    Click New → Enter database name:     student_portal
    create tables

            CREATE TABLE students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            enrolled_subjects TEXT NULL
        );

            CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

10. Configure Database Connection (db.php)    

11. Sign up implementation 
    create signup.html page and signup.php page

 ------->>>>  verification till now  <<<<<<-------

            Run signup.html in the browser
            Fill in the details and submit
            Check users table in phpMyAdmin to see if data is inserted


12. Login implementation         
     create login.html file , login.php, dashboard.php , logout.php

      login verification
        1️⃣ Open login.html in the browser
        2️⃣ Enter credentials from your database
        3️⃣ After logging in, check if the dashboard shows your name
        4️⃣ Click Logout to see if it logs you out   


13.  Show enrolled subjects for students after login

     Create the subjects table

            CREATE TABLE subjects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        );

        now insert some subjects in the subject table
                    INSERT INTO subjects (name) VALUES
            ('Mathematics'),
            ('Science'),
            ('History'),
            ('Computer Science');

    Create the enrollments table       

            CREATE TABLE enrollments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            subject_id INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
        );
  
        Now, let's manually enroll a student (for testing):

                INSERT INTO enrollments (user_id, subject_id) VALUES
        (1, 1),  -- User 1 is enrolled in Mathematics
        (1, 2),  -- User 1 is enrolled in Science
        (2, 3);  -- User 2 is enrolled in History

 



