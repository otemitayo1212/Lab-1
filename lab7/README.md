# Lab 7 - PHP and Database

In this lab, we are utilizing PHP, phpmyadmin, and mySQL to create and manage a database.

For this assignment, we used XAMPP to download Apache, MySQL, and PHP in order to access phpmyadmin database and create our own tables. The XAMPP Control Panel allows you to run Apache and MySQL on command and link the source files to the localhost.

1. Open XAMPP Control Panel and start Apache and mySQL
2. Type into the browser: "localhost/phpmyadmin"
3. Create the database and the tables
4. Use the SQL scripts to paste data into the tables

---

# Logs

-  Add address fields (street, city, state, zip) to the students table

```
ALTER TABLE students ADD street VARCHAR(255);
ALTER TABLE students ADD city VARCHAR(100);
ALTER TABLE students ADD state CHAR(2);
ALTER TABLE students ADD zip VARCHAR(10);
```

- Add section and year fields to the courses table 

```
ALTER TABLE courses ADD section VARCHAR(10)
ALTER TABLE courses ADD year INT(4)
```

- CREATE a grades table containing id (int primary key, auto increment), crn (foreign key), RIN (foreign key), and grade (int 3 not null)

```
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crn INT(11) NOT NULL,
    RIN INT(9) NOT NULL,
    grade INT(3) NOT NULL,
    FOREIGN KEY (crn) REFERENCES courses(crn),
    FOREIGN KEY (RIN) REFERENCES students(RIN)
);
```

-  INSERT at least 4 courses into the courses table

**NOTE: this is only an example, you can customize it**
```
INSERT INTO courses VALUES 
(73215, 'CSCI', 2200, 'Foundations of Computer Science', '02', 2025),
(75422, 'CSCI', 2800, 'Computer Architecture & Operating Systems', '06', 2025),
(73048, 'ITWS', 2110, 'Web Systems Development', '01', 2025),
(74557, 'CSCI', 2700, 'Introduction to RCOS', '01', 2025);

```

- INSERT at least 4 students into the students table 

**NOTE: Change the value of phone in the table to BigInt for the phone numbers to accurately insert. Also again, only an example. Customize it however.**
```
INSERT INTO students VALUES
(12345, 'zheng12', 'Jason', 'Zheng', 'Jason', 2158335883, 'Pinewoods Ave', 'Troy', 'NY', '12180'),
(23456, 'kannak', 'Kaaviya', 'Kannan', 'Kaaviya', 7328645700, 'George Ave', 'Edison', 'NJ', '08820'),
(34567, 'semidp', 'Pablo', 'Semidey', 'Pablo the Goat', 7876673739, 'Burdett Ave', 'Troy', 'NY', '12180'),
(45678, 'gutiee2', 'Eric', 'Gutierrez', 'Eric', 2013963411, 'Tibbits Ave', 'Troy', 'NY', '12180'),
(56789, 'oladet', 'Temitayo', 'Oladeji', 'Tem', 3472648049, 'Random St', 'Merrick', 'NY', '12345');
```

- ADD 10 grades into the grades table 

***Only as examples, can change values to your preferences***
```
INSERT INTO grades VALUES
(1, 73048, 12345, 99),
(2, 73048, 23456, 95),
(3, 73048, 34567, 100),
(4, 73048, 45678, 99),
(5, 73048, 56789, 99),
(6, 75422, 12345, 94),
(7, 75422, 23456, 88),
(8, 75422, 34567, 93),
(9, 73215, 12345, 80),
(10, 73215, 23456, 82);
```

- List all students in the following sequences; in lexicographical order by RIN, last name, RCSID, and first name.

```
SELECT * FROM students ORDER BY RIN;

....

SELECT * FROM students ORDER BY last_name;

....

SELECT * FROM students ORDER BY RCSID;

....

SELECT * FROM students ORDER BY first_name;

....

```

- List all students RIN, name, and address if their grade in any course was higher than a 90 

```
SELECT DISTINCT students.RIN, students.first_name, students.last_name, 
       students.street, students.city, students.state, students.zip
FROM students
JOIN grades ON students.RIN = grades.RIN
WHERE grades.grade > 90;

...
```

- List out the average grade in each course 

```
SELECT crn, AVG(grade) AS average_grade
FROM grades
GROUP BY crn;

...
```

- List out the number of students in each course

```
SELECT crn, COUNT(RIN) AS student_count
FROM grades
GROUP BY crn;
```

## Part 3

- Add JSON column into courses table

```
ALTER TABLE courses
ADD COLUMN course_json JSON;
```

- Insert Spooky Web Sys into courses

```
INSERT INTO courses (crn, prefix, number, title)
VALUES (12345, 'ITWS', 2210, 'Spooky Web Sys')
ON DUPLICATE KEY UPDATE title = VALUES(title);
```

- Upload the JSON onto json column

```
UPDATE courses
SET course_json = '{
  "Websys_course": {
    "Lectures": {
      "Lecture 1": {
        "Title": "Class Intro",
        "Description": "Lecture covering course introduction and overview."
      },
      "Lecture 2": {
        "Title": "Frontend review",
        "Description": "Lecture refreshing information about HTML and Group formations."
      },
      "Lecture 3": {
        "Title": "Frontend review",
        "Description": "Lecture covering frontend basics like servers, http port, etc."
      },
      "Lecture 4": {
        "Title": "Frontend review",
        "Description": "Reviews CSS concepts and work on lab 1."
      },
      "Lecture 5": {
        "Title": "CSS Lecture",
        "Description": "Continuations of CSS and Brian Clark presented Datasets for projects."
      },
      "Lecture 6": {
        "Title": "US Consitution",
        "Description": "work on lab 2 which was based on the constitution"
      },
      "Lecture 7": {
        "Title": "JavaScript Lecture",
        "Description": "Lecture refreshing basic JS syntax and uses."
      },
      "Lecture 8": {
        "Title": "Lab 3 Work",
        "Description": "Working on lab 3 during the class."
      },
      "Lecture 9": {
        "Title": "Project Proposal Presentations",
        "Description": "Students presented their project proposals in class."
      },
      "Lecture 10": {
        "Title": "JavaScript Lecture",
        "Description": "Continuations of JavaScript concepts."
      },
      "Lecture 11": {
        "Title": "AJAX and JSON",
        "Description": "Refresher on AJAX and JSON and how they work."
      },
      "Lecture 12": {
        "Title": "Generative AI",
        "Description": "Read articles about Gen AI and worked on lab 4."
      },
      "Lecture 13": {
        "Title": "Frontend Optimization",
        "Description": "Lecture on how frontend works as a whole and how to optimize a web system."
      },
      "Lecture 14": {
        "Title": "Bloomber Terminal Field Trip",
        "Description": "Introduction to bloomberg terminals in Pittsburg."
      },
      "Lecture 15": {
        "Title": "Midterm Presentations",
        "Description": "Students presented their midterm project presentations in class."
      },
      "Lecture 16": {
        "Title": "PHP",
        "Description": "Lecture on PHP syntax and basic concepts."
      },
      "Lecture 17": {
        "Title": "PHP Interfaces, Abstract Classes, Polymorphism",
        "Description": "Interfaces, classes, and polymorphism."
      },
      "Lecture 18": {
        "Title": "Work on lab7",
        "Description": "Worked on lab 7 with the TA."
      }
    },
    "Labs": {
      "Lab 1": {
        "Title": "Lab 1 - Portofolio Website",
        "Description": "Created a portofolio website for our group project Data Pulse."
      },
      "Lab 2": {
        "Title": "Lab 2 - Constitution Day Web App",
        "Description": "Created a website intended to educate readers about the contituion and its content."
      },
      "Lab 3": {
        "Title": "Lab 3 - JavaScript, AJAX, JSON, using APIs",
        "Description": "Created a web app with a weather API and another API of choice that displays Troy\'s current weather."
      },
      "Lab 4": {
        "Title": "Lab 4 - Generative AI",
        "Description": "Created the same website as in lab 3, but using only Gen AI to write all the code."
      },
      "Lab 5": {
        "Title": "Lab 5 - Bloomberg Terminal",
        "Description": "Reflected on how to use the Bloomber Terminal, and how we could implement it into our project."
      },
      "Lab 6": {
        "Title": "Lab 6 - PHP, OOP and Input Handling",
        "Description": "Created a simple calculator using PHP and classes."
      }
    }
  }
}'
WHERE title = 'Spooky Web Sys';
```
