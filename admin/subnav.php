<?php
session_start();

require( "includes/userfunctions.php" );
require( "includes/databasefunction.php" );
require( "includes/nav_cms.php" );

//** Benutzerstatus �berpr�fen ---- **// 

(new userfunctions())->logged_user();

//** ------------------------- **//

//** Parameter definieren ---- **// 

$anhang = "?sid=" . $_GET["sid"];
if (isset( $_GET["mainmenu"] )) {
    $mainmenu = $_GET["mainmenu"];
}

//** ------------------------- **//

//** Seiten aufbauen --------- **//

pagestart(1);
content_data();
pageend();

//** ------------------------- **//

function load_javascripts()
{
    global $anhang;
    ?>

    <script language="javascript">

        function dateiload(headline) {
            parent.headline.location.href = headline;
        }

    </script>
    <?php
}

function content_data()
{
    global $anhang;

    ?>

    <table width="191" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
            <td width="5" height="30" class="navprim_bckgrnd">&nbsp;</td>
            <td width="25" height="30" class="navprim_bckgrnd">&nbsp;</td>
            <td width="160" height="40" colspan="2" class="navprim_bckgrnd">&nbsp;</td>
            <td width="1" height="30"><img src="image_cms/gr_lightgrey.gif" width="1" height="40"></td>
        </tr>
        <?php
        data_seknavi();
        ?>
        <tr>
            <td width="5" class="navprim_bckgrnd">&nbsp;</td>
            <td width="25" class="navprim_bckgrnd">&nbsp;</td>
            <td width="25" class="navprim_bckgrnd">&nbsp;</td>
            <td width="135" class="navprim_bckgrnd">&nbsp;</td>
            <td width="1" height="100%" class="navprim_border"><img src="image_cms/gr_blank.gif" width="1" height="1">
            </td>
        </tr>
        <tr>
            <td colspan="4" class="navprim_bckgrnd">&nbsp;</td>
            <td width="1" height="24" class="navprim_border"><img src="image_cms/gr_blank.gif" width="1" height="1">
            </td>
        </tr>
    </table>
    <?php
}
