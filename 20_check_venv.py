# Q20: Run this inside and outside the venv to see the difference.
import sys
in_venv = sys.prefix != getattr(sys, "base_prefix", sys.prefix)
print("Python executable :", sys.executable)
print("Running in a venv :", in_venv)
try:
    import mysql.connector
    print("mysql.connector   : available, version", mysql.connector.__version__)
except ImportError:
    print("mysql.connector   : NOT installed in this environment")
