CREATE USER 'college_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT SELECT, INSERT, UPDATE ON college_db.* TO 'college_user'@'localhost';
FLUSH PRIVILEGES;