# Q4: Create the database 'python_web_db' and the table 'users'.
import mysql.connector
from mysql.connector import Error
from db_config import SERVER_CONFIG, DB_NAME

conn = None
try:
    conn = mysql.connector.connect(**SERVER_CONFIG)
    cur = conn.cursor()
    # backticks protect the identifier; the name comes from our own config file
    cur.execute(f"CREATE DATABASE IF NOT EXISTS `{DB_NAME}`")
    cur.execute(f"USE `{DB_NAME}`")
    cur.execute("""
        CREATE TABLE IF NOT EXISTS users (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            name       VARCHAR(100) NOT NULL,
            email      VARCHAR(100) NOT NULL UNIQUE,
            age        INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    """)
    conn.commit()
    print(f"Database '{DB_NAME}' and table 'users' are ready.")
    cur.execute("DESCRIBE users")
    for column in cur.fetchall():
        print(" ", column[0], column[1])
except Error as e:
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()
