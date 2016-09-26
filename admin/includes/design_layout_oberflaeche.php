<?php
//** ____________________________________________________________ 
//**	Modul:		Seitenaufbau Contentbereich
//**	Subs:		- boxhead()
//**				- boxdown()
//**				- pagestart()
//**				- pageend()
//** ____________________________________________________________ 


class designlayout
{

    //** ____________________________________________________________
    //**	Submodul:		pagestart()
    //**	Beschreibung:	Seitenanfang
    //** ____________________________________________________________

    function pagestart($javascripts)
    {
        echo( "<html>\n<head>\n" );
        echo( "<title>|| Content Management System ||</title>\n" );
        echo( "<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>\n" );
        echo( "<link rel=stylesheet href=../ressourcen/css/custom.css type=text/css>\n" );
        if ($javascripts == 1) {
            load_javascripts();
        }
        echo( "</head>\n" );
        echo( "<body bgcolor=#FFFFFF text=#000000 leftmargin=0 topmargin=0>\n" );
    }

    //** ____________________________________________________________
    //**	Submodul:		pageend()
    //**	Beschreibung:	Seitenende
    //** ____________________________________________________________

    function pageend()
    {
        echo( "</body>\n</html>\n" );
    }

    //** ____________________________________________________________
    //**	Submodul:		boxhead()
    //**	Beschreibung:	Box mit �berschrift
    //** ____________________________________________________________

    function boxhead($title, $breite)
    {
        $laybreite = $breite - 20;
        echo( "<table width=" . $breite . " border=0 cellpadding=0 cellspacing=0>" );
        echo( "<tr><td colspan=2 height=10></td></tr>" );
        echo( "<tr><td rowspan=3 width=20><img src=../image_cms/gr_blank.gif width=20></td>" );
        echo( "<td height=24 width=" . $laybreite . " class=table_headline><img src=../image_cms/gr_arrow_down.gif>" . $title . "</td></tr>" );
        echo( "<tr><td></td></tr>" );
        echo( "<tr><td width=" . $laybreite . " class=content_bckgrnd ><br>" );
    }

    //** ____________________________________________________________
    //**	Submodul:		boxdown()
    //**	Beschreibung:	Boxende
    //** ____________________________________________________________

    function boxdown($breiteleer, $breite)
    {
        echo( "</td></tr>" );
        echo( "<tr><td colspan=2 height=20>&nbsp;</td></tr></table>" );
    }

}