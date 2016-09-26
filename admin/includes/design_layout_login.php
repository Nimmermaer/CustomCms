<?php
//** ____________________________________________________________
//**	Modul:		Seitenaufbau Contentbereich
//**	Subs:		- boxhead()
//**				- boxdown()
//**				- pagestart()
//**				- pageend()
//** ____________________________________________________________

//** ____________________________________________________________
//**	Submodul:		pagestart()
//**	Version:		1.0
//**	Beschreibung:	Seitenanfang
//** ____________________________________________________________

class designlayoutlogin
{
    function pagestart()
    {
        echo( "<html>\n<head>\n" );
        echo( "<title>Custom CMS</title>\n" );
        echo( "<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>\n" );
        echo( "<link rel='stylesheet' href='ressourcen/css/bootstrap.min.css' type='text/css'>\n" );
        echo( "<link rel='stylesheet' href='ressourcen/css/custom.css' type='text/css'>\n" );
        echo( "<script language='javascript' type='text/javascript' src='ressourcen/bootstrap.js'></script>\n" );
        echo( "</head>\n" );
        echo( "<body bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0'>\n" );
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

}