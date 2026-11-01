import logging
import mysql.connector

logging.basicConfig(
    filename="database_server.log",
    level=logging.INFO,
    format="%(asctime)s %(levelname)s %(message)s"
)

try:
    con = mysql.connector.connect(
        host="localhost", user="root", password="YOUR_PASSWORD",
        database="python_web_db"
    )
    cur = con.cursor()
    cur.execute("SELECT COUNT(*) FROM users")
    logging.info("Database query completed successfully")
    print(cur.fetchone()[0])
    cur.close()
    con.close()
except mysql.connector.Error:
    logging.exception("Database operation failed")
