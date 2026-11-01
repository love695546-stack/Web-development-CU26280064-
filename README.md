# Lab Sheet 5 - Python + MySQL + Apache

## One-time setup
1. Install MySQL (or XAMPP, which includes MySQL + Apache). Start the MySQL service.
2. `pip install mysql-connector-python PyMySQL SQLAlchemy`
3. Open `db_config.py` and set your MySQL password (XAMPP default: empty).
4. Run in order: `python 04_create_db_table.py`, then `python 05_insert_many.py`.

## How to run
* Terminal scripts (Q2-Q5, Q8, Q9, Q11-Q15, Q17, Q19-Q21): `python <file>.py`
* Web scripts (Q1, Q6, Q7, Q10, Q16, Q18): copy the folder into Apache's cgi-bin (see
  `01_apache_config.conf` and `10_htaccess.txt`), then open them in the browser.
* Config-only answers: Q1 -> `01_apache_config.conf`, Q10 -> `10_htaccess.txt`,
  Q20 -> `20_venv_apache_setup.txt`.

## Notes
* Python 3.13 removed the `cgi` module. `web_helpers.py` uses it when available
  and falls back to manual parsing otherwise.
* On Windows, change the first line (`#!/usr/bin/env python3`) of CGI scripts to your
  python.exe path, e.g. `#!C:/Python312/python.exe`.
