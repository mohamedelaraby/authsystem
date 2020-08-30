
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
            <h2> Register</h2>
            <form action="<?php echo URL_ROOT;?>/users/register", method="POST">
                <input type="text" placeholder=" Username *" name="username">
                <span class="invalidFeedBack">
                <?php echo $data['usernameError']; ?>
                </span>

                <input type="email" placeholder=" Email *" name="email">
                <span class="invalidFeedBack">
                <?php echo $data['emailError']; ?>
                </span>

                <input type="password" placeholder=" Password *" name="password">
                <span class="invalidFeedBack">
                <?php echo $data['passwordError']; ?>
                </span>
                
                <input type="password" placeholder=" confirm Password *" name="confirmpassword">
                <span class="invalidFeedBack">
                <?php echo $data['confirmPasswordError']; ?>
                </span>
                <br>

                <button id="submit" type="submit" value="submit">Submit</button>

                <p class="options"> Have an account? 
                    <a href="<?php echo URL_ROOT;?>/users/login">
                       Sign in now!
                    </a>
                </p>
            </form>
        </div>
    </div>

<!--End Form container -->