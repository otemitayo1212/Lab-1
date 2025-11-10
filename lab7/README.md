# Lab 7 - PHP and Database

In this lab, we are utilizing PHP, phpmyadmin, and mySQL to create and manage a database.

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
