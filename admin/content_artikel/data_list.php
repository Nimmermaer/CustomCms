<?php
session_start();

require( "../includes/userfunctions.php" );
require( "../includes/databasefunction.php" );
require( "../includes/design_layout_oberflaeche.php" );
require( "../includes/list_options.php" );
require( "../includes/artikel.php" );

//** Benutzerstatus �berpr�fen ---- **// 

(new userfunctions())->logged_user();

//** ------------------------- **//

//** Parameter definieren ---- **// 

$anhang = "?sid=" . $_REQUEST["sid"] . "&navid=" . $_REQUEST["navid"];
$action = "";
if (isset( $_REQUEST["action"] )) {
    $action = $_REQUEST["action"];
}
$stable = "tblcms_artikel";
$spath  = "content_artikel";

//** ------------------------- **//

//** Funktionen ausf�hren ---- **//

if ($action == "sortup") {
    sortup($_GET["id"]);
}

//** ------------------------- **//

//** Seiten aufbauen --------- **//

$sql      = "SELECT titel FROM tblcms_navigation WHERE id=" . $_REQUEST["navid"];
$res      = (new database())->send_sql($sql);
$data     = $res->fetch();
$navtitle = $data["titel"];

$designpage = new designlayout();
$designpage->pagestart(1);
$designpage->boxhead("Artikel -- " . $navtitle . " -- Übersicht", 637);
content_data();
$designpage->boxdown(0, 637);
$designpage->pageend();

//** ------------------------- **//

?>

<?php
function load_javascripts()
{
    ?>
    <script src="../ressourcen/js/functions.js" type="text/javascript" language="javascript"></script>
    <?php
}

function content_data()
{
    ?>
    <br>
    <table width="617" border="0" cellspacing="0" cellpadding="0" class="table_border">
        <tr>
            <td width="327" height="20" class="table_cell_right_bottom_head"><font color="#000000">&nbsp;Titel</font>
            </td>
            <td width="80" height="20" class="table_cell_right_bottom_head" align="center"><font color="#000000">angelegt:</font>
            </td>
            <td width="80" height="20" class="table_cell_right_bottom_head" align="center"><font color="#000000">ge&auml;ndert:</font>
            </td>
            <td width="130" height="20" class="table_cell_bottom_head"><font color="#000000">&nbsp;Aktionen</font></td>
        </tr>
        <?php
        loadentrylist();
        ?>
    </table>
    <?php
}

?>
