#!/usr/bin/env python3
# Q7: CGI script - read form data (cgi module) and insert it into MySQL.
import html
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG
from web_helpers import get_form           # wraps cgi.FieldStorage

print("Content-Type: text/html")
print()

form = get_form()                           # dict of submitted fields
name = form.get("name", "").strip()
email = form.get("email", "").strip()
age = form.get("age", "").strip()

if not name or not email or not age.isdigit():
    print("<h3>Error: name, email and a numeric age are required.</h3>")
else:
    conn = None
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cur = conn.cursor()
        cur.execute("INSERT INTO users (name, email, age) VALUES (%s, %s, %s)",
                    (name, email, int(age)))
        conn.commit()
        print(f"<h3>User '{html.escape(name)}' saved successfully (id {cur.lastrowid}).</h3>")
    except mysql.connector.IntegrityError:
        print("<h3>Error: this email is already registered.</h3>")
    except Error as e:
        print(f"<h3>Database error: {html.escape(str(e))}</h3>")
    finally:
        if conn is not None and conn.is_connected():
            conn.close()
print("<p><a href='/07_form.html'>Back to form</a></p>")
