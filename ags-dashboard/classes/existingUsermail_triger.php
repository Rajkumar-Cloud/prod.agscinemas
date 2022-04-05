<?php
     include("config.php");   
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

$user_sql = "SELECT DISTINCT u.id, u.name, u.email, u.mobile, u.profilepic, u.signuptime, u.created_at, u.firsttimeuser, u.status, u.otp_count, u.mail_status FROM users u WHERE u.status = '0' AND u.otp_count = '0' AND u.mail_status = '0'";
 
// DB table to use

$table = <<<EOT
 ( $user_sql ) temp
EOT;
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => null, 'dt' => 0 ),
    array( 'db' => 'id', 'dt' => 1 ),
    array( 'db' => 'name', 'dt' => 2 ),     
    array( 'db' => 'email',     'dt' => 3 ),
    array( 'db' => 'mobile',     'dt' => 4 ), 
    array(
        'db'        => 'created_at',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }
    ),
    array( 'db' => 'status',     'dt' => 6 ),
    array( 'db' => null,     'dt' => 7 ),
    array( 'db' => 'mail_status',     'dt' => 8 )    

);
  
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require('ssp_join.class.php');
echo json_encode(
    SSP::simple( $_GET, $link, $table, $primaryKey, $columns )
);