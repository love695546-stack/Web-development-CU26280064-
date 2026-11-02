import mysql.connector

try:
    # MySQL Database Connection
    con = mysql.connector.connect(
        host="localhost",
        user="root",
        password="CU26280064",
        database="python_web_db"
    )
    
    cur = con.cursor()
    
    # Query to select all users from the database
    cur.execute("SELECT id, name, email, age FROM users")
    
    print("--- Registered Users List ---")
    
    # Fetching and printing all rows
    rows = cur.fetchall()
    if not rows:
        print("No users found in the database.")
    else:
        for row in rows:
            print(f"ID: {row[0]} | Name: {row[1]} | Email: {row[2]} | Age: {row[3]}")
            
    # Closing connections
    cur.close()
    con.close()

except mysql.connector.Error as err:
    print(f"Database Error: {err}")