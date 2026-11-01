#!/usr/bin/env python3
import cgi
import mysql.connector
from html import escape

print("Content-Type: text/html; charset=utf-8")
print()
form = cgi.FieldStorage()
name = form.getfirst("name", "").strip()
email = form.getfirst("email", "").strip()
age_text = form.getfirst("age", "").strip()

if not name or not email or not age_text.isdigit():
    print("<p>Enter a name, email and valid age.</p>")
else:
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
    print("<p>User saved: " + escape(name) + "</p>")
    cur.close()
    con.close()
