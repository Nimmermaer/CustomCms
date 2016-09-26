<?php
$useragent = $_SERVER['HTTP_USER_AGENT'];
$bot       = strpos($useragent, "bot");
if ($bot > 0) {
    ini_set('session.use_trans_sid', 0);
    $bot = 1;
} else {
    session_start();
}

include( "databasefunction.php" );

//** ------ Allgemeine Auswertung ------
global $pageid;
global $database;
$database = new database();

if (isset( $_REQUEST["pageid"] ) and intval($_REQUEST["pageid"]) > 0) {

    load_navpoints($_REQUEST["pageid"], 1);
    $pageid       = $_REQUEST["pageid"];
    $sql          = "SELECT * FROM tblcms_navigation where id=" . $pageid;
    $res          = $database->send_sql($sql);
    $data         = $res->fetch();
    $pagerefer    = $data["pagerefer"];
    $templateid   = $data["templateid"];
    $pagetitle    = $data["page_title"];
    $pagemetakey  = $data["page_meta_key"];
    $pagemetadesc = $data["page_meta_desc"];

    if ($bot == 1) {
        insert_session_bot();
    } else {
        insert_session($pageid);
    }
} else {
    $sql          = "SELECT * FROM tblcms_navigation where startseite=1";
    $res          = $database->send_sql($sql);
    $data         = $res->fetch();
    $pagerefer    = $data["pagerefer"];
    $templateid   = $data["templateid"];
    $pageid       = $data["id"];
    $pagetitle    = $data["page_title"];
    $pagemetakey  = $data["page_meta_key"];
    $pagemetadesc = $data["page_meta_desc"];

    if ($bot == 1) {
        insert_session_bot();
    } else {
        insert_session(0);
    }
}

//** ------ Umleitung ausf�hren ------

if ($pagerefer != "") {
    header("location: " . $pagerefer);
}


function cmsbox($nr)
{
    global $templateid;
    global $cbnr;
    $database = new database();

    $cbnr = $nr;
    $file = "";

    $sql       = "SELECT cmsbox" . $nr . " as boxtyp FROM tblcms_templates where id=" . $templateid;
    $res       = $database->send_sql($sql);
    $data      = $res->fetch();
    $cmsboxtyp = $data["boxtyp"];

    $sql  = "SELECT * FROM tblcms_module where id=" . $cmsboxtyp;
    $res  = $database->send_sql($sql);
    $data = $res->fetch();
    $file = $data["fileoutput"];

    if ($file != "" and is_readable("includes/" . $file)) {
        include( "includes/" . $file );
    }
}

function insert_session($pageid)
{

    $database   = new database();
    $idate      = date("Y-m-d");
    $itimestart = date("H:i:s");

    $sql = "SELECT * FROM tblcms_view_session WHERE ocd='" . session_id() . "'";
    $res = $database->send_sql($sql);
    if ($res->rowCount() == 0) {
        $refurl = "Direktaufruf";
        if (isset( $_SERVER["HTTP_REFERER"] ) OR $_SERVER["HTTP_REFERER"] != "") {
            $refurl = $_SERVER["HTTP_REFERER"];
        }
        if (array_key_exists("webreferer", $_GET)) {
            if (isset( $_GET["webreferer"] ) OR $_GET["webreferer"] != "") {
                $refurl = $_GET["webreferer"];
            }
        }


        $sql = "INSERT INTO tblcms_view_session (viewdate, timestart, timeend, view, ocd, referer, ipadr, agent ) VALUES ('" . $idate . "', '" . $itimestart . "', '" . $itimestart . "', 1, '" . session_id() . "', '" . $refurl . "', '" . getenv(REMOTE_ADDR) . "', '" . $_SERVER['HTTP_USER_AGENT'] . "' )";
        $database->send_sql($sql);

        $sql = "SELECT viewdate FROM tblcms_visitors WHERE viewdate='" . $idate . "'";
        $res = $database->send_sql($sql);
        if ($res->rowCount() == 0) {
            $sql = "INSERT INTO tblcms_visitors (viewdate, visits, views ) VALUES ('" . $idate . "', 1, 1 )";
            $database->send_sql($sql);
        } else {
            $sql = "UPDATE tblcms_visitors SET visits=visits+1, views=views+1 WHERE viewdate='" . $idate . "'";
            $database->send_sql($sql);
        }
    } else {
        $sql = "UPDATE tblcms_view_session SET timeend='" . $itimestart . "', view=view+1 WHERE ocd='" . session_id() . "'";
        $database->send_sql($sql);

        $sql = "UPDATE tblcms_visitors SET views=views+1  WHERE viewdate='" . $idate . "'";
        $database->send_sql($sql);
    }

    $sql = "UPDATE tblcms_navigation SET views=views+1 WHERE id=" . $pageid;
    $database->send_sql($sql);
}

function insert_session_bot()
{
    $database = new database();

    // ***** BESUCH EINTRAGEN -- SESSION
    $idate      = date("Y-m-d");
    $itimestart = date("H:i:s");

    $sql = "INSERT INTO tblcms_view_robots (viewdate, timestart, ipadr, agent ) VALUES ('" . $idate . "', '" . $itimestart . "', '" . getenv(REMOTE_ADDR) . "', '" . $_SERVER['HTTP_USER_AGENT'] . "' )";
    $database->send_sql($sql);
}

function load_navpoints($tmpmenu, $tmp)
{
    global $smenu, $sparent, $sebene, $stitel;
    global $srmenu, $srparent, $srebene, $location;
    $database = new database();

    $sql           = "SELECT * FROM tblcms_navigation WHERE id=" . $tmpmenu;
    $res           = $database->send_sql($sql);
    $data          = $res->fetch();
    $smenu[$tmp]   = $data["id"];
    $sparent[$tmp] = $data["parentid"];
    $sebene[$tmp]  = $data["ebene"];
    $stitel[$tmp]  = $data["titel"];

    if ($sebene[$tmp] > 1) {
        load_navpoints($sparent[$tmp], ++ $tmp);
    } else {
        $schleife = ++ $tmp;
        for ($i = 1; $i < $schleife; $i ++) {
            -- $tmp;
            if ($location != "") {
                $location = $location . " - " . $stitel[$tmp];
            } else {
                $location = $stitel[$tmp];
            }
            $srmenu[$i]   = $smenu[$tmp];
            $srparent[$i] = $sparent[$tmp];
            $srebene[$i]  = $sebene[$tmp];

        }
    }

}


function loadnavigation($pid, $tmpebene)
{
    global $srmenu, $srparent, $srebene;
    global $anhang, $sitelinkstandard;
    $database = new database();

    $sql = "SELECT * FROM tblcms_navigation where publik=1 and parentid=" . $pid . " ORDER BY pos";
    $res = $database->send_sql($sql);
    if ($res->rowCount() != 0) {
        while ($row = $res->fetch()) {
            $blank = $row["ebene"] * 4;
            echo str_repeat("&nbsp;", $blank);
            if ($row["page_url"] != "") {
                $pageurl = $row["page_url"] . ".htm";
            } else {
                $pageurl = "index.php?pageid=" . $row["id"];
            }
            if (isset( $srmenu[$tmpebene] )) {
                if ($row["id"] == $srmenu[$tmpebene]) {
                    echo( "<a class='navaktiv' href=" . $pageurl . ">" . $row["titel"] . "</a><br><br>" );
                    loadnavigation($row["id"], $tmpebene + 1);
                } else {
                    echo( "<a class=nav href=" . $pageurl . ">" . $row["titel"] . "</a><br><br>" );
                }
            } else {
                echo( "<a class=nav href=" . $pageurl . ">" . $row["titel"] . "</a><br><br>" );
            }
        }
    }
}

function loadnavigation_prim($pid, $tmpebene)
{
    global $srmenu, $srparent, $srebene;
    $database = new database();

    $sql = "SELECT * FROM tblcms_navigation where publik=1 and parentid=" . $pid . " ORDER BY pos";
    $res = $database->send_sql($sql);
    if ($res->rowCount() != 0) {
        $i = 0;
        while ($row = $res->fetch()) {
            if ($row["page_url"] != "") {
                $pageurl = $row["page_url"] . ".htm";
            } else {
                $pageurl = "index.php?pageid=" . $row["id"];
            }

            if ($i != 0) {
                echo( "<span class=navprim>&nbsp;|&nbsp;</span>" );
            }
            $i ++;
            $linkclass = "navprim";
            if ($row["id"] == $srmenu[$tmpebene]) {
                $linkclass = "navprimaktiv";
            }
            echo( "<a class=$linkclass href=" . $pageurl . ">" . $row["titel"] . "</a>" );
        }
    }
}


function loadseknavigation($pid, $tmpebene)
{
    global $srmenu, $srparent, $srebene;
    $database = new database();

    $sql = "SELECT * FROM tblcms_navigation where publik=1 and parentid=" . $pid . " ORDER BY pos";
    $res = $database->send_sql($sql);
    if ($res->rowCount() != 0) {
        while ($row = $res->fetch()) {
            $blank = ( $row["ebene"] - 2 ) * 2;

            if ($row["page_url"] != "") {
                $pageurl = $row["page_url"] . ".htm";
            } else {
                $pageurl = "index.php?pageid=" . $row["id"];
            }

            echo( "<tr><td width=8 height=20></td>\n" );
            if (isset( $srmenu[$tmpebene] )) {
                if ($row["id"] == $srmenu[$tmpebene]) {
                    echo( "<td width=100 height=20>" );
                    echo str_repeat("&nbsp;", $blank);
                    echo( "<a class=navsecactive href=" . $pageurl . ">" . $row["titel"] . "</a></td></tr>\n" );
                    echo( "<tr>\n" );
                    echo( "<td colspan=2 height=9></td>\n" );
                    echo( "</tr>\n" );
                    loadseknavigation($row["id"], $tmpebene + 1);
                } else {
                    echo( "<td width=100 height=20>" );
                    echo str_repeat("&nbsp;", $blank);
                    echo( "<a class=navsec href=" . $pageurl . ">" . $row["titel"] . "</a></td></tr>\n" );
                    echo( "<tr>\n" );
                    echo( "<td colspan=2 height=9></td>\n" );
                    echo( "</tr>\n" );
                }
            } else {
                echo( "<td width=100 height=20>" );
                echo str_repeat("&nbsp;", $blank);
                echo( "<a class=navsec href=" . $pageurl . ">" . $row["titel"] . "</a></td></tr>\n" );
                echo( "<tr>\n" );
                echo( "<td colspan=2 height=9></td>\n" );
                echo( "</tr>\n" );
            }

        }
    }
}

?>