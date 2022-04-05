<?php
     include("config.php");   
    $admin_sql = "SELECT a.id,a.name,a.email,a.mobile,a.user_role,r.role_code,r.role,a.status,a.created_at,a.locationId FROM `roles` AS r,ags_admin AS a WHERE a.user_role = r.role_code AND r.status = 1 GROUP BY a.name,r.role_code";

    $table = <<<EOT
    ( $admin_sql ) temp
    EOT;
 
    $primaryKey = 'id';
    $columns = array(        
        array( 'db' => 'id', 'dt' => 0 ),
        array( 'db' => 'name', 'dt' => 1 ),     
        array( 'db' => 'email',     'dt' => 2 ),
        array( 'db' => 'mobile',     'dt' => 3 ), 
        array( 'db' => 'role',     'dt' => 4 ), 
        array( 'db' => 'locationId',     'dt' => 5 ), 
        array( 'db' => 'status',     'dt' => 6 ),      
        array(
            'db'        => 'created_at',
            'dt'        => 7,
            'formatter' => function( $d, $row ) {
                return date( 'jS M y', strtotime($d));
            }
        ),        
        array( 'db' => null,     'dt' => 8)           
    );
  
    require('ssp_join.class.php');
    echo json_encode(
        SSP::simple( $_GET, $link, $table, $primaryKey, $columns )
    );