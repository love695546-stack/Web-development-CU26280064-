# Q1 (WSGI / mod_wsgi): "Hello World" application.
# mod_wsgi looks for a callable named "application".
def application(environ, start_response):
    body = "<h1>Hello, World from Python WSGI!</h1>".encode("utf-8")
    status = "200 OK"
    headers = [("Content-Type", "text/html; charset=utf-8"),
               ("Content-Length", str(len(body)))]
    start_response(status, headers)          # send status + headers
    return [body]                            # WSGI response body = list of bytes
