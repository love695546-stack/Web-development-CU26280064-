# Q21: Analytical summary report (counts, averages) for an admin dashboard.
# Run:  python 21_summary_report.py          -> text report in the terminal
#       python 21_summary_report.py --html   -> HTML report (for a web dashboard)
import sys
import mysql.connector
from mysql.connector import Error
from db_config import DB_CONFIG


def build_report():
    """Run the aggregate queries and return the results as a dictionary."""
    conn = mysql.connector.connect(**DB_CONFIG)
    try:
        cur = conn.cursor()
        report = {}
        cur.execute("SELECT COUNT(*), AVG(age), MIN(age), MAX(age) FROM users")
        total, avg_age, min_age, max_age = cur.fetchone()
        report["summary"] = {"Total users": total,
                             "Average age": round(float(avg_age), 2) if avg_age else 0,
                             "Youngest": min_age, "Oldest": max_age}
        cur.execute("""SELECT CASE WHEN age < 21 THEN 'Under 21'
                                   WHEN age BETWEEN 21 AND 25 THEN '21-25'
                                   ELSE 'Over 25' END AS band, COUNT(*)
                       FROM users GROUP BY band ORDER BY band""")
        report["age_groups"] = cur.fetchall()
        cur.execute("""SELECT SUBSTRING_INDEX(email, '@', -1) AS domain, COUNT(*)
                       FROM users GROUP BY domain ORDER BY COUNT(*) DESC LIMIT 5""")
        report["domains"] = cur.fetchall()
        cur.execute("""SELECT DATE(created_at), COUNT(*) FROM users
                       GROUP BY DATE(created_at) ORDER BY DATE(created_at) DESC LIMIT 7""")
        report["signups"] = cur.fetchall()
        return report
    finally:
        conn.close()


def as_text(r):
    lines = ["===== USER SUMMARY REPORT ====="]
    lines += [f"{k:<14}: {v}" for k, v in r["summary"].items()]
    lines.append("\nUsers by age group:")
    lines += [f"  {band:<10} {count}" for band, count in r["age_groups"]]
    lines.append("\nTop email domains:")
    lines += [f"  {domain:<20} {count}" for domain, count in r["domains"]]
    lines.append("\nSign-ups per day (latest 7 days):")
    lines += [f"  {day}  {count}" for day, count in r["signups"]]
    return "\n".join(lines)


def as_html(r):
    parts = ["<html><body><h2>User Summary Report</h2><ul>"]
    parts += [f"<li><b>{k}</b>: {v}</li>" for k, v in r["summary"].items()]
    parts.append("</ul><h3>Users by age group</h3><table border='1'>")
    parts += [f"<tr><td>{b}</td><td>{c}</td></tr>" for b, c in r["age_groups"]]
    parts.append("</table></body></html>")
    return "\n".join(parts)


try:
    data = build_report()
    print(as_html(data) if "--html" in sys.argv else as_text(data))
except Error as e:
    print("Database error:", e)
