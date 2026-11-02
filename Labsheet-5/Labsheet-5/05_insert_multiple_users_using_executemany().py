import mysql.connector

con = mysql.connector.connect(
    host="localhost", user="root", password="CU26280064",
    database="python_web_db"
)
cur = con.cursor()
sql = "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)"
users = [
    ("Aman", "aman@example.com", 21),
    ("Riya", "riya@example.com", 22),
    ("Karan", "karan@example.com", 20)
]
cur.executemany(sql, users)
con.commit()
print(cur.rowcount, "records inserted.")
cur.close()
con.close()
