import mysql.connector

con = None
cur = None
try:
    con = mysql.connector.connect(
        host="localhost", user="root", password="CU26280064",
        database="python_web_db"
    )
    cur = con.cursor()
    user_id = 3
    cur.execute("DELETE FROM users WHERE id=%s", (user_id,))
    con.commit()
    print("Record deleted." if cur.rowcount else "Record not found.")
except mysql.connector.Error as e:
    print("MySQL error:", e)
finally:
    if cur:
        cur.close()
    if con and con.is_connected():
        con.close()
