# Q13: Log database errors and access timestamps to a dedicated log file.
import logging
from datetime import datetime
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

# All messages go to db_server.log with a timestamp, level and text.
logging.basicConfig(filename="db_server.log", level=logging.INFO,
                    format="%(asctime)s | %(levelname)s | %(message)s")


def run_query(sql, params=()):
    """Run a query, logging every access and any error."""
    conn = None
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        logging.info("Database accessed at %s", datetime.now().isoformat(timespec="seconds"))
        cur = conn.cursor()
        cur.execute(sql, params)
        rows = cur.fetchall()
        logging.info("Query OK: %s (%d rows)", sql, len(rows))
        return rows
    except Error as e:
        logging.error("MySQL error %s: %s | query: %s", e.errno, e.msg, sql)
        print("A database error occurred - details were written to db_server.log")
        return []
    finally:
        if conn is not None and conn.is_connected():
            conn.close()


run_query("SELECT COUNT(*) FROM users")           # logs a successful access
run_query("SELECT * FROM table_that_is_missing")  # logs an error on purpose
print("Done. Open db_server.log to see the entries.")
