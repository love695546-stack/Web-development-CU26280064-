import mysql.connector

try:
    con = mysql.connector.connect(
        host="localhost",
        user="root",
        password="CU26280064"
    )
    cur = con.cursor()
    cur.execute("SELECT VERSION()")
    row = cur.fetchone()
    print("MySQL Server Version:", row[0])
except mysql.connector.Error as e:
    print("Database error:", e)
finally:
    if 'cur' in locals():
        cur.close()
    if 'con' in locals() and con.is_connected():
        con.close()
