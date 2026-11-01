# Q9: Delete a record and handle database exceptions with try-except.
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

conn = None
try:
    user_id = int(input("User ID to delete: "))
    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor()
    cur.execute("DELETE FROM users WHERE id = %s", (user_id,))
    conn.commit()
    if cur.rowcount:
        print(f"User {user_id} deleted.")
    else:
        print(f"No user with ID {user_id}.")
except ValueError:
    print("Error: ID must be a number.")
except mysql.connector.errors.ProgrammingError as e:      # e.g. table missing
    print("SQL/programming error:", e)
except mysql.connector.errors.IntegrityError as e:        # e.g. foreign key blocks delete
    if conn is not None:
        conn.rollback()
    print("Integrity error:", e)
except mysql.connector.errors.InterfaceError as e:        # server not reachable
    print("Connection error:", e)
except Error as e:                                        # any other MySQL error
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()
