<?php
    include('classes/config.php');    
    $menu_sql = $link->query("SELECT * FROM `ags_admin_menus` WHERE FIND_IN_SET('".$_SESSION['userData']->user_role."', `user_type`) ORDER BY id ASC;");
?>
<!-- Sidebar Nav Menu -->
<nav class="pcoded-navbar menu-light">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div">				
            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="assets/images/user/user-icon.png" alt="User-Profile-Image" title="User profile picture" />
                    <div class="user-details">
                        <div id="more-details"><?php echo $_SESSION['userData']->role; ?> <i class="fa fa-caret-down"></i></div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item"><a href="user-profile.php"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
                        <!-- <li class="list-group-item"><a href="#"><i class="feather icon-settings m-r-5"></i>Settings</a></li> -->
                        <li class="list-group-item"><a href="logout.php"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
            
            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption"><label>AGS Navigation's</label></li>         
                <?php
                    while ($menu = $menu_sql->fetchAll()) {
                        $menu_arr = array();
                        foreach ($menu as $key => $item) {
                            $menu_arr[$menu[$key]['menu_caption']][$key] = $menu[$key];
                        }
                        ksort($menu_arr, SORT_NUMERIC);                
                    }                
                    foreach(array_keys($menu_arr) as $key => $val) { 
                        if($val == 'Home') {                
                ?>
                            <li class="nav-item">
                                <a href="<?php echo $menu_arr[$val][0]['menu_name'].'.php'; ?>" target="_self" class="nav-link"><span class="pcoded-micon"><i class="feather <?php echo $menu_arr[$val][array_keys($menu_arr[$val])[0]]['menu_icon']; ?>"></i></span><span class="pcoded-mtext"><?php echo $val; ?></span></a>
                            </li>
                <?php     
                         } else {
                ?>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="javascript:void(0)" class="nav-link "><span class="pcoded-micon"><i class="feather <?php echo $menu_arr[$val][array_keys($menu_arr[$val])[0]]['menu_icon']; ?>"></i></span><span class="pcoded-mtext"><?php echo $val; ?></span></a>
                                <ul class="pcoded-submenu">
                <?php
                                foreach($menu_arr[$val] as $key1 => $val1) {
                ?>                
                                    <li><a href="<?php echo $menu_arr[$val][$key1]['menu_name'].'.php'; ?>" target="_self"><?php echo $menu_arr[$val][$key1]['menu_title']; ?></a></li>
                    
                <?php 
                                }
                ?>
                                </ul>
                            </li>
                <?php 
                        } 
                    } 
                ?>                
            </ul>				
        </div>
    </div>
</nav>