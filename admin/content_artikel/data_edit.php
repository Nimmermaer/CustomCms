<?php
session_start();

require( "../includes/userfunctions.php" );
require( "../includes/databasefunction.php" );
require( "../includes/design_layout_oberflaeche.php" );

//** Benutzerstatus überprüfen ---- **//

(new userfunctions())->logged_user();


$database = new database();
//** ------------------------- **//

//** Parameter definieren ---- **// 
$action = "";
if (isset( $_REQUEST["action"] )) {
    $action = $_REQUEST["action"];
}
$anhang = "?sid=" . $_REQUEST["sid"] . "&navid=" . $_REQUEST["navid"] . "&artikelid=" . $_REQUEST["id"];

//** Seiten aufbauen --------- **//

$sql      = "SELECT titel FROM tblcms_navigation WHERE id=" . $_REQUEST["navid"];
$res      = $database->send_sql($sql);
$data     = $res->fetch();
$navtitle = $data["titel"];

$designpage = new designlayout();
$designpage->pagestart(1);

$designpage->boxhead("Artikel -- " . $navtitle . " -- Artikel bearbeiten", 637);
contentdata();
$designpage->boxdown(0, 637);
$designpage->pageend();

function load_javascripts()
{
    ?>
    <script src="../ressourcen/js/functions.js" type="text/javascript" language="javascript"></script>
    <?php
}

function contentdata()
{
    global $anhang;
    global $artikelid, $cbnr;
    $database = new database();

    //** TemplateID vom Navigationspunkt bestimmen **//
    $sql        = "SELECT templateid FROM tblcms_navigation WHERE id=" . $_REQUEST["navid"];
    $res        = $database->send_sql($sql);
    $data       = $res->fetch();
    $templateid = $data["templateid"];

    //** CMS-Boxes des Templates bestimmen **//
    $sql  = "SELECT * FROM tblcms_templates WHERE id=" . $templateid;
    $res  = $database->send_sql($sql);
    $data = $res->fetch();
    for ($i = 0; $i < 10; $i ++) {
        $cmsbox[$i] = $data["cmsbox" . $i];
    }

    echo( "<table width=560 cellspacing=0 cellpadding=0>\n" );

    for ($i = 0; $i < 10; $i ++) {
        if ($cmsbox[$i] != 0) {
            $sql  = "SELECT fileinput FROM tblcms_module WHERE id=" . $cmsbox[$i];
            $res  = $database->send_sql($sql);
            $data = $res->fetch();
            if ($data["fileinput"] != "") {
                $cbnr      = $i;
                $artikelid = $_REQUEST["id"];
                echo( "<tr><td width=560 valign=top>" );
                require( "includes/" . $data["fileinput"] );
                echo( "</td></tr>" );
                echo( "<tr ><td width=560 height=24>&nbsp;</td></tr>\n" );
            }
        }
    }

    echo( "<tr ><td height=30></td></tr></table>\n" );
}

?>