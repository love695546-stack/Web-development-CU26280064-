#!/usr/bin/env python3
# Q1 (CGI): "Hello World" script that Apache runs as a CGI program.
# Put it in Apache's cgi-bin folder (or any ExecCGI directory), make it
# executable on Linux (chmod +x 01_hello_cgi.py), then open
#   http://localhost/cgi-bin/01_hello_cgi.py
import platform

# A CGI script must print the HTTP header first, then ONE blank line, then the body.
print("Content-Type: text/html")
print()
print("<html><body>")
print("<h1>Hello, World from Python CGI!</h1>")
print(f"<p>Python version: {platform.python_version()}</p>")
print("</body></html>")
