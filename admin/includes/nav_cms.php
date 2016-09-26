<?php
//** ____________________________________________________________ 
//**	Modul:		Funktionen Navigationen CMS
//**	Subs:		- loadentrylist()
//**				- insert_new_entry()
//**				- edit_entry()
//**				- load_entry()
//** ____________________________________________________________ 

/* ____________________________________________________________ 
/*		Submodul:		navigation_prim()
/*		Version:		1.0				
/*		Beschreibung:	Prim�rnavigation aufbauen
/*	____________________________________________________________ */

function navigation_prim()
{
    global $anhang;

    $database = new database();
    $sql      = "SELECT id, titel FROM tblvw_navigation WHERE parentid=0 ORDER BY ID";
    $res      = $database->send_sql($sql);

    $stylenav  = 0;
    $startprim = 0;
    $nrprim    = $res->rowCount();

    while ($row = $res->fetch()) {
        $stylenav ++;
        if ($startprim == 0) {
            $navbckgrndimg = "image_cms/prim_start.gif";
            $startprim     = 1;
        } else {
            $navbckgrndimg = "image_cms/prim_middle.gif";
        }

        echo( "<td width=100 background=" . $navbckgrndimg . " align=center height=22>" );
        echo( "<a href=subnav.php" . $anhang . "&mainmenu=" . $row["id"] . " target=subnav class=nav_prim onClick=dateiloadsub();styleback('r" . $stylenav . "');>" );
        echo( "<div id=r" . $stylenav . ">" . $row["titel"] . "</div></a></td>" );
    }
    echo( "<td width=100% background=image_cms/prim_fill.gif align=center height=22><img src=image_cms/gr_blank.gif width=100% height=1></td>" );
    echo( "<td width=100 background=image_cms/prim_exit.gif align=center height=22 class=nav_prim><a href=exit/data_exit.php" . $anhang . " onClick=dateiloadexit() class=nav_primlogout target=funktion>Exit</a></td>" );
    echo( "</tr><tr>" );
    for ($i = 0; $i < $nrprim; $i ++) {
        echo( "<td width=100 align=center height=1><img src=image_cms/gr_blank.gif width=100 height=1></td>" );
    }

}

//** ____________________________________________________________ 
//**	Submodul:		data_seknavi()
//**	Version:		1.0				
//**	Beschreibung:	Daten der Sekund�r-Navigation
//** ____________________________________________________________ 

function data_seknavi()
{
    global $anhang;


    $mainmenu = 0;
    if (isset( $_GET["mainmenu"] )) {
        $mainmenu = $_GET["mainmenu"];
    }

    if ($mainmenu != "" || $mainmenu != 0) {
        $database   = new database();
        $sql        = "SELECT titel, navtyp FROM tblvw_navigation WHERE id=" . $mainmenu;
        $res        = $database->send_sql($sql);
        $data       = $res->fetch();
        $seknavhead = $data["titel"];
        $seknavtype = $data["navtyp"];

        head_seknavi($seknavhead);

        if ($seknavtype != "navliste") {
            menu_seknavi_standard();
        } else {
            menu_seknavi_navlist(0, 0);
        }

        bottom_seknavi();
    }
}

//** ____________________________________________________________ 
//**	Submodul:		head_seknavi()
//**	Version:		1.0				
//**	Beschreibung:	�berschrift sekund�rnavigation
//** ____________________________________________________________ 

function head_seknavi($titel)
{

    echo( "<tr>" );
    echo( "<td colspan=4 height=22 class=navsub_head background=image_cms/sub_top.gif>&nbsp;&nbsp;&nbsp;" . $titel . "</td>" );
    echo( "<td width=1 height=22><img src=image_cms/gr_lightgrey.gif width=1 height=22></td></tr>" );
    echo( "<tr>" );
    echo( "<td width=5>&nbsp;</td><td width=25>&nbsp;</td><td width=25>&nbsp;</td><td width=135>&nbsp;</td>" );
    echo( "<td width=1 height=10 class=navprim_border><img src=image_cms/gr_blank.gif width=1 height=10></td></tr>" );

}

//** ____________________________________________________________ 
//**	Submodul:		bottom_seknavi()
//**	Version:		1.0				
//**	Beschreibung:	�berschrift sekund�rnavigation
//** ____________________________________________________________ 	

function bottom_seknavi()
{

    echo( "<tr><td width=5>&nbsp;</td><td width=25>&nbsp;</td><td width=25>&nbsp;</td><td width=95>&nbsp;</td>" );
    echo( "<td width=1 height=10 class=navprim_border><img src=image_cms/gr_blank.gif width=1 height=10></td></tr>" );
    echo( "<tr><td colspan=4 height=22 class=navprim_bckgrnd><img src=image_cms/sub_bottom.gif width=190 height=22></td>" );
    echo( "<td width=1 height=22 class=navprim_border><img src=iimage_cms/gr_blank.gif width=1 height=1></td></tr>" );

}

//** ____________________________________________________________ 
//**	Submodul:		menu_seknavi_standard()
//**	Version:		1.0				
//**	Beschreibung:	Standardanzeige der Sekund�rnavigation
//** ____________________________________________________________ 	

function menu_seknavi_standard()
{
    global $anhang;
    $database = new database();
    $sql      = "SELECT id, parentid, icon, titel, verz, link, headline, navtyp FROM tblvw_navigation WHERE parentid=" . $_GET["mainmenu"] . " ORDER BY titel";
    $res      = $database->send_sql($sql);
    while ($row = $res->fetch()) {

        $iconshow = $row["icon"];
        echo( "<tr><td width=5 height=20>&nbsp;</td>" );
        echo( "<td width=25 height=20><img src=image_cms/" . $iconshow . ".gif width=20 height=20></td>" );
        echo( "<td width=160 height=20 colspan=2><a href=" . $row["verz"] . "/" . $row["link"] . $anhang . "&mainmenu=" . $row["id"] . " onClick=dateiload('" . $row["verz"] . "/" . $row["headline"] . $anhang . "&mainmenu=" . $row["id"] . "')  target=funktion class=linkprimnav>" );
        echo( $row["titel"] . "</a></td>" );
        echo( "<td width=1 height=20><img src=image_cms/gr_lightgrey.gif width=1 height=20></td></tr>" );

        if ($row["navtyp"] == "folder_list") {
            menu_seknavi_folder($row["id"], $row["verz"], $row["link"], $row["headline"]);
        }
    }
}

//** ____________________________________________________________ 
//**	Submodul:		menu_seknavi_folder()
//**	Version:		1.0				
//**	Beschreibung:	Anzeige von Ordner in der Sekund�rnavigation
//** ____________________________________________________________ 	

function menu_seknavi_folder($folderid, $folderverz, $folderlink, $folderhead)
{
    global $anhang;
    global $objConn;
    $database = new database();
    $sql      = "SELECT id, titel FROM tblcms_folder WHERE typ=" . $folderid . " ORDER BY titel";
    $res      = $database->send_sql($sql);
    while ($row = $res->fetch()) {
        echo( "<tr><td width=5 height=20>&nbsp;</td><td width=25 height=20>&nbsp;</td>" );
        echo( "<td width=160 height=20 colspan=2>&#149;&nbsp;<a href=" . $folderverz . "/" . $folderlink . $anhang . "&mainmenu=" . $folderid . "&sub=" . $row["id"] . " " );
        echo( "onClick=dateiload('" . $folderverz . "/" . $folderhead . $anhang . "&mainmenu=" . $folderid . "&sub=" . $row["id"] . "') target=funktion class=linkprimnav>" . $row["titel"] );
        echo( "</a></td>" );
        echo( "<td width=1 height=20><img src=image_cms/gr_lightgrey.gif width=1 height=20></td></tr>" );
    }
}

//** ____________________________________________________________ 
//**	Submodul:		menu_seknavi_navlist();
//**	Version:		1.0				
//**	Beschreibung:	Anzeige der CMS-Navigation im Sekund�rbereich
//** ____________________________________________________________ 	

function menu_seknavi_navlist($parent, $tree)
{
    global $anhang;
    $database = new database();
    $sql      = "SELECT id, titel, parentid, treeid, ebene FROM tblcms_navigation where parentid=" . $parent . " and treeid=" . $tree . " ORDER BY pos";
    $res      = $database->send_sql($sql);
    if ($res->rowCount() != 0) {
        $pos1 = $res->fetchColumn();
        while ($row = $res->fetch()) {
            $blank = $row["ebene"] * 2 - 2;

            echo( "<tr>" );
            echo( "<td width=5 height=15><img src=image_cms/gr_blank.gif width=5 height=15></td>" );

            if ($row["treeid"] == 0) {
                echo( "<td colspan=3 height=15>" );
                echo( "<b>" . $row["titel"] . "</b></td>" );
                $treeidmenu = $row["id"];
            } else {
                echo( "<td width=185 colspan=3 height=15>" );
                echo str_repeat("&nbsp;", $blank);
                echo( "&#149;&nbsp;<a href=content_artikel/data_list.php" . $anhang . "&navid=" . $row["id"] . " onClick=dateiload('content_artikel/head_add.php" . $anhang . "&navid=" . $row["id"] . "') target=funktion class=linkprimnav>" );
                echo( $row["titel"] );
                echo( "</a></td>" );
                $treeidmenu = $row["treeid"];
            }

            echo( "<td width=1 height=15><img src=image_cms/gr_lightgrey.gif width=1 height=15></td></tr>" );
            menu_seknavi_navlist($row["id"], $treeidmenu);
        }
    }
}

//** ____________________________________________________________ 
//**	Submodul:		pagestart()
//**	Version:		1.0				
//**	Beschreibung:	Seitenanfang
//** ____________________________________________________________ 

function pagestart($javascripts)
{
    echo( "<html>\n<head>\n" );
    echo( "<title>||~~ tentsys  ~~||</title>\n" );
    echo( "<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>\n" );
    echo( "<link rel=stylesheet href=ressourcen/css/custom.css type=text/css>\n" );
    if ($javascripts == 1) {
        load_javascripts();
    }
    echo( "</head>\n" );
    echo( "<body bgcolor=#FFFFFF text=#000000 leftmargin=0 topmargin=0>\n" );
}

//** ____________________________________________________________ 
//**	Submodul:		pageend()
//**	Version:		1.0				
//**	Beschreibung:	Seitenende
//** ____________________________________________________________ 

function pageend()
{
    echo( "</body>\n</html>\n" );
}

?>