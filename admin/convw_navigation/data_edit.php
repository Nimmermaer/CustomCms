<?php
session_start();

require( "../includes/userfunctions.php" );
require( "../includes/databasefunction.php" );
require( "../includes/design_layout_oberflaeche.php" );
require( "../includes/navigation.php" );

//** Benutzerstatus �berpr�fen ---- **// 

(new userfunctions())->logged_user();

//** ------------------------- **//

//** Parameter definieren ---- **// 

$anhang = "?sid=" . $_REQUEST["sid"];
$action = "";
if (isset( $_REQUEST["action"] )) {
    $action = $_REQUEST["action"];
}

//** ------------------------- **//

//** Funktionen ausf�hren ---- **//

if ($action == "update") {
    insert_data();
}

//** ------------------------- **//

//** Seiten aufbauen --------- **//

$designpage = new designlayout();
$designpage->pagestart(1);
$designpage->boxhead("Navigationsverwaltung - Neuer Eintrag", 637);
content_data();
$designpage->boxdown(0, 637);
$designpage->pageend();

//** ------------------------- **//

//** Daten-Aktion ausf�hren -- **//	

function insert_data()
{
    global $objConn;

    $sql = insert_new_naventry();
    (new database())->send_sql($sql);


    // .htaccess-Datei

    $path = ".htaccess";
    $fp   = fopen($path, "w");

    fwrite($fp, "RewriteEngine on\n");
    fwrite($fp, "Options +FollowSymlinks\n");
    fwrite($fp, "RewriteBase /\n");

    $sql = "SELECT * FROM tblcms_navigation";
    $res = (new database())->send_sql($sql);
    while ($row = $res->fetch()) {
        fwrite($fp, "RewriteRule ^" . $row["page_url"] . "\.htm$ index.php?pageid" . $row["id"] . "\n");
    }

    open_window();
}

//** ------------------------- **//

//** Seiten umschalten ------ **//

function open_window()
{
    global $anhang;
    ?>
    <script language="javascript">
        parent.headline.location.href = "head_add.php<?php echo $anhang?>";
        document.location.href = "data_list.php<?php echo $anhang?>";
    </script>
    <?php
}

//** ------------------------- **//

function load_javascripts()
{
    ?>
    <script language="javascript">

        function sendform() {
            verify = checkform();
            if (verify == true) {
                document.input.submit();
            }
        }
        function checkform() {
            if (document.input.strtitle.value == "") {
                alert('\nBitte alle Felder vollständig ausfüllen.')
                return false;
            }
            else {
                return true;
            }
        }

    </script>
    <?php
}

function content_data()
{
    $treeid   = "";
    $ebene    = "";
    $parentid = "";

    if (isset( $_REQUEST["treeid"] )) {
        $treeid = $_REQUEST["treeid"];
    }
    if (isset( $_REQUEST["ebene"] )) {
        $ebene = $_REQUEST["ebene"];
    }
    if (isset( $_REQUEST["parentid"] )) {
        $parentid = $_REQUEST["parentid"];
    }

    ?>
    <form name="input" method="post" action="data_edit.php">
        <table width=560 cellspacing="0" cellpadding="0">
            <tr>
                <td width=115 height="30">Beschriftung:<b> </b></td>
                <td width=445 height="30">
                    <input type="text" name="strtitle" size="44" class="itext">
                    <input type="hidden" name="sid" value="<?php echo $_GET["sid"]; ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="parentid" value="<?php echo $parentid; ?>">
                    <input type="hidden" name="treeid" value="<?php echo $treeid; ?>">
                    <input type="hidden" name="ebene" value="<?php echo $ebene ?>">
                </td>
            </tr>
        </table>
    </form>
    <?php
}

?>

