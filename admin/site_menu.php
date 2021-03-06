<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li id="dashActive"><a href="<?php echo baseUrl('admin/view/dashboard.php'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>General Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="countryActive"><a href="<?php echo baseUrl('admin/view/country/country_list.php'); ?>"><i class="fa fa-circle-o"></i> Country List</a></li>
                <li id="bannerActive"><a href="<?php echo baseUrl('admin/view/banner/banner_list.php'); ?>"><i class="fa fa-circle-o"></i> Banner List</a></li>
                <li id="sisterActive"><a href="<?php echo baseUrl('admin/view/sister_concern/sister_concern_list.php'); ?>"><i class="fa fa-circle-o"></i> Sister Concern List</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-list-alt"></i>
                <span>Product Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="productActive"><a href="<?php echo baseUrl('admin/view/product/product_list.php'); ?>"><i class="fa fa-circle-o"></i> Product List</a></li>
            </ul>
        </li>
        <li id="contactActive"><a href="<?php echo baseUrl('admin/view/contact/contact_list.php'); ?>"><i class="fa fa-comment"></i> Contact Information</a></li>
        
    </ul>
</section>