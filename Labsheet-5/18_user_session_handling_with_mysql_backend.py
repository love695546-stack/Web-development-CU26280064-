import secrets
import mysql.connector
from http.cookies import SimpleCookie

def get_connection():
    return mysql.connector.connect(
        host="localhost", user="root", password="YOUR_PASSWORD",
        database="python_web_db"
    )

def application(environ, start_response):
    cookie = SimpleCookie()
    cookie.load(environ.get("HTTP_COOKIE", ""))
    session_id = cookie["session_id"].value if "session_id" in cookie else secrets.token_urlsafe(32)

    con = get_connection()
    cur = con.cursor()
    cur.execute("CREATE TABLE IF NOT EXISTS sessions (session_id VARCHAR(100) PRIMARY KEY, user_id INT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)")
    cur.execute("INSERT IGNORE INTO sessions (session_id, user_id) VALUES (%s, %s)", (session_id, None))
    con.commit()
    cur.close()
    con.close()

    body = b"Session created and stored in MySQL."
    headers = [("Content-Type", "text/plain; charset=utf-8"),
               ("Content-Length", str(len(body))),
               ("Set-Cookie", "session_id=" + session_id + "; HttpOnly; SameSite=Lax; Path=/")]
    start_response("200 OK", headers)
    return [body]
