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
//**	Submodul:		foldertitel()
//**	Version:		1.0				
//**	Beschreibung:	Ermitteln des Ordnernamens
//** ____________________________________________________________ 

function folders()
	{
	$database = new database();

	$sql = "SELECT id, titel FROM tblvw_navigation WHERE navtyp='folder_list' ORDER BY titel";
	$res = $database->send_sql($sql);
	while ($row = $res->fetch())
		echo("<option value=".$row["id"].">".$row["titel"]."</option>");	
	}

		
//** ____________________________________________________________ 
//**	Submodul:		loadentrylist()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Ordner
//** ____________________________________________________________ 

function loadentrylist()
	{
	global $anhang;
	global $stable, $spath;
	$database = new database();
	
	$sql = "SELECT id, titel FROM tblvw_navigation WHERE navtyp='folder_list' ORDER BY titel";
	$res = $database->send_sql($sql);
	if ($res->rowCount()!=0)
		{
		while ($row  = $res->fetch())
			{
			echo ("<br><table width=617 border=0 cellspacing=0 cellpadding=0 class=table_border>");
			echo ("<tr>");
		    echo ("<td width=447 height=20 class=table_cell_right_bottom_head>&nbsp;".$row["titel"]."</td>");
		    echo ("<td width=80 height=20 class=table_cell_right_bottom_head align=center>angelegt am:</td>");
		    echo ("<td width=87 height=20 class=table_cell_bottom_head> &nbsp;Aktionen</td>");
			echo ("</tr>");
	
			$sql = "SELECT id, titel, date_new  FROM tblcms_folder WHERE typ=".$row["id"]." ORDER BY titel";
			$res2=$database->send_sql($sql);
			if ($res2->rowCount()!=0)
				{
				while ($row2 = $res2->fetch())
					{
					$jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";	
					$buttons = new listenbutton();
						$tdfunc1 = $buttons->entry_edit($row2["id"]);
						$tdfunc2 = $buttons->entry_delete($row2["id"], $stable, $spath, $row2["titel"], "__datafolder_delete.php");

					echo ("<tr ".$jstrover.">");
				    echo ("<td width=447 height=20 class=table_cell_right_bottom>&nbsp;");
					echo ("<a href=data_edit.php".$anhang."&action=edit&id=".$row2["id"]." target=funktion onClick=dateiload('head_save.php".$anhang."') class=txtlink>");
					echo $row2["titel"];
					echo ("</a></td>");
					echo ("<td width=80 height=20 align=center class=table_cell_right_bottom>".$row2["date_new"]."</td>");
					echo ("<td width=87 height=20 class=table_cell_bottom>".$tdfunc1.$tdfunc2."</td>");
					echo ("</tr>");			
					}
				}
			echo ("</table>");
			}
		}
	}
	
//** ____________________________________________________________ 
//**	Submodul:		insert_new_entry()
//**	Version:		1.0				
//**	Beschreibung:	Neuen Ordner anlegen
//** ____________________________________________________________ 
	
function insert_new_entry()
	{
	
//** Parameter definieren ---- **// 
	
	$idate = date("Y-m-d");
	if ($_POST["intfoldertyp"]=="100")
		mkdir("../../uploadfiles/documents/".$_POST["strpath"]);
	else
		mkdir("../../uploadfiles/pictures/".$_POST["strpath"]);
	
 	$sql = "INSERT INTO tblcms_folder ( titel, typ, ordner, date_new, userid ) VALUES ( '"
		.$_POST["strtitle"]."', '".$_POST["intfoldertyp"]."', '".$_POST["strpath"]."', '".$idate."', '".$_SESSION["userid"]."')";
	return $sql;
	

	}
	
//** ____________________________________________________________ 
//**	Submodul:		edit_entry_picture()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Elemente
//** ____________________________________________________________ 
	
function edit_entry()
	{
	
//** SQL-Anweisung ----------- **// 
	$sql = "UPDATE tblcms_folder SET "
		."titel = '".$_POST["strtitle"]."', "
		."userid = '".$_SESSION["userid"]."' "
		."WHERE ID=".$_POST["id"];

	return $sql;
		
//** ------------------------- **//
	}	

?>