<?php

/**
 * Warning !!
   You can choose to either keep or remove the trailing '/' character at the end
   of the URL according to your preference. Please be mindful of this preference
   when using base URL in static files (HTML, JavaScript, etc.)
 */

$environment = "development";

switch ($environment) {
  case 'development':

    $BASE_URL = "http://localhost/php-base-frame/";
    $DB_HOST = "localhost";
    $DB_CHAREST = "utf8mb4";
    $DB_NAME = "test";
    $DB_USER = "root";
    $DB_PASSWORD = "";

    break;
  case 'product':

    $BASE_URL = "";
    $DB_HOST = "";
    $DB_CHAREST = "utf8mb4";
    $DB_NAME = "";
    $DB_USER = "";
    $DB_PASSWORD = "";

    break;
}
