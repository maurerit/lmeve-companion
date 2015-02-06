<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <META http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <title><?php echo("$LM_APP_NAME $lmver"); ?> - Please log in</title>
        <link type="text/css" href="<?php echo $stylesheet ?>" rel="stylesheet">
    </head>
    <body text="#000000" bgcolor="#FFFFFF">
        <center>
            <br>
            <form name="loginform" id="loginform" method="post" action="/main/login.html">

                <table border="0" cellspacing="0" cellpadding="0" width="250" class="login">
                    <tr><td align="left">&nbsp;<!--<br><label for="user_login">User:</label>--></td></tr>
                    <tr><td><div class="tcen">
                                <input name="login" placeholder="Login" id="user_login" size=20 type="text" value="" style="width: 140px" autocapitalize="off">
                            </div>
                        </td></tr>
                    <tr><td align="left">&nbsp;<!--<label for="user_pass">Password:</label>--></td></tr>
                    <tr><td><div class="tcen">
                                <input name="password" placeholder="Password" id="user_pass" size="20" type="password" style="width: 140px" autocapitalize="off">
                            </div>
                        </td></tr>
                    <tr><td align="left">&nbsp;<!--<label for="user_pass">Password:</label>--></td></tr>
                    <tr><td><div class="tcen">
                                <input name="logon" type="submit" value="Log in"><br/>
                            </div>
                        </td></tr>
                    <input type="hidden" name="<?php echo $csrf_token_name ?>" value="<?php echo $csrf_token_hash ?>"/>
                </table>
            </form>
            <div class="errors"><?php echo validation_errors(); ?></div>
            <?php
            include('templates/copyright.php');
            ?>
        </center>
    </body>
</html>

