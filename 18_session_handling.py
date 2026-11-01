#!/usr/bin/env python3
# Q18: User sessions stored in MySQL (login, visit counter, logout) as a CGI script.
# A random session id is kept in a browser cookie; the session data lives in MySQL.
import html
import os
import secrets
from http.cookies import SimpleCookie
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG
from web_helpers import get_form

conn = mysql.connector.connect(**DB_CONFIG)
cur = conn.cursor(dictionary=True)
cur.execute("""CREATE TABLE IF NOT EXISTS sessions (
                   session_id CHAR(64) PRIMARY KEY,
                   user_id    INT NOT NULL,
                   visits     INT DEFAULT 1,
                   last_seen  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                              ON UPDATE CURRENT_TIMESTAMP)""")

cookie = SimpleCookie(os.environ.get("HTTP_COOKIE", ""))
sid = cookie["session_id"].value if "session_id" in cookie else ""
form = get_form()
headers, body = [], []

try:
    # --- logout -------------------------------------------------------
    if form.get("action") == "logout" and sid:
        cur.execute("DELETE FROM sessions WHERE session_id = %s", (sid,))
        conn.commit()
        headers.append("Set-Cookie: session_id=; Max-Age=0; Path=/")
        sid = ""
        body.append("<p>You have been logged out.</p>")

    # --- login (user supplies the email of a registered user) -----------
    elif os.environ.get("REQUEST_METHOD") == "POST" and form.get("email"):
        cur.execute("SELECT id, name FROM users WHERE email = %s", (form["email"].strip(),))
        user = cur.fetchone()
        if user:
            sid = secrets.token_hex(32)               # unguessable 64-char id
            cur.execute("INSERT INTO sessions (session_id, user_id) VALUES (%s, %s)",
                        (sid, user["id"]))
            conn.commit()
            headers.append(f"Set-Cookie: session_id={sid}; HttpOnly; Path=/; SameSite=Lax")
            body.append(f"<p>Welcome, {html.escape(user['name'])}! Session started.</p>")
        else:
            body.append("<p style='color:red'>No user with that email.</p>")

    # --- returning visitor with a valid session -------------------------------
    elif sid:
        cur.execute("""SELECT s.visits, u.name FROM sessions s
                       JOIN users u ON u.id = s.user_id WHERE s.session_id = %s""", (sid,))
        row = cur.fetchone()
        if row:
            cur.execute("UPDATE sessions SET visits = visits + 1 WHERE session_id = %s", (sid,))
            conn.commit()
            body.append(f"<p>Hello again, {html.escape(row['name'])}. "
                        f"This is visit number {row['visits'] + 1} in this session.</p>")
        else:
            sid = ""                                  # cookie is stale

    # --- show login form when there is no session ------------------------------
    if not sid:
        body.append("<form method='post'>Email: <input name='email' type='email'> "
                    "<button>Login</button></form>")
    else:
        body.append("<p><a href='?action=logout'>Logout</a></p>")
except Error as e:
    body.append(f"<p>Database error: {html.escape(str(e))}</p>")
finally:
    conn.close()

print("Content-Type: text/html")
for h in headers:
    print(h)
print()
print("<html><body><h2>Session Demo</h2>" + "\n".join(body) + "</body></html>")
