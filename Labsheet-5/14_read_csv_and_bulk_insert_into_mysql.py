import csv
import mysql.connector

records = []
with open("users.csv", newline="", encoding="utf-8") as file:
    reader = csv.DictReader(file)
    for row in reader:
        records.append((row["name"], row["email"], int(row["age"])))

con = mysql.connector.connect(
    host="localhost", user="root", password="YOUR_PASSWORD",
    database="python_web_db"
)
cur = con.cursor()
cur.executemany(
    "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)",
    records
)
con.commit()
print(len(records), "CSV records inserted.")
cur.close()
con.close()
