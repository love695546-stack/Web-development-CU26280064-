# Q2: Install the Python MySQL connector libraries and verify them.
#
# Run these commands in a terminal (not inside Python):
#     pip install mysql-connector-python
#     pip install PyMySQL
#     pip install SQLAlchemy          # needed later for Q15
#
# Then run this script to confirm that the installation worked.

def check(module_name, pip_name):
    """Try to import a module and report its version."""
    try:
        module = __import__(module_name)
        version = getattr(module, "__version__", "unknown")
        print(f"[OK]      {pip_name} is installed (version {version})")
    except ImportError:
        print(f"[MISSING] {pip_name} -> run: pip install {pip_name}")

check("mysql.connector", "mysql-connector-python")
check("pymysql", "PyMySQL")
check("sqlalchemy", "SQLAlchemy")
