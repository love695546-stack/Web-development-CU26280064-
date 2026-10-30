<VirtualHost *:80>
    ServerName collegeweb.local
    DocumentRoot "C:/xampp/htdocs/collegeweb"
    <Directory "C:/xampp/htdocs/collegeweb">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>