<?php
session_start();

define("ROOT", dirname(__DIR__));
define("SRC", ROOT."/src");
define("VIEWS", SRC."/Views");
define("PUBLIC_IMAGE", ROOT."/public/images");

require ROOT."/autoload.php";
require ROOT."/permission.php";
require ROOT."/helper.php";
require ROOT."/web.php";