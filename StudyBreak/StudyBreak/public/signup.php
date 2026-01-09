<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('bootstrap.php');

$authPagesParams["head-name"] = 'SignUp';

$templateParams["title"] = "Create account";

$templateParams["main-content"] = 'authTemplates/signUp_form.php';

$templateParams["footer"] = 'authTemplates/auth_footer.php';

$authPagesParams['footer-text'] = "Made a mistake?";

$authPagesParams['footer-link-dest'] = "login.php";

$authPagesParams['footer-link-text'] = "Go Back";

require('../utilities/templates/authTemplates/auth_pages_template.php');

require '../utilities/templates/base.php';
?>
