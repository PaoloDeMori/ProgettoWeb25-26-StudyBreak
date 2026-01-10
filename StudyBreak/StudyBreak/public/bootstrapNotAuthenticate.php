<?php
$default_directory=__DIR__."/../";

require_once($default_directory . 'dtos.php');
require_once ($default_directory . "db/database.php");
require_once ($default_directory . "db/cartDatabase.php");
require_once ($default_directory . "db/favouriteDatabase.php");
require_once ($default_directory . "db/admin_database.php");
require_once ($default_directory . "utilities/functions.php");
require_once($default_directory . 'utilities/auth/auth_utilities.php');
require_once($default_directory . 'utilities/Const.php');

sec_session_start();

$dbh= new DatabaseHelper("localhost", "root", "", "StudyBreak", 3306);
$cartDbh = new cartDatabaseHelper($dbh->db);
$favouritesDbh = new favouriteDatabaseHelper($dbh->db);
$adminDbh = new AdminDatabaseHelper($dbh->db);

?>