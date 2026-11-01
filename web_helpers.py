# Small helper module shared by the CGI scripts (Q7, Q16, Q18, Q19).
import os
import sys
import warnings
from urllib.parse import parse_qs

warnings.filterwarnings("ignore", category=DeprecationWarning)


def get_form():
    """Return submitted form/query data as a plain dict {field: value}.

    Uses the 'cgi' module when it exists (Python 3.12 or older). The cgi module
    was removed in Python 3.13, so there we parse the request manually.
    """
    try:
        import cgi                                  # available up to Python 3.12
        form = cgi.FieldStorage()
        return {key: form.getfirst(key, "") for key in form.keys()}
    except ImportError:                             # Python 3.13+
        data = parse_qs(os.environ.get("QUERY_STRING", ""), keep_blank_values=True)
        if os.environ.get("REQUEST_METHOD") == "POST":
            length = int(os.environ.get("CONTENT_LENGTH") or 0)
            body = sys.stdin.read(length)
            data.update(parse_qs(body, keep_blank_values=True))
        return {key: values[0] for key, values in data.items()}
