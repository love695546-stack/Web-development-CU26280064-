# Q5: Insert several user records at once with executemany().
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

users = [
    ("Amit Sharma", "amit@example.com", 21),
    ("Riya Verma", "riya@example.com", 22),
    ("Sohan Singh", "sohan@example.com", 23),
    ("Neha Gupta", "neha@example.com", 20),
    ("Pooja Rawat", "pooja@example.com", 24),
]

conn = None
try:
    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor()
    # %s placeholders = parameterized query. INSERT IGNORE skips duplicate emails
    # so the script can be run more than once.
    sql = "INSERT IGNORE INTO users (name, email, age) VALUES (%s, %s, %s)"
    cur.executemany(sql, users)              # one call, many rows
    conn.commit()
    print(f"{cur.rowcount} record(s) inserted.")
except Error as e:
    if conn is not None:
        conn.rollback()                      # undo partial changes
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()
