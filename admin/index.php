<?php
session_start();

require( "includes/design_layout_login.php" );

//** Parameter definieren ---- **//

$loginerror = 0;
if (isset( $_POST["login"] )) {
    $login = $_POST["login"];
}


//** ------------------------- **//

//** Funktionen ausführen ---- **//

if ( ! empty( $login )) {
    require( "includes/databasefunction.php" );
    require( "includes/userfunctions.php" );
    $database = new database();

    if (!$database->databaseConnect()) {
        $database->buildDatabase();
    };
    $userFunc = new userfunctions();
    $userid   = $userFunc->check_user();
    if ($userid != false and $userid != "locked") {
        $anhang = $userFunc->login_user($userid);
        header("location: adminstart.php" . $anhang);
    } else {
        $loginerror     = 1;
        $loginerrortext = $userFunc->errorlogin_user();
    }
}

//** ------------------------- **//

//** Seiten aufbauen --------- **//


(new designlayoutlogin())->pagestart();

content_data();
(new designlayoutlogin())->pageend();

//** ------------------------- **//

function content_data()
{
    global $loginerror, $loginerrortext;
    ?>
    <div class="wrapper">
        <form name="form1" class="form-signin" method="post" action="index.php">
            <?php
            if ($loginerror == 1) {
                echo "!! FEHLER BEIM LOGIN !!<br>" . $loginerrortext;
            }
            ?>
            <h2 class="form-signin-heading">Please login</h2>
            <input name="login" type="hidden" id="login" value="login">
            <input type="text" class="form-control" name="user" required="" autofocus=""/>
            <input type="password" class="form-control" name="pw" placeholder="Password" required=""/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        </form>
    </div>
    <?php
}

?>
