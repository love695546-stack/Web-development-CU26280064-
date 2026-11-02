import sys
import os

# Project folder ka path add karein
path = "C:/path/to/your/project"
if path not in sys.path:
    sys.path.append(path)

def application(environ, start_response):
    status = '200 OK'
    output = b'Hello from Apache with Virtual Environment (venv)!'
    response_headers = [
        ('Content-Type', 'text/plain; charset=utf-8'),
        ('Content-Length', str(len(output)))
    ]
    start_response(status, response_headers)
    return [output]