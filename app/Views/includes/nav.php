<nav class="top-nav">
<?php var_dump($_SESSION) ?>
<ul>
        <li>
            <a href="<?php echo URL_ROOT;?>/pages/index">Home</a>
        </li>

        <li class="btn-login">
        <?php if(isset($_SESSION['user_id'])) :?>
            <a href="<?php echo URL_ROOT;?>/users/logout">Log out</a>
        <?php else: ?>
            <a href="<?php echo URL_ROOT;?>/users/login">Login</a>
        <?php endif;?> 
        </li>
    </ul>
</nav>