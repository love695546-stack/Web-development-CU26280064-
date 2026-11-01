# Q20: WSGI entry point that proves Apache is using the virtual environment.
import sys


def application(environ, start_response):
    try:
        import mysql.connector                       # installed inside the venv
        status_line = f"mysql.connector {mysql.connector.__version__} imported OK"
    except ImportError:
        status_line = "mysql.connector NOT found - install it inside the venv"

    text = (f"Python executable : {sys.executable}\n"
            f"Python prefix     : {sys.prefix}\n"
            f"Python version    : {sys.version.split()[0]}\n"
            f"Library check     : {status_line}\n").encode("utf-8")
    start_response("200 OK", [("Content-Type", "text/plain; charset=utf-8"),
                              ("Content-Length", str(len(text)))])
    return [text]
