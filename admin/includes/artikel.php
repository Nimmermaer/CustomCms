<?php
//** ____________________________________________________________ 
//**	Modul:		Funktionen Upload-Bereich Bilder
//**	Subs:		- foldertitel()
//**				- loadentrylist()
//**				- insert_new_entry()
//**				- edit_entry()
//**				- load_entry()
//** ____________________________________________________________ 


//** ____________________________________________________________ 
//**	Submodul:		loadentrylist()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Artikel
//** ____________________________________________________________ 

function loadentrylist()
{
    global $anhang;
    global $spath, $stable;

    // "SELECT id, titel, publik, pos, date_new, date_edit FROM tblcms_artikel WHERE menuid=" . $_REQUEST["navid"] . " ORDER BY pos";
    $sql = "SELECT id, titel, publik, pos, date_new, date_edit FROM tblcms_artikel ORDER BY pos";
    $res = (new database())->send_sql($sql);






    if ($res->rowCount() != 0) {


        while ($row = $res->fetch()) {

            $jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";
            $buttons  = new listenbutton();
            $tdfunc1  = $buttons->entry_edit_artikel($row["id"]);
            $tdfunc2  = $buttons->entry_rename_artikel($row["id"]);
            $tdfunc3  = $buttons->entry_delete($row["id"], $stable, $spath, $row["titel"], "__dataartikel_delete.php");
            $tdfunc4  = $buttons->entry_onoffline_button($row["publik"], $row["id"], $stable, $spath, $row["titel"],
                "__datacontent_lock");
            $tdfunc5  = $buttons->entry_sort($row["id"], $row["pos"]);
            $tdclass  = $buttons->entry_onoffline_text($row["publik"]);

            echo( "<tr " . $jstrover . ">" );
            echo( "<td width=447 height=20 class=table_cell_right_bottom>&nbsp;" );
            echo( "<a href=data_edit.php" . $anhang . "&aktion=edit&id=" . $row["id"] . " target=funktion onClick=dateiload('head_save.php" . $anhang . "') class=" . $tdclass . ">" );
            echo $row["titel"];
            echo( "</a></td>" );
            echo( "<td width=80 height=20 align=center class=table_cell_right_bottom>" . $row["date_new"] . "</td>" );
            echo( "<td width=80 height=20 align=center class=table_cell_right_bottom>" . $row["date_edit"] . "</td>" );
            echo( "<td width=130 height=20 class=table_cell_bottom>" . $tdfunc1 . $tdfunc2 . $tdfunc3 . $tdfunc4 . $tdfunc5 . "</td>" );
            echo( "</tr>" );
        }
    }
}

//** ____________________________________________________________ 
//**	Submodul:		cleansort()
//**	Version:		1.0				
//**	Beschreibung:	Bereinigen der Postionen der 
//**					Navigationpunkte 
//** ____________________________________________________________ 


function cleansort($parent)
{
    global $objConn;

    $tmptable = "tblcms_artikel";
    $posnr    = 1;
    $sql      = "SELECT id FROM " . $tmptable . " WHERE menuid=" . $parent . " ORDER BY pos";
    $res      = (new database())->send_sql($sql);
    if ($res->rowCount() != 0) {
        while ($row = $res->fetch()) {
            $posnr += 1;
            $sql = "UPDATE " . $tmptable . " SET pos = " . $posnr . " WHERE id=" . $row["id"];
            (new database())->send_sql($sql);
        }
    }
}

//** ____________________________________________________________ 
//**	Submodul:		sortup()
//**	Version:		1.0				
//**	Beschreibung:	H�herstufen eines Navigationspunktes
//** ____________________________________________________________ 

function sortup($tmpid1)
{
    global $objConn;

    $tmptable = "tblcms_artikel";

    $sql        = "SELECT menuid, pos FROM " . $tmptable . " WHERE id=" . $tmpid1;
    $res        = (new database())->send_sql($sql);
    $data       = $res->fetch();
    $tmppos1    = $data["pos"];
    $tmpparent1 = $data["menuid"];

    $tmppos2 = $tmppos1 - 1;
    $sql     = "SELECT id FROM " . $tmptable . " WHERE menuid=" . $tmpparent1 . " and pos=" . $tmppos2;
    $res     = (new database())->send_sql($sql);
    $data    = $res->fetch();
    $tmpid2  = $data["id"];

    $sql = "UPDATE " . $tmptable . " SET pos = " . $tmppos1 . " WHERE id=" . $tmpid2;
    (new database())->send_sql($sql);

    $sql = "UPDATE " . $tmptable . " SET pos = " . $tmppos2 . " WHERE id=" . $tmpid1;
    (new database())->send_sql($sql);
}


//** ____________________________________________________________
//**	Submodul:		edit_entry()
//**	Version:		1.0				
//**	Beschreibung:	Artikel bearbeiten
//** ____________________________________________________________ 

function edit_entry()
{
    $idate = date("Y-m-d");
    $sql   = "UPDATE tblcms_artikel SET titel = '" . $_POST["strtitle"] . "', publik = '" . $_POST["intpublik"] . "', date_edit = '" . $idate . "', userid = '" . $_SESSION["userid"] . "' WHERE ID=" . $_REQUEST["id"];

    return $sql;
}

//** ____________________________________________________________ 
//**	Submodul:		insert_new_entry()
//**	Version:		1.0				
//**	Beschreibung:	Neuen Artikel einf�gen
//** ____________________________________________________________ 

function insert_new_entry()
{
    $idate = date("Y-m-d");
    cleansort($_POST["navid"]);

    $sql = "INSERT INTO tblcms_artikel ( titel, menuid, date_new, date_edit, userid, publik, pos ) VALUES ( "
           . " '" . $_POST["strtitle"] . "', " . $_POST["navid"] . ", '" . $idate . "', '" . $idate . "', '" . $_SESSION["userid"] . "', '" . $_POST["intpublik"] . "', 1)";

    return $sql;
}

//** ____________________________________________________________ 
//**	Submodul:		insert_new_content()
//**	Version:		1.0				
//**	Beschreibung:	Neuen Inhalt anlegen
//** ____________________________________________________________ 

function insert_new_content()
{
    $idate = date("Y-m-d");
    if ($_POST["strcontent"] != "") {
        $content = str_replace("../../uploadfiles", "uploadfiles", $_POST["strcontent"]);
        $content = str_replace("\n", "<br>", $content);
    } else {
        $content = "";
    }

    $sql = "INSERT INTO tblcms_artikel_content ( content, artikelid, cmsbox, cmsboxtype, date_new, date_edit, userid ) VALUES ( "
           . " '" . $content . "', '" . $_POST["artikelid"] . "', '" . $_POST["cmsbox"] . "', '" . $_POST["cmsboxtype"] . "', '" . $idate . "', '" . $idate . "', '" . $_SESSION["userid"] . "')";

    return $sql;
}

//** ____________________________________________________________ 
//**	Submodul:		edit_content()
//**	Version:		1.0				
//**	Beschreibung:	Inhalt bearbeiten
//** ____________________________________________________________ 

function edit_content()
{
    $idate = date("Y-m-d");
    if ($_POST["strcontent"] != "") {
        $content = str_replace("../../uploadfiles", "uploadfiles", $_POST["strcontent"]);
        $content = str_replace("\n", "<br>", $content);
    } else {
        $content = "";
    }

    $sql = "UPDATE tblcms_artikel_content SET content = '" . $content . "', date_edit = '"
           . $idate . "', userid = '" . $_SESSION["userid"] . "' WHERE ID=" . $_POST["contentid"];

    return $sql;
}

//** ____________________________________________________________ 
//**	Submodul:		sitelink()
//**	Version:		1.0				
//**	Beschreibung:	Navigationspunkte anzeigen
//** ____________________________________________________________ 

function sitelink($pid)
{
    global $anhang;
    global $stable, $spath;
    global $objConn;

    $sql = "SELECT id, titel, ebene FROM tblcms_navigation where parentid=" . $pid . " ORDER BY pos";
    $res = (new database())->send_sql($sql);
    if ($res->rowCount() != 0) {
        $blankoption = "";
        while ($row = $res->fetch()) {
            $blankoption = str_repeat("&nbsp;", $row["ebene"] * 4);
            echo( "<option value=index.php?pageid=" . $row["id"] );
            echo( ">" . $blankoption . $row["titel"] . "</option>" );
            sitelink($row["id"]);
        }
    }
}


//** ____________________________________________________________ 
//**	Submodul:		documentlink()
//**	Version:		1.0				
//**	Beschreibung:	Dokumente anzeigen
//** ____________________________________________________________ 

function documentlink()
{
    global $objConn;

    $path  = "";
    $qpath = "";
    $sql   = "SELECT id, titel, rcfile, folder FROM tblcms_dokumente ORDER BY cfile";
    $res   = (new database())->send_sql($sql);
    if ($res->rowCount() != 0) {
        while ($row = $res->fetch()) {
            $path = "";
            if ($row["folder"] != 0) {
                $sql   = "SELECT titel, ordner FROM tblcms_folder WHERE id=" . $row["folder"];
                $res1  = (new database())->send_sql($sql);
                $data  = mysqli_fetch_array($res1);
                $path  = $data["titel"] . "/";
                $qpath = $data["ordner"] . "/";
            }
            echo( "<option value=" . $qpath . $row["rcfile"] );
            echo( ">" . $path . $row["titel"] . "</option>" );
        }
    }
}


//** ____________________________________________________________ 
//**	Submodul:		bildlink()
//**	Version:		1.0				
//**	Beschreibung:	Bilder anzeigen
//** ____________________________________________________________ 

function piclink()
{
    global $objConn;

    $path  = "";
    $qpath = "";
    $sql   = "SELECT id, titel, rcfile, folder FROM tblcms_bilder ORDER BY folder,cfile";
    $res   = (new database())->send_sql($sql);
    if ($res->rowCount() != 0) {
        while ($row = $res->fetch()) {
            $path = "";
            if ($row["folder"] != 0) {
                $sql   = "SELECT titel, ordner FROM tblcms_folder WHERE id=" . $row["folder"];
                $res1  = (new database())->send_sql($sql);
                $data  = mysqli_fetch_array($res1);
                $path  = $data["titel"] . "/";
                $qpath = $data["ordner"] . "/";
            }
            echo( "<option value=" . $qpath . $row["rcfile"] );
            echo( ">" . $path . $row["titel"] . "</option>" );
        }
    }
}

//** ____________________________________________________________ 
//**	Submodul:		bildlink()
//**	Version:		1.0				
//**	Beschreibung:	Bilder anzeigen
//** ____________________________________________________________ 

function picselect($content)
{
    global $objConn;

    $path  = "";
    $qpath = "";
    $sql   = "SELECT id, titel, rcfile, folder FROM tblcms_bilder ORDER BY folder,cfile";
    $res   = (new database())->send_sql($sql);
    if ($res->rowCount() != 0) {
        while ($row = $res->fetch()) {
            $path = "";
            if ($row["folder"] != 0) {
                $sql   = "SELECT titel, ordner FROM tblcms_folder WHERE id=" . $row["folder"];
                $res1  = (new database())->send_sql($sql);
                $data  = mysqli_fetch($res1);
                $path  = $data["titel"] . "/";
                $qpath = $data["ordner"] . "/";
            }
            echo( "<option value=" . $qpath . $row["rcfile"] );
            if ($qpath . $row["rcfile"] == $content) {
                echo " selected";
            }
            echo( ">" . $path . $row["titel"] . "</option>" );
        }
    }
}

?>