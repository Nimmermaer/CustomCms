<?php
session_start();

require( "../includes/userfunctions.php" );
require( "../includes/databasefunction.php" );
require( "../includes/design_layout_oberflaeche.php" );
require( "../includes/templates.php" );

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

//** Funktionen ausführen ---- **//

if ($action == "update") {
    insert_data();
}

if ($action == "edit") {
    $pagetitle = "Modulverwaltung -- Eintrag bearbeiten";
}

if ($action == "") {
    $pagetitle = "Modulverwaltung -- Neuer Eintrag";
}

//** ------------------------- **//

//** Seiten aufbauen --------- **//

$designpage = new designlayout();
$designpage->pagestart(1);
$designpage->boxhead($pagetitle, 637);
content_data();
$designpage->boxdown(0, 637);
$designpage->pageend();

//** ------------------------- **//

//** Daten-Aktion ausführen -- **//

function insert_data()
{
    global $objConn;

    if ($_POST["id"] != 0) {
        $sql = edit_entry_modul();
    } else {
        $sql = insert_new_entry_modul();
    }

    echo "<font face=Arial,Helvetica,sans-serif size=1 color=#ff6600><br>&nbsp;&nbsp;&nbsp;&nbsp;Einen Augenblick Geduld - Daten werden gespeichert</font>";
    (new database())->send_sql($sql);
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
                alert('\nGeben Sie einen Titel und eine Ausgabedatei an.')
                return false;
            }
            else {
                return true;
            }
        }

    </script>
    <?php
}

?>

<?php
//** Content-Bereich ---- **//

function content_data()
{
    global $objConn;

    $id      = 0;
    $ltitle  = "";
    $linput  = "";
    $loutput = "";

    if (isset( $_REQUEST["id"] )) {
        $id = $_REQUEST["id"];
    }

    if ($id != 0) {
        $sql     = "SELECT * FROM tblcms_module WHERE ID=" . $id;
        $res     = (new database())->send_sql($sql);
        $data    = $res->fetch();
        $ltitle  = $data["titel"];
        $linput  = $data["fileinput"];
        $loutput = $data["fileoutput"];
    }

    ?>

    <form name="input" method="post" action="data_edit.php" enctype="multipart/form-data">
        <table width=560 cellspacing="0" cellpadding="0">
            <tr>
                <td width=163 height="30">Bezeichnung:<b>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="sid" value="<?php echo $_GET["sid"] ?>">
                        <input type="hidden" name="action" value="update">
                    </b></td>
                <td width=397 height="30"><input name="strtitle" type="text" class="itext" value="<?php echo $ltitle ?>"
                                                 size="44">
                </td>
            </tr>
            <tr>
                <td height="9" colspan="2"><img src="../image_cms/gr_lightgrey.gif" width="430" height="1"></td>
            </tr>
            <?php
            if ($id != 0) {
                ?>
                <tr>
                    <td width=163 height="34" class="txtformpflicht">Aktuelle Eingabe-Datei:</td>
                    <td width=397 height="34" class="txtformpflicht"><?php echo $linput; ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td width=163 height="34">Neue Eingabe-Datei:</td>
                <td width=397 height="34"><input name="strinput" type="file" class="itext">
                    <b>
                        <input type="hidden" name="strinputold" value="<?php echo $linput ?>">
                    </b></td>
            </tr>
            <tr>
                <td height="9" colspan="2"><img src="../image_cms/gr_lightgrey.gif" width="430" height="1"></td>
            </tr>
            <?php
            if ($id != 0) {
                ?>
                <tr>
                    <td width=163 height="34" class="txtformpflicht">Aktuelle Ausgabe-Datei:</td>
                    <td height="34" class="txtformpflicht"><?php echo $loutput; ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td width=163 height="34">Neue Ausgabe-Datei:</td>
                <td height="34" class="txt"><input name="stroutput" type="file" class="itext">
                    <b>
                        <input type="hidden" name="stroutputold" value="<?php echo $loutput ?>">
                    </b></td>
            </tr>
            <tr>
                <td height="24">&nbsp;</td>
                <td height="24" class="txt">&nbsp;</td>
            </tr>
        </table>
    </form>
    <?php
}

?>


