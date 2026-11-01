# Q3: Connect to the MySQL server and run a query that returns its version.
import mysql.connector
from mysql.connector import Error
from db_config import SERVER_CONFIG

conn = None
try:
    conn = mysql.connector.connect(**SERVER_CONFIG)      # open the connection
    if conn.is_connected():
        print("Connected to MySQL server.")
        cur = conn.cursor()
        cur.execute("SELECT VERSION()")                  # the query
        print("MySQL server version:", cur.fetchone()[0])
        cur.close()
except Error as e:
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()                                     # always close
        print("Connection closed.")
