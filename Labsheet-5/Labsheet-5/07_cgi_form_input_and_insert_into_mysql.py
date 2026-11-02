import cgi
import mysql.connector
from html import escape

# HTTP Headers (Browser ko batane ke liye ki HTML output hai)
print("Content-Type: text/html; charset=utf-8")
print()

# HTML Form se data read karne ke liye
form = cgi.FieldStorage()
name = form.getfirst("name", "").strip()
email = form.getfirst("email", "").strip()
age_text = form.getfirst("age", "").strip()

# Validation
if not name or not email or not age_text.isdigit():
    print("<h3>Error: Please enter a valid name, email, and numeric age.</h3>")
else:
    try:
        # MySQL Database Connection
        # (Apna MySQL password yahan 'YOUR_PASSWORD' ki jagah daal dein)
        con = mysql.connector.connect(
            host="localhost",
            user="root",
            password="CU26280064",
            database="python_web_db"
        )
        
        cur = con.cursor()
        
        # Data Insert Query
        query = "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)"
        values = (name, email, int(age_text))
        
        cur.execute(query, values)
        con.commit()
        
        # Success Message
        print(f"<h3>Success! User saved: {escape(name)}</h3>")
        
        # Connection close karna zaroori hai
        cur.close()
        con.close()
        
    except mysql.connector.Error as err:
        print(f"<h3>Database Error: {err}</h3>")