# Q19: Verify and sanitize web form input BEFORE running SQL write operations.
import html
import re
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG

EMAIL_PATTERN = re.compile(r"^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$")
NAME_PATTERN = re.compile(r"^[A-Za-z][A-Za-z .'-]{1,98}$")


def clean_text(value):
    """Strip whitespace and remove control characters (such as NUL / newlines)."""
    value = str(value or "")
    value = re.sub(r"[\x00-\x1f\x7f]", "", value)
    return value.strip()


def validate_user(form):
    """Return (clean_data, errors). Insert ONLY when errors is empty."""
    errors = []
    name = clean_text(form.get("name"))
    email = clean_text(form.get("email")).lower()
    age_text = clean_text(form.get("age"))

    if not NAME_PATTERN.match(name):
        errors.append("Name must be 2-99 letters (spaces . ' - allowed).")
    if len(email) > 100 or not EMAIL_PATTERN.match(email):
        errors.append("Email address is not valid.")
    if not age_text.isdigit() or not (1 <= int(age_text) <= 120):
        errors.append("Age must be a whole number between 1 and 120.")

    # html.escape makes the values safe to show back on a web page
    clean = {"name": name, "email": email,
             "age": int(age_text) if age_text.isdigit() else None}
    return clean, errors


def save_user(clean):
    """Parameterized INSERT - validation + parameters give two layers of safety."""
    conn = mysql.connector.connect(**DB_CONFIG)
    try:
        cur = conn.cursor()
        cur.execute("INSERT INTO users (name, email, age) VALUES (%s, %s, %s)",
                    (clean["name"], clean["email"], clean["age"]))
        conn.commit()
    finally:
        conn.close()


if __name__ == "__main__":
    # Simulated form submissions: some good, some malicious / invalid.
    submissions = [
        {"name": "Lakshmi Iyer", "email": "Lakshmi@Example.com", "age": "25"},
        {"name": "Robert'); DROP TABLE users;--", "email": "x@x.com", "age": "20"},
        {"name": "<script>alert(1)</script>", "email": "hack@example.com", "age": "30"},
        {"name": "Valid Name", "email": "not-an-email", "age": "abc"},
        {"name": "Old Person", "email": "old@example.com", "age": "250"},
    ]
    for i, form in enumerate(submissions, start=1):
        clean, errors = validate_user(form)
        print(f"\nSubmission {i}: {html.escape(str(form['name']))}")
        if errors:
            print("  REJECTED:")
            for err in errors:
                print("   -", err)
            continue
        try:
            save_user(clean)
            print("  ACCEPTED and saved:", clean)
        except mysql.connector.IntegrityError:
            print("  Not saved: email already exists.")
        except Error as e:
            print("  Database error:", e)
