import mysql.connector

user_id = 1
new_name = "Aman Kumar"
new_email = "aman.kumar@example.com"
new_age = 23

con = mysql.connector.connect(
    host="localhost", user="root", password="YOUR_PASSWORD",
    database="python_web_db"
)
cur = con.cursor()
cur.execute(
    "UPDATE users SET name=%s, email=%s, age=%s WHERE id=%s",
    (new_name, new_email, new_age, user_id)
)
con.commit()
print("Profile updated." if cur.rowcount else "No user found with this ID.")
cur.close()
con.close()
