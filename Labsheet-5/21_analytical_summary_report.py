import mysql.connector

con = mysql.connector.connect(
    host="localhost", user="root", password="CU26280064",
    database="python_web_db"
)
cur = con.cursor()
cur.execute("SELECT COUNT(*), AVG(age) FROM users")
total, average_age = cur.fetchone()

print("ADMIN DASHBOARD REPORT")
print("Total users:", total)
print("Average age:", round(average_age, 2) if average_age is not None else "N/A")

cur.close()
con.close()
