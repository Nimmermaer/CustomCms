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

//** ------------------------- **//

//** Seiten aufbauen --------- **//
pagestart(1);
content_data();
pageend();

//** ------------------------- **//

function load_javascripts()
{
    global $objConn;

    ?>
    <script language="javascript">

        function dateiloadexit() {
            parent.subnav.location.href = "subnav.php?sid=<?=$_GET["sid"];?>";
            parent.headline.location.href = "gheadline.php?sid=<?=$_GET["sid"];?>";
        }

        function dateiloadsub() {
            parent.funktion.location.href = "empty.htm";
            parent.headline.location.href = "gheadline.php";
        }

        function styleback(nav) {
            <?php
                    $database = new database();
                    $sql = "SELECT id FROM tblvw_navigation WHERE parentid=0 ORDER BY ID";
                    $res = $database->send_sql($sql);
                    $stylenav=0;
                    while ($row  = $res->fetch())
                        {
                        $stylenav++;
            ?>
            document.getElementById("r<?=$stylenav;?>").style.color = '#FFFFFF';
            document.getElementById("r<?=$stylenav;?>").style.fontWeight = 'normal';
            <?php
                        }
            ?>
            document.getElementById('' + nav).style.color = '#333333';
            document.getElementById('' + nav).style.fontWeight = 'bold';
        }

    </script>

    <?php
}

function content_data()
{
    global $anhang;

    ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="navprim_bckgrnd">
        <tr>
            <td height="62" valign="top" rowspan="2"><img src="image_cms/gr_blank.gif" width="189" height="62">
            </td>
            <td width="100%" align="right" height="40">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
                    <tr>
                        <td width="100%" height="22" rowspan="2"><img src="image_cms/gr_blank.gif" width="100%"
                                                                      height="40"></td>
                        <td width="300" height="11" align="right" class="navprim_head">
                            User:&nbsp;<? echo $_SESSION["username"]; ?>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="300" height="11" align="right" class="navprim_head">
                            <?php echo date("d-m-Y"); ?>
                            &nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="100%" align="center" height="1"><img src="image_cms/gr_blank.gif" width="100%"
                                                                        height="1"></td>
                        <td width="300" align="center" height="1"><img src="image_cms/gr_blank.gif" width="300"
                                                                       height="1"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="100%" height="22">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="navprim_border">
                    <tr>
                        <?php
                        navigation_prim();
                        ?>
                        <td width="100%" align="center" height="1"><img src="image_cms/gr_blank.gif" width="100%"
                                                                        height="1"></td>
                        <td width="100" align="center" height="1"><img src="image_cms/gr_blank.gif" width="100"
                                                                       height="1"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="8"><img src="image_cms/gr_blank.gif" width="150" height="8"></td>
            <td height="8" bgcolor="#FFFFFF"><img src="image_cms/gr_lightgrey.gif" width="1" height="8"></td>
        </tr>
    </table>
    <?php
}

?>
