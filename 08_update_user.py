# Q8: Update a user's profile (name, email, age) using the user ID.
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

conn = None
try:
    user_id = int(input("User ID to update: "))
    name = input("New name  : ").strip()
    email = input("New email : ").strip()
    age = int(input("New age   : "))

    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor()
    cur.execute("UPDATE users SET name = %s, email = %s, age = %s WHERE id = %s",
                (name, email, age, user_id))
    conn.commit()
    if cur.rowcount:
        print("Profile updated successfully.")
    else:
        print("No change made (user not found or values are the same).")
except ValueError:
    print("Error: ID and age must be numbers.")
except mysql.connector.IntegrityError:
    print("Error: that email belongs to another user.")
except Error as e:
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()
