# Q11: Parameterized query to prevent SQL injection, returning filtered results.
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

conn = None
try:
    keyword = input("Search name containing: ").strip()
    min_age = int(input("Minimum age: "))

    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor()

    # SAFE: user input is passed separately as parameters, never pasted into the SQL.
    sql = "SELECT id, name, email, age FROM users WHERE name LIKE %s AND age >= %s"
    cur.execute(sql, (f"%{keyword}%", min_age))

    rows = cur.fetchall()
    if rows:
        for row in rows:
            print(row)
    else:
        print("No matching users.")

    # UNSAFE example (do NOT do this):
    #   cur.execute("SELECT * FROM users WHERE name = '" + keyword + "'")
    # Typing  ' OR '1'='1  would then return every row.
    # With the parameterized version that text is treated as a plain name.
except ValueError:
    print("Error: age must be a number.")
except Error as e:
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()
