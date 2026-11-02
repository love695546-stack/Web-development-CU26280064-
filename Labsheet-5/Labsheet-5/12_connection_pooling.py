from mysql.connector.pooling import MySQLConnectionPool

pool = MySQLConnectionPool(
    pool_name="web_pool",
    pool_size=5,
    host="localhost",
    user="root",
    password="CU26280064",
    database="python_web_db"
)

con = pool.get_connection()
cur = con.cursor()
cur.execute("SELECT COUNT(*) FROM users")
print("Total users:", cur.fetchone()[0])
cur.close()
con.close()  # Returns connection to pool
