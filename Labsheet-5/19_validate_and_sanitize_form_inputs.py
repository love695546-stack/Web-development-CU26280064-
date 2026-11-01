import re
import mysql.connector

name = input("Name: ").strip()
email = input("Email: ").strip()
age_text = input("Age: ").strip()

if not name or len(name) > 100:
    raise ValueError("Name is required and must be at most 100 characters.")
if not re.fullmatch(r"[^@\s]+@[^@\s]+\.[^@\s]+", email) or len(email) > 150:
    raise ValueError("Enter a valid email address.")
if not age_text.isdigit() or not 0 <= int(age_text) <= 120:
    raise ValueError("Age must be a number from 0 to 120.")

con = mysql.connector.connect(
    host="localhost", user="root", password="YOUR_PASSWORD",
    database="python_web_db"
)
cur = con.cursor()
cur.execute(
    "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)",
    (name, email, int(age_text))
)
con.commit()
print("Validated user saved.")
cur.close()
con.close()
