#!/usr/bin/env python3
# Q6: Retrieve all users and format them as an HTML response string.
# Works from the terminal AND as a CGI script under Apache.
import html
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG


def users_to_html():
    """Query the users table and return the result as an HTML string."""
    conn = mysql.connector.connect(**DB_CONFIG)
    try:
        cur = conn.cursor()
        cur.execute("SELECT id, name, email, age FROM users ORDER BY id")
        rows = cur.fetchall()
    finally:
        conn.close()

    out = ["<html><body><h2>Registered Users</h2>",
           "<table border='1' cellpadding='6'>",
           "<tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th></tr>"]
    for uid, name, email, age in rows:
        # html.escape stops stored text from being run as HTML (XSS protection)
        out.append(f"<tr><td>{uid}</td><td>{html.escape(name)}</td>"
                   f"<td>{html.escape(email)}</td><td>{age}</td></tr>")
    out.append("</table>")
    out.append(f"<p>Total users: {len(rows)}</p></body></html>")
    return "\n".join(out)


print("Content-Type: text/html")        # HTTP header (needed for CGI)
print()                                  # blank line ends the headers
try:
    print(users_to_html())
except Error as e:
    print(f"<p style='color:red'>Database error: {html.escape(str(e))}</p>")
