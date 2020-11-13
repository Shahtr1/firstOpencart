<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/newOpencart/admin/');
define('HTTP_CATALOG', 'http://localhost/newOpencart/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/newOpencart/admin/');
define('HTTPS_CATALOG', 'http://localhost/newOpencart/');

// DIR
define('DIR_APPLICATION', '/opt/lampp/htdocs/newOpencart/admin/');
define('DIR_EXTENSION', '/opt/lampp/htdocs/newOpencart/extension/');
define('DIR_IMAGE', '/opt/lampp/htdocs/newOpencart/image/');
define('DIR_SYSTEM', '/opt/lampp/htdocs/newOpencart/system/');
define('DIR_CATALOG', '/opt/lampp/htdocs/newOpencart/catalog/');
define('DIR_STORAGE', '/opt/lampp/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'testOpencart');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

// OpenCart API
define('OPENCART_SERVER', 'https://www.opencart.com/');
