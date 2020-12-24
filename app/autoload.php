<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/model/Configuration.php';
require __DIR__ . '/model/WebSite.php';
require __DIR__ . '/model/DataBase.php';
require __DIR__ . '/model/Theme.php';
require __DIR__ . '/model/Error.php';
require __DIR__ . '/model/Mailer.php';
require __DIR__ . '/model/User.php';
require __DIR__ . '/model/Session.php';
require __DIR__ . '/model/Token.php';

require __DIR__ . '/controller/http/Request.php';
require __DIR__ . '/controller/http/Response.php';

require __DIR__ . '/controller/error/NotFound.php';

require __DIR__ . '/controller/Home.php';
require __DIR__ . '/controller/AboutUs.php';
require __DIR__ . '/controller/Contact.php';
require __DIR__ . '/controller/News.php';

require __DIR__ . '/controller/admin/Login.php';
require __DIR__ . '/controller/admin/Lost.php';
require __DIR__ . '/controller/admin/Summary.php';
require __DIR__ . '/controller/admin/News.php';
require __DIR__ . '/controller/admin/Gallery.php';
require __DIR__ . '/controller/admin/Configuration.php';
require __DIR__ . '/controller/admin/Uploads.php';
require __DIR__ . '/controller/admin/Navigation.php';
require __DIR__ . '/controller/admin/Contact.php';

