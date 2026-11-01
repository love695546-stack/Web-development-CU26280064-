# Q17: Back up the database (schema + data) into a .sql file with pure Python.
import datetime as dt
from decimal import Decimal
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG


def sql_literal(value):
    """Convert a Python value into a safe SQL literal for an INSERT statement."""
    if value is None:
        return "NULL"
    if isinstance(value, (int, float, Decimal)):
        return str(value)
    if isinstance(value, (dt.datetime, dt.date, dt.time, dt.timedelta)):
        return "'" + str(value) + "'"
    if isinstance(value, (bytes, bytearray)):
        return "0x" + value.hex()
    text = str(value).replace("\\", "\\\\").replace("'", "\\'")
    return "'" + text + "'"


def backup(filename):
    conn = mysql.connector.connect(**DB_CONFIG)
    try:
        cur = conn.cursor()
        cur.execute("SHOW TABLES")
        tables = [row[0] for row in cur.fetchall()]
        with open(filename, "w", encoding="utf-8") as f:
            f.write(f"-- Backup of {DB_CONFIG['database']} created {dt.datetime.now()}\n")
            f.write("SET FOREIGN_KEY_CHECKS=0;\n\n")
            for table in tables:
                cur.execute(f"SHOW CREATE TABLE `{table}`")       # schema
                create_sql = cur.fetchone()[1]
                f.write(f"DROP TABLE IF EXISTS `{table}`;\n{create_sql};\n\n")
                cur.execute(f"SELECT * FROM `{table}`")           # data
                for row in cur.fetchall():
                    values = ", ".join(sql_literal(v) for v in row)
                    f.write(f"INSERT INTO `{table}` VALUES ({values});\n")
                f.write("\n")
            f.write("SET FOREIGN_KEY_CHECKS=1;\n")
        return tables
    finally:
        conn.close()


if __name__ == "__main__":
    name = f"backup_{DB_CONFIG['database']}_{dt.datetime.now():%Y%m%d_%H%M%S}.sql"
    try:
        tables = backup(name)
        print(f"Backup complete: {name}  (tables: {', '.join(tables)})")
    except Error as e:
        print("Database error:", e)
    except OSError as e:
        print("File error:", e)
