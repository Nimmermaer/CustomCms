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
//**	Submodul:		loadentrylistmodule()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Module
//** ____________________________________________________________ 

function loadentrylistmodule()
	{
	global $anhang;
	global $stable, $spath;
	global $objConn;
	
	$sql = "SELECT id, titel, date_new, date_edit FROM tblcms_module ORDER BY titel";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		echo ("<br><table width=617 border=0 cellspacing=0 cellpadding=0 class=table_border>");
		echo ("<tr>");
	    echo ("<td width=367 height=20 class=table_cell_right_bottom_head>&nbsp;Modulbezeichnung</td>");
	    echo ("<td width=80 height=20 class=table_cell_right_bottom_head align=center>angelegt am:</td>");
	    echo ("<td width=80 height=20 class=table_cell_right_bottom_head align=center>ge�ndert am:</td>");
	    echo ("<td width=87 height=20 class=table_cell_bottom_head> &nbsp;Aktionen</td>");
		echo ("</tr>");
		while ($row  = $res->fetch())
			{
			$jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";	
			$buttons = new listenbutton();
				$tdfunc1 = $buttons->entry_edit($row["id"]);
				$tdfunc2 = $buttons->entry_delete($row["id"], $stable, $spath, $row["titel"], "__datamodul_delete.php");

			echo ("<tr ".$jstrover.">");
			echo ("<td width=367 height=20 class=table_cell_right_bottom>&nbsp;");
			echo ("<a href=data_edit.php".$anhang."&aktion=edit&id=".$row["id"]." target=funktion onClick=dateiload('head_save.php".$anhang."') class=txtlink>");
			echo $row["titel"];
			echo ("</a></td>");
			echo ("<td width=80 height=20 align=center class=table_cell_right_bottom>".$row["date_new"]."</td>");
			echo ("<td width=80 height=20 align=center class=table_cell_right_bottom>".$row["date_edit"]."</td>");
			echo ("<td width=87 height=20 class=table_cell_bottom>".$tdfunc1.$tdfunc2."</td>");
			echo ("</tr>");			
			}
		echo ("</table>");
		}
	}
	
//** ____________________________________________________________ 
//**	Submodul:		insert_new_entry_modul()
//**	Version:		1.0				
//**	Beschreibung:	Neues Modul anlegen
//** ____________________________________________________________ 
	
function insert_new_entry_modul()
	{
	//** Parameter definieren ---- **// 
	$idate = date("Y-m-d");

	//** File-Upload ------------- **// 
	$inputpath =  "../content_artikel/includes/";
	$outputpath =  "../../includes/";
    $nameinput = $_FILES["strinput"]["name"];
	$sizeinput = $_FILES["strinput"]["size"];
    $nameoutput = $_FILES["stroutput"]["name"];
	$sizeoutput = $_FILES["stroutput"]["size"];
    if($sizeinput<6000000 AND $sizeinput!=0)
		move_uploaded_file($_FILES["strinput"]["tmp_name"],"$inputpath"."$nameinput");
    if($sizeoutput<6000000 AND $sizeoutput!=0)
		move_uploaded_file($_FILES["stroutput"]["tmp_name"],"$outputpath"."$nameoutput");

	//** SQL-Anweisung ----------- **// 
 	$sql = "INSERT INTO tblcms_module ( titel, fileinput, fileoutput, date_new, date_edit, userid ) VALUES ( '"
		.$_POST["strtitle"]."', '".$nameinput."', '".$nameoutput."', '".$idate."', '".$idate."', '".$_SESSION["userid"]."')";
	return $sql;

	//** ------------------------- **//	
	}


	
//** ____________________________________________________________ 
//**	Submodul:		edit_entry_module()
//**	Version:		1.0				
//**	Beschreibung:	Ge�ndertes Module speichern
//** ____________________________________________________________ 
	
function edit_entry_modul()
	{
	//** Parameter definieren ---- **// 
	$idate = date("Y-m-d");
	//** File-Upload ------------- **// 
	$inputpath =  "../content_artikel/includes/";
	$outputpath =  "../../includes/";
    $nameinput = $_FILES["strinput"]["name"];
	$sizeinput = $_FILES["strinput"]["size"];
    $nameoutput = $_FILES["stroutput"]["name"];
	$sizeoutput = $_FILES["stroutput"]["size"];
    if($sizeinput<6000000 AND $sizeinput!=0)
		move_uploaded_file($_FILES["strinput"]["tmp_name"],"$inputpath"."$nameinput");
	else
		$nameinput = $_POST["strinputold"];
    if($sizeoutput<6000000 AND $sizeoutput!=0)
		move_uploaded_file($_FILES["stroutput"]["tmp_name"],"$outputpath"."$nameoutput");
	else
		$nameoutput = $_POST["stroutputold"];

	
	//** SQL-Anweisung ----------- **// 
	$sql = "UPDATE tblcms_module SET "
		."titel = '".$_POST["strtitle"]."', "
		."fileinput = '".$nameinput."', "
		."fileoutput = '".$nameoutput."', "
		."date_edit = '".$idate."', "
		."userid = '".$_SESSION["userid"]."' "		
		."WHERE ID=".$_POST["id"];

	return $sql;
	//** ------------------------- **//
	}	



//** ____________________________________________________________ 
//**	Submodul:		loadentrylisttemplates()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Seitentemplates
//** ____________________________________________________________ 

function loadentrylisttemplates()
	{
	global $anhang;
	global $stable, $spath;
	global $objConn;
	
	$jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";
	
	$sql = "SELECT id, titel, publik, date_new, date_edit FROM tblcms_templates ORDER BY titel";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		echo ("<br><table width=617 border=0 cellspacing=0 cellpadding=0 class=table_border>");
		echo ("<tr>");
	    echo ("<td width=367 height=20 class=table_cell_right_bottom_head>&nbsp;Templatebezeichnung</td>");
	    echo ("<td width=80 height=20 class=table_cell_right_bottom_head align=center>angelegt am:</td>");
	    echo ("<td width=80 height=20 class=table_cell_right_bottom_head align=center>ge�ndert am:</td>");
	    echo ("<td width=87 height=20 class=table_cell_bottom_head> &nbsp;Aktionen</td>");
		echo ("</tr>");
		while ($row  = $res->fetch())
			{
			$buttons = new listenbutton();
				$tdfunc1 = $buttons->entry_edit($row["id"]);
				$tdfunc2 = $buttons->entry_option_template($row["id"]);
				$tdfunc3 = $buttons->entry_delete($row["id"], $stable, $spath, $row["titel"], "__datatemplate_delete.php");
				$tdfunc4 = $buttons->entry_onoffline_button($row["publik"], $row["id"], $stable, $spath, $row["titel"], "__datacontent_lock");
				$tdclass = $buttons->entry_onoffline_text($row["publik"]);
						
			echo ("<tr ".$jstrover.">");
			echo ("<td width=367 height=20 class=table_cell_right_bottom>&nbsp;");
			echo ("<a href=data_edit.php".$anhang."&aktion=edit&id=".$row["id"]." target=funktion onClick=dateiload('head_save.php".$anhang."') class=".$tdclass.">");
			echo $row["titel"];
			echo ("</a></td>");
			echo ("<td width=80 height=20 align=center class=table_cell_right_bottom>".$row["date_new"]."</td>");
			echo ("<td width=80 height=20 align=center class=table_cell_right_bottom>".$row["date_edit"]."</td>");
			echo ("<td width=87 height=20 class=table_cell_bottom>".$tdfunc1.$tdfunc2.$tdfunc3.$tdfunc4."</td>");
			echo ("</tr>");			
			}
		echo ("</table>");
		}
	}

//** ____________________________________________________________ 
//**	Submodul:		insert_new_entry_templates()
//**	Version:		1.0				
//**	Beschreibung:	Geändertes Template speichern
//** ____________________________________________________________ 

function insert_new_entry_templates()
	{
	$idate = date("Y-m-d");

	$sql = "INSERT INTO tblcms_templates ( titel, tb0, ";
	for ($i=0; $i<10; $i++)
		$sql = $sql."cmsbox".$i.", ";
	$sql = $sql."date_new, date_edit, publik, userid ) VALUES ( "
		." '".$_POST["strtitle"]."', '".str_replace("\n", "<br>", $_POST["memtb0"])."', ";
	for ($i=0; $i<10; $i++)
		$sql = $sql."'".$_POST["strcmsbox".$i]."', ";
	$sql = $sql."'".$idate."', '".$idate."', '".$_POST["intpublik"]."', '".$_SESSION["userid"]."')";
	return $sql;
	//** ------------------------- **//	
	}

//** ____________________________________________________________ 
//**	Submodul:		edit_entry_templates()
//**	Version:		1.0				
//**	Beschreibung:	Geändertes Template speichern
//** ____________________________________________________________ 

function edit_entry_templates()
	{
	$idate = date("Y-m-d");
	
	$sql = "UPDATE tblcms_templates SET "
		."titel = '".$_POST["strtitle"]."', "		
		."tb0 = '".str_replace("\n", "<br>", $_POST["memtb0"])."', ";		
	for ($i=0; $i<10; $i++)
		$sql = $sql."cmsbox".$i." = '".$_POST["strcmsbox$i"]."', ";
	$sql = $sql."date_edit = '".$idate."', "
		."publik = '".$_POST["intpublik"]."', "
		."userid = '".$_SESSION["userid"]."' "
		."WHERE ID=".$_POST["id"];

	return $sql;
	//** ------------------------- **//	
	}


//** ____________________________________________________________ 
//**	Submodul:		loadentrylisttemplateconfig()
//**	Version:		1.0				
//**	Beschreibung:	Konfiguration eines Seitentemplates
//** ____________________________________________________________ 

function loadentrylisttemplateconfig()
	{
	global $anhang;
	global $objConn;
	
	$sql = "SELECT * FROM tblcms_templates WHERE id=".$_REQUEST["id"];
	$res = (new database())->send_sql($sql);
	$data = $res->fetch();
	for ($i=0; $i<10; $i++)
		$cmsbox[$i] = $data["cmsbox".$i];

	echo ("<br><table width=617 border=0 cellspacing=0 cellpadding=0 class=table_border>");
	echo ("<tr>");
	echo ("<td width=267 height=20 class=table_cell_right_bottom_head colspan=2>&nbsp;CMS-Box</td>");
	echo ("<td width=260 height=20 class=table_cell_right_bottom_head align=center>&nbsp;</td>");
	echo ("<td width=87 height=20 class=table_cell_bottom_head>&nbsp;Aktion</td>");
	echo ("</tr>");
		
	for ($i=0; $i<10; $i++)
		{
		if ($cmsbox[$i]!="0")
			{
			$jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";	

			switch ($cmsbox[$i])
				{
				case 2:
					$navpoint = "";
					$configid = "";
					$sql = "SELECT id, navid FROM tblcms_templates_config WHERE templateid=".$_REQUEST["id"]." AND cmsboxnr=".$i;
					$res = (new database())->send_sql($sql);
					if ($res->rowCount()!=0)
						{
						$data = $res->fetch();
						$sql = "SELECT titel FROM tblcms_navigation WHERE id=".$data["navid"];
						$res2=(new database())->send_sql($sql);
						$data2 = mysqli_fetch($res2);
							$navpoint = "von ".$data2["titel"];
							$configid = $data["id"];
						}
					if ($navpoint=="von " || $navpoint=="" ) 
						$navpoint="nicht konfiguriert";

					$buttons = new listenbutton();
						$tdfunc1 = $buttons->entry_option_cmsbox($_REQUEST["id"],$i,$configid,"data_option_edit_artikelliste.php");
						
					echo ("<tr ".$jstrover.">");
					echo ("<td width=20 height=20 class=table_cell_right_bottom align=right>".$i."&nbsp;</td>");
					echo ("<td width=247 height=20 class=table_cell_right_bottom>&nbsp;".titel_cmsbox($cmsbox[$i])."</td>");
					echo ("<td width=260 height=20 align=center class=table_cell_right_bottom>".$navpoint."</td>");
					echo ("<td width=87 height=20 class=table_cell_bottom>".$tdfunc1."</td>");
					echo ("</tr>");			
					break;	

				case 5:
					$navpoint = "";
					$configid = "";
					$sql = "SELECT id, navid FROM tblcms_templates_config WHERE templateid=".$_REQUEST["id"]." AND cmsboxnr=".$i;
					$res = (new database())->send_sql($sql);
					if ($res->rowCount()!=0)
						{
						$data = $res->fetch();
						$sql = "SELECT titel FROM tblcms_navigation WHERE id=".$data["navid"];
						$res2=(new database())->send_sql($sql);
						$data2 = mysqli_fetch($res2);
							$navpoint = "von ".$data2["titel"];
							$configid = $data["id"];
						}
					if ($navpoint=="von " || $navpoint=="" ) 
						$navpoint="nicht konfiguriert";

					$buttons = new listenbutton;
						$tdfunc1 = $buttons->entry_option_cmsbox($_REQUEST["id"],$i,$configid,"data_option_edit_navigation.php");
						
					echo ("<tr ".$jstrover.">");
					echo ("<td width=20 height=20 class=table_cell_right_bottom align=right>".$i."&nbsp;</td>");
					echo ("<td width=247 height=20 class=table_cell_right_bottom>&nbsp;".titel_cmsbox($cmsbox[$i])."</td>");
					echo ("<td width=260 height=20 align=center class=table_cell_right_bottom>".$navpoint."</td>");
					echo ("<td width=87 height=20 class=table_cell_bottom>".$tdfunc1."</td>");
					echo ("</tr>");			
					break;
					
				case 6:
					$navpoint = "";
					$configid = "";
					$sql = "SELECT id, navid FROM tblcms_templates_config WHERE templateid=".$_REQUEST["id"]." AND cmsboxnr=".$i;
					$res = (new database())->send_sql($sql);
					if ($res->rowCount()!=0)
						{
						$data = $res->fetch();
						$sql = "SELECT titel FROM tblcms_navigation WHERE id=".$data["navid"];
						$res2=(new database())->send_sql($sql);
						$data2 = mysqli_fetch($res2);
							$navpoint = "von ".$data2["titel"];
							$configid = $data["id"];
						}
					if ($navpoint=="von " || $navpoint=="" ) 
						$navpoint="nicht konfiguriert";

					$buttons = new listenbutton;
						$tdfunc1 = $buttons->entry_option_cmsbox($_REQUEST["id"],$i,$configid,"data_option_edit_navigation.php");
						
					echo ("<tr ".$jstrover.">");
					echo ("<td width=20 height=20 class=table_cell_right_bottom align=right>".$i."&nbsp;</td>");
					echo ("<td width=247 height=20 class=table_cell_right_bottom>&nbsp;".titel_cmsbox($cmsbox[$i])."</td>");
					echo ("<td width=260 height=20 align=center class=table_cell_right_bottom>".$navpoint."</td>");
					echo ("<td width=87 height=20 class=table_cell_bottom>".$tdfunc1."</td>");
					echo ("</tr>");			
					break;	

				default:
					echo ("<tr>");
					echo ("<td width=20 height=20 class=table_cell_right_bottom align=right>".$i."&nbsp;</td>");
					echo ("<td width=247 height=20 class=table_cell_right_bottom>&nbsp;".titel_cmsbox($cmsbox[$i])."</td>");
					echo ("<td width=260 height=20 align=center class=table_cell_right_bottom>&nbsp;</td>");
					echo ("<td width=87 height=20 class=table_cell_bottom>&nbsp;</td>");
					echo ("</tr>");			
					break;	
				}
			}
		}
		echo ("</table>");
	}
	

//** ____________________________________________________________ 
//**	Submodul:		module_load()
//**	Version:		1.0				
//**	Beschreibung:	Module laden und in Array speichern
//** ____________________________________________________________ 
	
function module_load()
	{
	global $arr_modul;
	global $objConn;
	
	$sql = "SELECT id, titel FROM tblcms_module ORDER BY titel";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		while ($row  = $res->fetch())
			$arr_modul[] = array( "id"=>$row["id"],  "titel"=>$row["titel"]);
		}
	}	
	
//** ____________________________________________________________ 
//**	Submodul:		module_show()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen der Module in Dropdownliste
//** ____________________________________________________________ 
	
function module_show($tmpmodul)
	{
	global $arr_modul;
	
	foreach ($arr_modul as $modul)
		{
		echo ("<option value='".$modul["id"]."' ");
		if ($tmpmodul==$modul["id"])
			echo "selected";
		echo (">".$modul["titel"]."</option>");
		}
	}	
//** ____________________________________________________________ 
//**	Submodul:		loadtemplates()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen der Templates in Dropdownliste
//** ____________________________________________________________ 

function loadtemplates($tmptemplate)
	{
	global $objConn;

	$sql = "SELECT id, titel FROM tblcms_templates WHERE publik=1 ORDER BY titel";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		while ($row  = $res->fetch())
			{
			echo ("<option value='".$row["id"]."' ");
			if ($tmptemplate==$row["id"])
				echo "selected";
			echo (">".$row["titel"]."</option>");
			}
		}
	}		

//** ____________________________________________________________ 
//**	Submodul:		edit_entry_template_standard_back()
//**	Version:		1.0				
//**	Beschreibung:	Zur�cksetzen des Standardtemplates
//** ____________________________________________________________ 
	
function edit_entry_template_standard_back()
	{
	$sql = "UPDATE tblcms_templates SET standard=0";
	return $sql;
	}	
	
//** ____________________________________________________________ 
//**	Submodul:		edit_entry_template_standard()
//**	Version:		1.0				
//**	Beschreibung:	Aktualisieren des Standardtemplates
//** ____________________________________________________________ 
	
function edit_entry_template_standard()
	{
	$sql = "UPDATE tblcms_templates SET standard=1 where id=".$_POST["intstandard"];
	return $sql;
	}	
		
//** ____________________________________________________________ 
//**	Submodul:		titel_cmsbox()
//**	Version:		1.0				
//**	Beschreibung:	Button Eintrag l�schen
//**	Anwendung:		alle Listen
//** ____________________________________________________________ 

function titel_cmsbox($id)
	{
	global $objConn;

	$sql = "SELECT titel from tblcms_module WHERE id=".$id;
	$res = (new database())->send_sql($sql);
	$data = $res->fetch();
		return $data["titel"];
	}	
	
//** ____________________________________________________________ 
//**	Submodul:		update_template_config_navigation()
//**	Version:		1.0				
//**	Beschreibung:	Navigation CMSBox aktualiseren
//** ____________________________________________________________ 	

function update_template_config_navigation()
	{
	//** Parameter definieren ---- **// 
	$idate = date("Y-m-d");
	
	$sql = "UPDATE tblcms_templates_config SET "
		."navid = ".$_POST["strnavid"].", "
		."date_edit = '".$idate."', "
		."userid = '".$_SESSION["userid"]."' "		
		."WHERE id=".$_POST["id"];
	return $sql;			
	}
	
//** ____________________________________________________________ 
//**	Submodul:		insert_template_config_navigation()
//**	Version:		1.0				
//**	Beschreibung:	Navigation CMSBox hinzuf�gen
//** ____________________________________________________________ 	

function insert_template_config_navigation()
	{
	//** Parameter definieren ---- **// 
	$idate = date("Y-m-d");
	
	$sql = "INSERT INTO tblcms_templates_config ( templateid, cmsboxnr, navid, listanz, listoption, date_edit, userid ) VALUES ("
		.$_POST["templateid"].", ".$_POST["cmsbox"].", ".$_POST["strnavid"].", 0, '0', '".$idate."', '".$_SESSION["userid"]."' )";
	return $sql;			
	}	
	
//** ____________________________________________________________ 
//**	Submodul:		update_template_config_artikel()
//**	Version:		1.0				
//**	Beschreibung:	Artikeliste CMSBox aktualiseren
//** ____________________________________________________________ 	

function update_template_config_artikel()
	{
	//** Parameter definieren ---- **// 
	$idate = date("Y-m-d");
	
	$sql = "UPDATE tblcms_templates_config SET "
		."navid = ".$_POST["strnavid"].", "
		."listanz = ".$_POST["strlistanz"].", "			
		."listoption = '".$_POST["strlistoption"]."', "
		."date_edit = '".$idate."', "
		."userid = '".$_SESSION["userid"]."' "		
		."WHERE id=".$_POST["id"];
	return $sql;					
	}
	
//** ____________________________________________________________ 
//**	Submodul:		insert_template_config_artikel()
//**	Version:		1.0				
//**	Beschreibung:	Artikeliste CMSBox hinzuf�gen
//** ____________________________________________________________ 	

function insert_template_config_artikel()
	{
	//** Parameter definieren ---- **// 
	$idate = date("Y-m-d");

	$sql = "INSERT INTO tblcms_templates_config ( templateid, cmsboxnr, navid, listanz, listoption, date_edit, userid ) VALUES ("
		.$_POST["templateid"].", ".$_POST["cmsbox"].", ".$_POST["strnavid"].", '".$_POST["strlistanz"]."', '".$_POST["strlistoption"]."', '".$idate."', '".$_SESSION["userid"]."' )";
	return $sql;			
	}	
	
//** ____________________________________________________________ 
//**	Submodul:		select_navigation()
//**	Version:		1.0				
//**	Beschreibung:	Navigationspunktauswahl
//** ____________________________________________________________ 

function select_navigation($pid,$value)
	{
	global $anhang;
	global $stable, $spath;
	global $objConn;

	$sql = "SELECT id, titel, ebene FROM tblcms_navigation WHERE parentid=".$pid." ORDER BY pos";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		$blankoption="";			
		while ($row  = $res->fetch())
			{
			$blank=$row["ebene"]*4;				
			echo ("<option value=".$row["id"]);
			if ($row["id"]==$value) { echo " selected"; }						
			echo (">".str_repeat("&nbsp;", $blank).$row["titel"]."</option>");
			select_navigation($row["id"],$value);
			}
		}
			

	}		
	
//** ____________________________________________________________ 
//**	Submodul:		select_navbaum()
//**	Version:		1.0				
//**	Beschreibung:	Seitenweiterleitungen
//** ____________________________________________________________ 

function select_navigation_baum($value)
	{
	global $objConn;
	
	$sql = "SELECT id, titel FROM tblcms_navigation where parentid=0 and treeid=0 ORDER BY pos";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		while ($row  = $res->fetch())
			{
			echo ("<option value=".$row["id"]);
			if ($row["id"]==$value) { echo " selected"; }						
			echo (">".$row["titel"]."</option>");
			}
		}
	}					
?>