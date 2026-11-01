# Shared database settings used by every script in this lab.
# Change the password to match your MySQL installation
# (XAMPP default: user "root", empty password).
import os

SERVER_CONFIG = {                       # server-level connection (no database chosen)
    "host": "localhost",
    "user": "root",
    "password": os.environ.get("MYSQL_PASSWORD", ""),
}
DB_NAME = "python_web_db"
DB_CONFIG = {**SERVER_CONFIG, "database": DB_NAME}   # connection to our database
