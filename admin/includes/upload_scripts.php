<?php

/**
 * Created by PhpStorm.
 * User: Cox
 * Date: 26.09.2016
 * Time: 20:59
 */
class uploadscript
{
    public $database;

    function foldertitle($folderid)
    {
        $database = new database();

        if ($folderid != "") {
            $sql  = "SELECT titel FROM tblcms_folder WHERE id=" . $folderid;
            $res  = $database->send_sql($sql);
            $data = $res->fetch();

            return $data["titel"];
        } else {
            return "Hauptverzeichnis";
        }
    }

//** ____________________________________________________________
//**	Submodul:		folderpath()
//**	Version:		1.0
//**	Beschreibung:	Ermitteln des Ordnerpathes
//** ____________________________________________________________

    function folderpath($folderid)
    {
        $database = new database();

        $sql  = "SELECT ordner FROM tblcms_folder WHERE id=" . $folderid;
        $res  = $database->send_sql($sql);
        $data = $res->fetch();

        return $data["ordner"];
    }

//** ____________________________________________________________
//**	Submodul:		loadentrylist_picture()
//**	Version:		1.0
//**	Beschreibung:	Anzeigen aller Elemente vom Typ Bild
//** ____________________________________________________________

    function loadentrylist()
    {
        global $anhang;
        global $stable, $spath, $sub;
        $database = new database();

        if ($sub != "") {
            $sql = "SELECT id, titel, ftype, fsize, cfile, date_edit FROM " . $stable . " WHERE folder=" . $_GET["sub"] . " ORDER BY titel";
        } else {
            $sql = "SELECT id, titel, ftype, fsize, cfile, date_edit FROM " . $stable . " WHERE folder=0 ORDER BY titel";
        }

        $res = $database->send_sql($sql);
        if ($res->columnCount() != 0) {
            while ($row = $res->fetch()) {
                $jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";
                $buttons  = new listenbutton();
                $tdfunc1  = $buttons->entry_edit($row["id"]);
                $tdfunc2  = $buttons->entry_delete($row["id"], $stable, $spath, $row["cfile"], "__datafile_delete.php");

                echo( "<tr " . $jstrover . ">" );
                echo( "<td width=327 height=20 class=table_cell_right_bottom>&nbsp;" );
                echo( "<a href=data_edit.php" . $anhang . "&action=edit&id=" . $row["id"] . " target=funktion onClick=dateiload('head_save.php" . $anhang . "') class=txtlink>" );
                echo $row["titel"];
                echo( "</a></td>" );
                echo( "<td width=40 height=20 align=center class=table_cell_right_bottom>&nbsp;" . $row["ftype"] . "</td>" );
                echo( "<td width=80 height=20 align=center class=table_cell_right_bottom>" );
                echo ceil($row["fsize"] / 1000) . "&nbsp;kb</td>";
                echo( "<td width=80 height=20 align=center class=table_cell_right_bottom>" . $row["date_edit"] . "</td>" );
                echo( "<td width=87 height=20 class=table_cell_bottom>" . $tdfunc1 . $tdfunc2 . "</td>" );
                echo( "</tr>" );

            }
        }
    }


//** ____________________________________________________________
//**	Submodul:		insert_new_entry_picture()
//**	Version:		1.0
//**	Beschreibung:	Anzeigen aller Elemente
//** ____________________________________________________________

    function insert_new_entry_picture()
    {

//** Parameter definieren ---- **//

        $idate = date("Y-m-d");

        if ($_POST["sub"] != 0) {
            $picpath = "../../uploadfiles/pictures/" . $this->folderpath($_POST["sub"]) . "/";
            $sub     = $_POST["sub"];
        } else {
            $picpath = "../../uploadfiles/pictures/";
            $sub     = 0;
        }

        if ($_POST["strtitle"] != "") {
            $title = $_POST["strtitle"];
        } else {
            $title = $_FILES["pic"]["name"];
        }

//** ------------------------- **//

//** File-Upload ------------- **//

        $size  = $_FILES["pic"]["size"];
        $name  = $_FILES["pic"]["name"];
        $type  = substr($name, strlen($name) - 3, 3);
        $app   = $_FILES["pic"]["type"];
        $fname = date("dm_His") . "_" . $name;

        if ($size < 6000000 AND $size != 0) {
            move_uploaded_file($_FILES["pic"]["tmp_name"], "$picpath" . "$fname");
            $sizepv = getimagesize("$picpath" . "$fname");
            $width  = $sizepv[0];
            $height = $sizepv[1];
        }

//** ------------------------- **//

//** SQL-Anweisung ----------- **//

        $sql = "INSERT INTO tblcms_bilder ( titel, cfile, folder, rcfile, fsize, fheight, fwidth, ftype, fapplication, date_new, date_edit, userid ) VALUES ( '"
               . $title . "', '" . $name . "', " . $sub . ", '" . $fname . "', '" . $size . "', '" . $height . "', '" . $width . "', '" . $type . "', '" . $app . "', '" . $idate . "', '" . $idate . "', '" . $_SESSION["userid"] . "' )";

        return $sql;

//** ------------------------- **//

    }

//** ____________________________________________________________
//**	Submodul:		edit_entry_picture()
//**	Version:		1.0
//**	Beschreibung:	Anzeigen aller Elemente
//** ____________________________________________________________

    function edit_entry_picture()
    {

//** Parameter definieren ---- **//

        $idate = date("Y-m-d");

        if ($_POST["sub"] != 0) {
            $picpath = "../../uploadfiles/pictures/" . $this->folderpath($_POST["sub"]) . "/";
            $sub     = $_POST["sub"];
        } else {
            $picpath = "../../uploadfiles/pictures/";
            $sub     = 0;
        }

//** ------------------------- **//

//** File-Upload ------------- **//

        $size  = $_FILES["pic"]["size"];
        $name  = $_FILES["pic"]["name"];
        $type  = substr($name, strlen($name) - 3, 3);
        $app   = $_FILES["pic"]["type"];
        $fname = $_POST["realpicold"];

        if ($size < 6000000 AND $size != 0) {
            move_uploaded_file($_FILES["pic"]["tmp_name"], "$picpath" . "$fname");
            $sizepv = getimagesize("$picpath" . "$fname");
            $width  = $sizepv[0];
            $height = $sizepv[1];
        } else {
            $fname  = $_POST["realpicold"];
            $name   = $_POST["picold"];
            $size   = $_POST["sizeold"];
            $width  = $_POST["widthold"];
            $height = $_POST["heightold"];
            $type   = $_POST["typold"];
            $app    = $_POST["appold"];
        }

        if ($_POST["strtitle"] != "") {
            $title = $_POST["strtitle"];
        } else {
            $title = $name;
        }

//** ------------------------- **//

//** SQL-Anweisung ----------- **//


        $sql = "UPDATE tblcms_bilder SET "
               . "titel = '" . $title . "', "
               . "cfile = '" . $name . "', "
               . "rcfile = '" . $fname . "', "
               . "fsize = '" . $size . "', "
               . "fheight = '" . $height . "', "
               . "fwidth = '" . $width . "', "
               . "ftype = '" . $type . "', "
               . "fapplication = '" . $app . "', "
               . "date_edit = '" . $idate . "', "
               . "userid = '" . $_SESSION["userid"] . "' "
               . "WHERE ID=" . $_POST["id"];

        return $sql;

//** ------------------------- **//

    }

//** ____________________________________________________________
//**	Submodul:		insert_new_entry_document()
//**	Version:		1.0
//**	Beschreibung:	Hinzuf�gen eines neuen Dokumentes
//** ____________________________________________________________

    function insert_new_entry_document()
    {

//** Parameter definieren ---- **//

        $idate = date("Y-m-d");

        if ($_POST["sub"] != 0) {
            $docpath = "../../uploadfiles/documents/" . $this->folderpath($_POST["sub"]) . "/";
            $sub     = $_POST["sub"];
        } else {
            $docpath = "../../uploadfiles/documents/";
            $sub     = 0;
        }

        if ($_POST["strtitle"] != "") {
            $title = $_POST["strtitle"];
        } else {
            $title = $_FILES["doc"]["name"];
        }

//** ------------------------- **//

//** File-Upload ------------- **//

        $size  = $_FILES["doc"]["size"];
        $name  = $_FILES["doc"]["name"];
        $type  = substr($name, strlen($name) - 3, 3);
        $app   = $_FILES["doc"]["type"];
        $fname = date("dm_His") . "_" . $name;

        if ($size < 6000000 AND $size != 0) {
            move_uploaded_file($_FILES["doc"]["tmp_name"], "$docpath" . "$fname");
        }

//** ------------------------- **//

//** SQL-Anweisung ----------- **//

        $sql = "INSERT INTO tblcms_dokumente ( titel, cfile, folder, rcfile, fsize, ftype, fapplication, date_new, date_edit, userid ) VALUES ( '"
               . $title . "', '" . $name . "', " . $sub . ", '" . $fname . "', '" . $size . "', '" . $type . "', '" . $app . "', '" . $idate . "', '" . $idate . "', '" . $_SESSION["userid"] . "' )";

        return $sql;

//** ------------------------- **//

    }

//** ____________________________________________________________
//**	Submodul:		edit_entry_document()
//**	Version:		1.0
//**	Beschreibung:	Anzeigen aller Elemente
//** ____________________________________________________________

    function edit_entry_document()
    {

//** Parameter definieren ---- **//

        $idate = date("Y-m-d");

        if ($_POST["sub"] != 0) {
            $docpath = "../../uploadfiles/documents/" . $this->folderpath($_POST["sub"]) . "/";
            $sub     = $_POST["sub"];
        } else {
            $docpath = "../../uploadfiles/documents/";
            $sub     = 0;
        }

//** ------------------------- **//

//** File-Upload ------------- **//

        $size  = $_FILES["doc"]["size"];
        $name  = $_FILES["doc"]["name"];
        $type  = substr($name, strlen($name) - 3, 3);
        $app   = $_FILES["doc"]["type"];
        $fname = $_POST["realdocold"];

        if ($size < 6000000 AND $size != 0) {
            move_uploaded_file($_FILES["doc"]["tmp_name"], "$docpath" . "$fname");
        } else {
            $fname = $_POST["realdocold"];
            $name  = $_POST["docold"];
            $size  = $_POST["sizeold"];
            $type  = $_POST["typold"];
            $app   = $_POST["appold"];
        }

        if ($_POST["strtitle"] != "") {
            $title = $_POST["strtitle"];
        } else {
            $title = $name;
        }

//** ------------------------- **//

//** SQL-Anweisung ----------- **//


        $sql = "UPDATE tblcms_dokumente SET "
               . "titel = '" . $title . "', "
               . "cfile = '" . $name . "', "
               . "rcfile = '" . $fname . "', "
               . "fsize = '" . $size . "', "
               . "ftype = '" . $type . "', "
               . "fapplication = '" . $app . "', "
               . "date_edit = '" . $idate . "' ,"
               . "userid = '" . $_SESSION["userid"] . "' "
               . "WHERE ID=" . $_POST["id"];

        return $sql;

//** ------------------------- **//

    }

}