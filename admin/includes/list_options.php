<?php

/**
 * Created by PhpStorm.
 * User: Cox
 * Date: 26.09.2016
 * Time: 21:05
 */
class listenbutton
{
//** ____________________________________________________________
    //**	Submodul:		entry_edit()
    //**	Version:		1.0
    //**	Beschreibung:	Button Eintrag l�schen
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_edit($id)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_edit.php".$anhang."&id=".$id."&action=edit";
        $temp = $temp." onClick=dateiload('head_save.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_edit.gif border=0 alt='Eintrag bearbeiten'></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_onoffline_button()
    //**	Beschreibung:	Button on-/offline
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_onoffline_button($publik, $id, $table, $path, $title, $filename)
    {
        global $anhang;

        $title = str_replace(" ", "&nbsp;", $title);
        if ($publik==1)
        {
            $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
            $temp = $temp."<a href=javascript:; onclick=loadwindow('../includes/".$filename.".php".$anhang;
            $temp = $temp."&id=".$id."&tmptable=".$table."&path=".$path."&title=".rawurlencode($title)."&status=0')>";
            $temp = $temp."<img src=../image_cms/ic_online.gif border=0 alt='Eintrag sperren'></a>";
        }
        else
        {
            $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
            $temp = $temp."<a href=javascript:; onclick=loadwindow('../includes/".$filename.".php".$anhang;
            $temp = $temp."&id=".$id."&tmptable=".$table."&path=".$path."&title=".rawurlencode($title)."&status=1')>";
            $temp = $temp."<img src=../image_cms/ic_offline.gif border=0 alt='Eintrag freischalten'></a>";
        }
        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_onoffline_text()
    //**	Beschreibung:	Textformatierung on-/offline
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_onoffline_text($publik)
    {
        if ($publik==1)
        { $temp = "txtonline";	}
        else
        { $temp = "txtoffline";	}
        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_delete()
    //**	Version:		1.0
    //**	Beschreibung:	Button Eintrag l�schen
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_delete($id, $table, $path, $title, $filename)
    {
        global $anhang;

        $title = str_replace(" ", "&nbsp;", $title);
        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=javascript:; onclick=loadwindow('../includes/".$filename.$anhang;
        $temp = $temp."&id=".$id."&tmptable=".$table."&path=".$path."&title=".rawurlencode($title)."');>";
        $temp = $temp."<img src=../image_cms/ic_delete.gif border=0 alt='Eintrag l&ouml;schen'></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_new_naventry()
    //**	Beschreibung:	Button Neuer Navigationspunkt
    //**	Anwendung:		nur Navigationsliste
    //** ____________________________________________________________

    function entry_new_naventry($id, $tree)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_edit.php".$anhang."&parentid=".$id."&treeid=".$tree;
        $temp = $temp." onClick=dateiload('head_save.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_newnav.gif border=0 alt='Neues Navigationselement'></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		rename_naventry()
    //**	Beschreibung:	Button Navigationspunkt umbennen
    //**	Anwendung:		nur Navigationsliste
    //** ____________________________________________________________

    function entry_rename($id)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_rename.php".$anhang."&id=".$id;
        $temp = $temp." onClick=dateiload('head_save.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_rename.gif border=0 alt='Eintrag umbenennen'></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		option_naventry()
    //**	Beschreibung:	Button Optionen Navigationspunkt
    //**	Anwendung:		nur Navigationsliste
    //** ____________________________________________________________

    function entry_option_naventry($id)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_option.php".$anhang."&id=".$id;
        $temp = $temp." onClick=dateiload('head_save.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_option.gif border=0 alt=Navigationsoptionen></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_edit()
    //**	Beschreibung:	Button Eintrag l�schen
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_rename_artikel($id)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_edit_art_add.php".$anhang."&id=".$id."&action=edit&navid=".$_REQUEST["navid"];
        $temp = $temp." onClick=dateiload('head_save.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_rename.gif border=0></a>";

        return $temp;
    }


    //** ____________________________________________________________
    //**	Submodul:		entry_sort()
    //**	Beschreibung:	Button Eintrag l�schen
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_sort($id,$pos)
    {
        global $anhang;

        if ($pos!=1)
            $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>"
                    ."<a href=data_list.php".$anhang."&action=sortup&id=".$id." target=funktion>"
                    ."<img src=../image_cms/ic_up.gif border=0 alt='Eintrag nach oben'></a>";
        else
            $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>"
                    ."<img src=../image_cms/ic_up_inactive.gif border=0 alt='Sortieren nicht m&ounl;glich'>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_edit()
    //**	Beschreibung:	Button Eintrag l�schen
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_edit_artikel($id)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_edit.php".$anhang."&id=".$id."&action=edit";
        $temp = $temp." onClick=dateiload('head_content.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_edit.gif border=0></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_option_template()
    //**	Beschreibung:	Button Eintrag l�schen
    //**	Anwendung:		alle Listen
    //** ____________________________________________________________

    function entry_option_template($id)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=data_option_list.php".$anhang."&id=".$id."&action=edit";
        $temp = $temp." onClick=dateiload('head_option.php".$anhang."') target=funktion>";
        $temp = $temp."<img src=../image_cms/ic_option.gif border=0 alt='Template einrichten'></a>";

        return $temp;
    }

    //** ____________________________________________________________
    //**	Submodul:		entry_option_cmsbox()
    //**	Beschreibung:	Button Optionen CMS-Box
    //**	Anwendung:		Konfigurationsmenu CMS-Box
    //** ____________________________________________________________

    function entry_option_cmsbox($id,$i,$configid,$fname)
    {
        global $anhang;

        $temp = "<img src=../image_cms/gr_blank.gif width=5 height=10 border=0>";
        $temp = $temp."<a href=".$fname.$anhang."&action=edit&templateid=".$id."&cmsbox=".$i;
        $temp = $temp."&id=".$configid." target=funktion ";
        $temp = $temp."onClick=dateiload('head_option_save.php".$anhang."&templateid=".$id."')>";
        $temp = $temp."<img src=../image_cms/ic_edit.gif border=0 alt='CMS-Box konfigurieren' width=16 height=20></a>";

        return $temp;
    }
}