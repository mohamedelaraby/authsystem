
<?php 
    require APP_ROOT. '/Views/includes/head.php';
?>

<div class="navbar">
    <?php 
      require APP_ROOT. '/Views/includes/nav.php';
    ?>
</div>

<!--Start Form container -->
    <div class="container-login">
        <div class="wrapper-login">
            <h2> Sign in</h2>
            <form action="<?php echo URL_ROOT;?>/users/login", method="POST">
                <input type="text" placeholder="Username *" name="username">
                <span class="invalidFeedBack">
                <?php echo $data['usernameError']; ?>
                </span>
             
                <input type="password" placeholder="Password *" name="password">
                <span class="invalidFeedBack">
                <?php echo $data['passwordError']; ?>
                </span>
                <br>
                <button id="submit" type="submit" value="submit">Submit</button>
<br>
                <p class="options"> Not registered yet? 
                    <a href="<?php echo URL_ROOT;?>/users/register">
                        Create an account
                    </a>
                </p>
            </form>
        </div>
    </div>

<!--End Form container -->