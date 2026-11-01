import mysql.connector
from html import escape

con = mysql.connector.connect(
    host="localhost", user="root", password="YOUR_PASSWORD",
    database="python_web_db"
)
cur = con.cursor()
cur.execute("SELECT id, name, email, age FROM users")
rows = cur.fetchall()

html = ["<html><body><h2>User List</h2><table border='1'>",
        "<tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th></tr>"]
for row in rows:
    html.append("<tr>" + "".join(
        "<td>" + escape(str(value if value is not None else "")) + "</td>"
        for value in row
    ) + "</tr>")
html.append("</table></body></html>")
print("\n".join(html))

cur.close()
con.close()
