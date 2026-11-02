import json
import mysql.connector

def application(environ, start_response):
    try:
        con = mysql.connector.connect(
            host="localhost", user="root", password="CU26280064",
            database="python_web_db"
        )
        cur = con.cursor()
        cur.execute("SELECT COUNT(*) FROM users")
        count = cur.fetchone()[0]
        cur.close()
        con.close()
        body = json.dumps({"success": True, "user_count": count}).encode()
        status = "200 OK"
    except mysql.connector.Error:
        body = json.dumps({"success": False, "error": "Database unavailable"}).encode()
        status = "500 Internal Server Error"

    start_response(status, [
        ("Content-Type", "application/json; charset=utf-8"),
        ("Content-Length", str(len(body)))
    ])
    return [body]
