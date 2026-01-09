<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('bootstrap.php');

$authPagesParams["head-name"] = 'Login';

$templateParams["title"] = "Hello !";

$templateParams["main-content"] = 'authTemplates/login_form.php';

$templateParams["footer"] = 'authTemplates/auth_footer.php';

$authPagesParams['footer-text'] = "Don't have an account?";

$authPagesParams['footer-link-dest'] = "signup.php";

$authPagesParams['footer-link-text'] = "New Account";

require('../utilities/templates/authTemplates/auth_pages_template.php');

require '../utilities/templates/base.php';
?>
