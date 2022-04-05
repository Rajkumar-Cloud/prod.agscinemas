<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include("config.php");    
    $get_path = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    if(isset($_REQUEST['addFoodItem'])) {       
        $food_name = $_POST['foodItems_name'];
        $food_price = $_POST['food_price'];
        $food_offerApply_price = round($_POST['food_offerApply_price']);
        $foodOffer_apply = $_POST['foodOffer_apply'];
        $ags_foodType = $_POST['ags_foodType'];
        $data = [
            'foodname' => $food_name,
            'foodprice' => $food_price,
            'offerApplied_price' => $food_offerApply_price,
            'offer_applied' => $foodOffer_apply,
            'foodtype' => $ags_foodType,
            'created_user' => $_SESSION['username']            
        ];
        $foodsql = "INSERT INTO `fooditems` (foodname, foodprice, offerApplied_price, offer_applied, foodtype, created_user) VALUES (:foodname, :foodprice, :offerApplied_price, :offer_applied, :foodtype, :created_user)";
        $food_stmt= $link->prepare($foodsql);
        $food_stmt->execute($data);
        $lastInsertId = $link->lastInsertId();        
        if($lastInsertId > 0) {
            $json_arr = ['type'=>'success', 'message'=>"inserted", 'dataId'=>$lastInsertId, 'code'=>'201'];
        } else {
            $json_arr = ['type'=>'fail', 'message'=>"insert_error", 'code'=>'401'];
        }
    }

    if(isset($_FILES['fooditem_image'])) {      
        $RowId = $_REQUEST['rowId'];
        $file_name = $_FILES['fooditem_image']['name'];
        $file_size = $_FILES['fooditem_image']['size'];
        $file_tmp = $_FILES['fooditem_image']['tmp_name'];
        $file_type = $_FILES['fooditem_image']['type'];       

        $project_dir = explode('/', $_SERVER['REQUEST_URI'])[1];        
        $domain_path = $get_path.'/'.$project_dir;
        // $folder = $domain_path.'/assets/Food/';        
        $target_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/Food/'. basename($file_name);
        $uploadDirectory = "Food";
        $update_sql = "UPDATE `fooditems` SET foodImage_name=:foodImage_name, foodImage_url=:foodImage_url WHERE id=:id";        
        $imgData = ['foodImage_name' => $file_name,'foodImage_url' => $get_path.'/assets/Food/'.$file_name,'id' => $RowId];
        $stmt = $link->prepare($update_sql);
        $stmt->execute($imgData);        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/Food'))
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/'.$uploadDirectory, 0777, true);            
        
        if(move_uploaded_file($file_tmp, $target_path))
            $json_arr = ['type'=>'success', 'message'=>"success", 'code'=>'201'];

    }    

    if(isset($_REQUEST['foodStatusUppdate'])) {    
        $update_status_sql = "UPDATE `fooditems` SET status=:status WHERE id=:id";        
        $statusData = ['status' => $_POST['statusId'], 'id' => $_POST['rowId'] ];        
        $stmt_result = $link->prepare($update_status_sql);
        $stmt_result->execute($statusData);          
        $update_count = $stmt_result->rowCount();
        if($update_count > 0) {
            $json_arr = ['type'=>'success', 'message'=>"updated", 'code'=>'201'];
        }
    }

    if(isset($_REQUEST['delete_foodItems'])) {
        $del_id = $_REQUEST['rowId'];
        $food_img = $_REQUEST['foodImg'];
        $unlink_path = $_SERVER['DOCUMENT_ROOT'].'/assets/Food';         
        if(isset($food_img)) { unlink($unlink_path . "/" . $food_img); }        
        $del_sql = 'DELETE FROM `fooditems` WHERE id = :id';
        $user_st = $link->prepare($del_sql);
        $user_st->bindParam(':id', $del_id, PDO::PARAM_INT);
        $user_st->execute();
        $del_count = $user_st->rowCount();
        if($del_count > 0) {
            $json_arr = ['type'=>'response', 'status'=> 'success', 'message'=>'deleted', 'code'=>'201'];        
        } else {
            $json_arr = ['type'=>'response', 'status'=> 'error', 'message'=>'delete-error', 'code'=>'401'];            
        }
    }
    if(isset($_REQUEST['updateFoodData'])) {        
        $updateId = $_POST['foodItem_Id'];
        $food_img = $_POST['foodImage'];
        $food_name = $_POST['foodItems_name'];
        $food_price = $_POST['food_price'];
        $food_offerApply_price = round($_POST['food_offerApply_price']);
        $foodOffer_apply = $_POST['foodOffer_apply'];
        $ags_foodType = $_POST['ags_foodType'];
        $update_sql = "UPDATE `fooditems` SET foodname=:foodname, foodprice=:foodprice, offerApplied_price=:offerApplied_price, offer_applied=:offer_applied, foodtype=:foodtype WHERE id=:id";
        $f_data = ['foodname' => $food_name, 'foodprice' => $food_price,'offerApplied_price' => $food_offerApply_price,'offer_applied' => $foodOffer_apply, 'foodtype' => $ags_foodType, 'id' => $updateId];
        $stmt = $link->prepare($update_sql);
        $stmt->execute($f_data);  
        $u__affect_c = $stmt->rowCount();        
        if($_FILES['fooddata_image']['error'] == 0) {
            $unlink_path = $_SERVER['DOCUMENT_ROOT'].'/assets/Food/'.$food_img;         
            if(file_exists($food_img)) { unlink($unlink_path); }

            $file_name = $_FILES['fooddata_image']['name'];
            $file_size = $_FILES['fooddata_image']['size'];
            $file_tmp = $_FILES['fooddata_image']['tmp_name'];
            $file_type = $_FILES['fooddata_image']['type'];       
    
            $project_dir = explode('/', $_SERVER['REQUEST_URI'])[1];        
            $domain_path = $get_path.'/'.$project_dir;                
            $target_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/Food/'. basename($file_name);            
            $updateImg_sql = "UPDATE `fooditems` SET foodImage_name=:foodImage_name, foodImage_url=:foodImage_url WHERE id=:id";        
            $imgData = ['foodImage_name' => $file_name,'foodImage_url' => $domain_path.'/assets/Food/'.$file_name, 'id' => $updateId];
            $stmt1 = $link->prepare($updateImg_sql);
            $stmt1->execute($imgData);                       
            move_uploaded_file($file_tmp, $target_path);          
        }
        $json_arr = ['status'=>'success', 'message'=>"updated", 'code'=>'201'];
    }


    echo json_encode($json_arr);
?>