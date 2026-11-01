import mysql.connector

search_name = "Aman"
con = mysql.connector.connect(
    host="localhost", user="root", password="YOUR_PASSWORD",
    database="python_web_db"
)
cur = con.cursor()
cur.execute(
    "SELECT id, name, email FROM users WHERE name=%s",
    (search_name,)
)
for row in cur.fetchall():
    print(row)
cur.close()
con.close()
