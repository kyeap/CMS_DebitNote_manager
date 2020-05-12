<?php 

    if ($page == "private/logout") {
?>

<!-- header after logout -->
<header>
    <nav id="nav">  
        <div class=logo id="navbar"> <a href="<?php echo $site_url?>?page=home">SA Solution</a></div>
        <label class="mobileMenu" for="toggle"> Menu </label>
        <input id="toggle" class="toggle" type="checkbox">
        <ul class=nav_list>
            <li class=nav_item> <a href="<?php echo $site_url; ?>?page=private/login">Login</a> </li>
        </ul> 
    </nav>

</header>

<?php
    }

    if ($_SESSION['uname'] != NULL and $_SESSION['auth']=1) {

?>

<!-- header when logged in -->
<header>
    <nav class=nav> 
        <div class=logo> <a href="<?php echo $site_url?>?page=private/loginHome">Welcome <?php $_SESSION['uname'] ?></a></div>
        <input id="toggle" class="toggle" type="checkbox">
        <label class="mobileMenu" for="toggle"> Menu </label>   
        <ul class=nav_list>
            <li class=nav_item> <a href="<?php echo $site_url; ?>?page=private/dn"> Issue Debit Note</a> </li>
            <li class=nav_item> <a href="<?php echo $site_url; ?>?page=private/searchDB"> Search Debit Note </a> </li>
            <li class=nav_item> <a href="<?php echo $site_url; ?>?page=private/logout">Logout</a> </li>
        </ul> 
    </nav>
    <div class="nav_space"> </div>
</header>

<?php
    }
    else {
?>

<!-- Normal header -->
<header>
    <nav class="nav" id="nav">      
        <div class=logo> <a href="<?php echo $site_url?>?page=home">SA Solution</a></div>
        <input id="toggle" class="toggle" type="checkbox">
        <label class="mobileMenu" for="toggle"> Menu </label>
        <ul class=nav_list>
            <li class=nav_item> <a href="<?php echo $site_url; ?>?page=private/login">Login</a> </li>
        </ul> 
        
    </nav>


</header>

<?php
    }
?>