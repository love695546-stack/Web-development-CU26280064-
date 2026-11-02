import subprocess
from datetime import datetime

database = "python_web_db"
filename = "backup_" + datetime.now().strftime("%Y%m%d_%H%M%S") + ".sql"

command = [
    "mysqldump",
    "-h", "localhost",
    "-u", "root",
    database
]
# mysqldump may prompt for the password. For automation, configure
# a protected MySQL option file rather than writing the password here.
with open(filename, "w", encoding="utf-8") as output:
    subprocess.run(command, stdout=output, check=True)

print("Backup created:", filename)
