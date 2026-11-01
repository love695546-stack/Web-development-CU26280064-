#!/usr/bin/env python3
# Q16: Dynamic web endpoint that returns JSON built from a MySQL query.
# Test:  http://localhost/cgi-bin/16_json_endpoint.py
#        http://localhost/cgi-bin/16_json_endpoint.py?id=2
import json
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG
from web_helpers import get_form

print("Content-Type: application/json; charset=utf-8")
print()

conn = None
try:
    form = get_form()
    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor(dictionary=True)               # rows come back as dicts
    if form.get("id", "").isdigit():
        cur.execute("SELECT id, name, email, age, created_at FROM users WHERE id = %s",
                    (int(form["id"]),))
    else:
        cur.execute("SELECT id, name, email, age, created_at FROM users ORDER BY id")
    rows = cur.fetchall()
    # default=str converts datetime objects to text so json can handle them
    print(json.dumps({"status": "ok", "count": len(rows), "users": rows},
                     default=str, indent=2))
except Error as e:
    print(json.dumps({"status": "error", "message": str(e)}))
finally:
    if conn is not None and conn.is_connected():
        conn.close()
