<?php
session_start();

require( "../includes/userfunctions.php" );
require( "../includes/databasefunction.php" );
require( "../includes/design_layout_oberflaeche.php" );
require( "../includes/upload_scripts.php" );

//** Benutzerstatus Überprüfen ---- **//


(new userfunctions())->logged_user();

//** ------------------------- **//

//** Parameter definieren ---- **// 

$anhang = "?sid=" . $_REQUEST["sid"] . "&sub=" . $_REQUEST["sub"] . "&mainmenu=" . $_REQUEST["mainmenu"];
$action = "";
if (isset( $_REQUEST["action"] )) {
    $action = $_REQUEST["action"];
}

//** ------------------------- **//

//** Funktionen ausf�hren ---- **//

if ($action == "update") {
    insert_data();
}

if ($action == "edit") {
    $pagetitle = "Dokumente -- Eintrag bearbeiten";
}

if ($action == "") {
    $id        = 0;
    $pagetitle = "Dokumente -- Neuer Eintrag";
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

//** Daten-Aktion ausf�hren -- **//	

function insert_data()
{
    $database = new database();
    $upload   = new uploadscript();
    if ($_POST["id"] != 0) {
        $sql = $upload->edit_entry_document();
    } else {
        $sql = $upload->insert_new_entry_document();
    }

    echo "<font face=Arial,Helvetica,sans-serif size=1 color=#ff6600><br>&nbsp;&nbsp;&nbsp;&nbsp;Einen Augenblick Geduld - Daten werden gespeichert</font>";
    $database->send_sql($sql);
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
            if (document.input.doc.value == ""
                && document.input.docold.value == ""
            ) {
                alert('\nWählen Sie bitte ein Dokument aus.')
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
    $database = new database();

    $id       = 0;
    $ltitle   = "";
    $lfile    = "";
    $lfsize   = "";
    $ltyp     = "";
    $lapp     = "";
    $linfo    = "";
    $ldatnew  = "";
    $ldatedit = "";
    $lrealdoc = "";

    if (isset( $_REQUEST["id"] )) {
        $id = $_REQUEST["id"];
    }

    if ($id != 0) {
        $sql      = "SELECT * FROM tblcms_dokumente WHERE ID=" . $_GET["id"];
        $res      = $database->send_sql($sql);
        $data     = $res->fetch();
        $ltitle   = $data["titel"];
        $lfile    = $data["cfile"];
        $lfsize   = $data["fsize"];
        $ltyp     = $data["ftype"];
        $lapp     = $data["fapplication"];
        $linfo    = str_replace("<br>", "\n", $data["info"]);
        $ldatnew  = $data["date_new"];
        $ldatedit = $data["date_edit"];
        $lrealdoc = $data["rcfile"];
    }

    //** Zusatzdaten laden ------ **//

    if ($_GET["sub"] == "") {
        $sub      = 0;
        $filepath = "" . $lrealdoc;
    } else {
        $filepath = $this->folderpath($_GET["sub"]) . "/" . $lrealdoc;
    }

    ?>
    <form name="input" method="post" action="data_edit.php" enctype="multipart/form-data">
        <table width=560 cellspacing="0" cellpadding="0">
            <tr>
                <td width=115 height="30">Arbeits-Titel:<b>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="sid" value="<?php echo $_GET["sid"] ?>">
                        <input type="hidden" name="sub" value="<?php echo $_GET["sub"] ?>">
                        <input type="hidden" name="mainmenu" value="<?php echo $_GET["mainmenu"]; ?>">
                        <input type="hidden" name="action" value="update">
                    </b></td>
                <td width=445 height="30">
                    <input type="text" name="strtitle" cols="44" class="itext" value="<?php echo $ltitle ?>">
                </td>
            </tr>
            <tr>
                <td width=115 height="30">Dokument:</td>
                <td width=445 height="30" colspan="4">
                    <input type="file" name="doc" class="itext">
                    <input type="hidden" name="docold" value="<?php echo $lfile ?>">
                    <input type="hidden" name="realdocold" value="<?php echo $lrealdoc ?>">
                    <input type="hidden" name="sizeold" value="<?php echo $lfsize ?>">
                    <input type="hidden" name="appold" value="<?php echo $lapp ?>">
                    <input type="hidden" name="typold" value="<?php echo $ltyp ?>">
                </td>
            </tr>
            <?
            if ($lrealdoc != "") {
                ?>
                <tr>
                    <td colspan="2" height=19><img src="../image_cms/gr_line_darkgrey.gif" width="400" height="1"></td>
                </tr>
                <tr>
                    <td width=115 height="24">Aktuelles Dokument:</td>
                    <td height="24" class="txt"><a href="../../uploadfiles/documents/<?php echo $filepath ?>"
                                                   target="_blank" class="txtlinkintern">
                            <?php echo $lfile; ?>
                        </a></td>
                </tr>
                <tr>
                    <td width=115 height="24">Dateigr&ouml;sse:</td>
                    <td width=445 height="24" class="txt">
                        <?php echo $lfsize ?>
                        &nbsp;Bytes
                    </td>
                </tr>
                <tr>
                    <td width=115 height="24">angelegt am:</td>
                    <td width=445 height="24" class="txt">
                        <?php echo $ldatnew ?>
                    </td>
                </tr>
                <tr>
                    <td width=115 height="24">ge&auml;ndert am:</td>
                    <td width=445 height="24" class="txt">
                        <?php echo $ldatedit ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
    <?php
}

?>


