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

**NOTE: Change the value of phone in the table to BigInt for the phone numbers to correctly insert. Also again, only an example. Customize it however.**
```
INSERT INTO students VALUES
(12345, 'zheng12', 'Jason', 'Zheng', 'Jason', 2158335883, 'Pinewoods Ave', 'Troy', 'NY', '12180'),
(23456, 'kannak', 'Kaaviya', 'Kannan', 'Kaaviya', 7328645700, 'George Ave', 'Edison', 'NJ', '08820'),
(34567, 'semidp', 'Pablo', 'Semidey', 'Pablo the Goat', 7876673739, 'Burdett Ave', 'Troy', 'NY', '12180'),
(45678, 'gutiee2', 'Eric', 'Gutierrez', 'Eric', 2013963411, 'Tibbits Ave', 'Troy', 'NY', '12180'),
(56789, 'oladet', 'Temitayo', 'Oladeji', 'Tem', 3472648049, 'Random St', 'Merrick', 'NY', '12345');
```
