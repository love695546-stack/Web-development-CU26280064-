# Q12: Connection pooling - reuse a fixed set of connections under heavy load.
import threading
import mysql.connector
from mysql.connector import Error, pooling
from db_config import DB_CONFIG

# The pool opens 5 connections once; requests borrow and return them.
pool = pooling.MySQLConnectionPool(pool_name="web_pool", pool_size=5, **DB_CONFIG)


def count_users(worker_id):
    """Borrow a connection from the pool, run a query, give it back."""
    conn = None
    try:
        conn = pool.get_connection()             # borrow
        cur = conn.cursor()
        cur.execute("SELECT COUNT(*) FROM users")
        print(f"Worker {worker_id}: {cur.fetchone()[0]} users")
    except Error as e:
        print(f"Worker {worker_id}: error - {e}")
    finally:
        if conn is not None:
            conn.close()                         # for a pooled connection this RETURNS it


# Simulate 12 simultaneous web requests sharing only 5 connections.
threads = [threading.Thread(target=count_users, args=(i,)) for i in range(1, 13)]
for t in threads:
    t.start()
for t in threads:
    t.join()
print("All workers finished.")
