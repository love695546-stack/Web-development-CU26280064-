# Q14: Read a CSV file and bulk-insert its rows into MySQL.
import csv
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

rows, skipped = [], 0
try:
    with open("users.csv", "r", newline="", encoding="utf-8") as f:
        for r in csv.DictReader(f):
            try:
                rows.append((r["name"].strip(), r["email"].strip(), int(r["age"])))
            except (KeyError, ValueError):
                skipped += 1                       # bad row: skip it
except FileNotFoundError:
    print("Error: users.csv not found.")
    raise SystemExit(1)

conn = None
try:
    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor()
    cur.executemany("INSERT IGNORE INTO users (name, email, age) VALUES (%s, %s, %s)", rows)
    conn.commit()                                  # one transaction for all rows
    print(f"Read {len(rows)} valid row(s), skipped {skipped}.")
    print(f"Inserted {cur.rowcount} new row(s) (duplicates are ignored).")
except Error as e:
    if conn is not None:
        conn.rollback()
    print("Database error:", e)
finally:
    if conn is not None and conn.is_connected():
        conn.close()
