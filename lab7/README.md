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



