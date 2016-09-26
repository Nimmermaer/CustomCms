<?php
//** ____________________________________________________________ 
//**	Modul:		Navigations-Funktionen
//**	Subs:		- loadnavigation()
//**				- cleansort()
//**				- sortup()
//**				- insert_new_naventry()
//** ____________________________________________________________ 


//** ____________________________________________________________ 
//**	Submodul:		loadnavigationtrees()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Navigationsb�ume
//** ____________________________________________________________ 

function loadnavigationtrees()
	{
	global $anhang;
	global $stable, $spath;		
	global $objConn;
		
		$sql = "SELECT id, titel FROM tblcms_navigation WHERE parentid=0 and treeid=0 ORDER BY pos";
		$res = (new database())->send_sql($sql);
		while ($row  = $res->fetch())
			{
			$tdfunc1 = "";
			$tdfunc2 = "";
			$tdfunc3 = "";
			$buttons = new listenbutton();
				$tdfunc1 = $buttons->entry_new_naventry($row["id"],$row["id"]);
				$tdfunc2 = $buttons->entry_rename($row["id"]);
				$tdfunc3 = $buttons->entry_delete($row["id"], $stable, $spath, rawurlencode($row["titel"]), "__datanav_delete.php");

			echo ("<table width=627 border=0 cellspacing=0 cellpadding=0 class=table_border>\n");
			echo ("<tr>\n"); 
			echo ("<td width=327 height=24 class=table_cell_right_bottom_head>&nbsp;".$row["titel"]."</td>\n");
			echo ("<td height=24 class=table_cell_right_bottom_head align=center width=30>".$tdfunc1."</td>\n");
    		echo ("<td height=24 class=table_cell_right_bottom_head width=70> &nbsp; </td>\n");
			echo ("<td height=24 class=table_cell_bottom_head width=100>".$tdfunc2.$tdfunc3."</td>\n");
			echo ("</tr>\n");
			loadnavigation($row["id"],$row["id"]);
			echo ("</table>\n"); 
			echo ("<br>\n");
			}
	}

//** ____________________________________________________________ 
//**	Submodul:		loadnavigation()
//**	Version:		1.0				
//**	Beschreibung:	Anzeigen aller Navigationsebenen
//** ____________________________________________________________ 

function loadnavigation($pid,$treeid)
	{
	global $anhang;
	global $stable, $spath;
	global $objConn;

	$jstrover = "onmouseover=setPointeron(this) onmouseout=setPointeroff(this)";
	
	$sql = "SELECT id, parentid, treeid, ebene, titel, publik, pos FROM tblcms_navigation where parentid=".$pid." and treeid=".$treeid." ORDER BY pos";
	$res = (new database())->send_sql($sql);
	if ($res->rowCount()!=0)
{
	//http://stackoverflow.com/questions/26137972/php-pdo-alternative-for-mysqli-num-rows
		$pos1 = $res->fetchColumn();
		while ($row  = $res->fetch())
			{
			$blank=$row["ebene"]*4;
			$tdfunc1 = "";
			$tdfunc2 = "";
			$tdfunc3 = "";
			$tdfunc4 = "";
			$tdfunc5 = "";
			$tdfunc6 = "";

			$buttons = new listenbutton;
				$tdfunc1 = $buttons->entry_new_naventry($row["id"],$treeid);
				$tdfunc2 = $buttons->entry_sort($row["id"],$row["pos"]);
				$tdfunc3 = $buttons->entry_rename($row["id"]);
				$tdfunc4 = $buttons->entry_option_naventry($row["id"]);
				$tdfunc5 = $buttons->entry_delete($row["id"], $stable, $spath, $row["titel"], "__datanav_delete.php");
				$tdfunc6 = $buttons->entry_onoffline_button($row["publik"], $row["id"], $stable, $spath, $row["titel"],"__datanav_lock");
				$tdclass = $buttons->entry_onoffline_text($row["publik"]);

			echo ("<tr ".$jstrover.">\n");
			echo ("<td width=327 height=20 class=table_cell_right_bottom>\n");
			echo str_repeat("&nbsp;", $blank);
			echo ("<span class=".$tdclass.">"); 
		   	echo ("&nbsp;".$row["titel"]."</span></td>\n");
   			echo ("<td align=center height=20 width=30 class=table_cell_right_bottom>".$tdfunc1."</td>\n");
		    echo ("<td height=20 width=70 class=table_cell_right_bottom>".$tdfunc2."</td>\n");
		    echo ("<td height=20 width=100 class=table_cell_bottom>".$tdfunc3.$tdfunc4.$tdfunc5.$tdfunc6."</td></tr>\n");
			loadnavigation($row["id"],$treeid);
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

		$tmptable = "tblcms_navigation";
		$posnr=1;
		$sql = "SELECT id FROM ".$tmptable." WHERE parentid=".$parent." ORDER BY pos";
		$res = (new database())->send_sql($sql);
			if ($res->rowCount()!=0)
				{
				while ($row  = $res->fetch())
					{
					$sql = "UPDATE ".$tmptable." SET pos = ".$posnr." WHERE id=".$row["id"];
					(new database())->send_sql($sql);
					$posnr+=1;
					}
				}
		return $posnr;	
	}

//** ____________________________________________________________ 
//**	Submodul:		sortup()
//**	Version:		1.0				
//**	Beschreibung:	H�herstufen eines Navigationspunktes
//** ____________________________________________________________ 

function sortup($tmpid1)
	{
	global $objConn;

		$tmptable = "tblcms_navigation";
		
		$sql = "SELECT pos, parentid, treeid FROM ".$tmptable." WHERE id=".$tmpid1;
		$res = (new database())->send_sql($sql);
		$data = $res->fetch();
		$tmppos1 = $data["pos"];
			$tmpparent1 = $data["parentid"];
			$tmptreeid1 = $data["treeid"];

		$tmppos2 = $tmppos1-1;		
		$sql = "SELECT id FROM ".$tmptable." WHERE treeid=".$tmptreeid1." and parentid=".$tmpparent1." and pos=".$tmppos2;
		$res = (new database())->send_sql($sql);
		$data = $res->fetch();
			$tmpid2 = $data["id"];
		
		$sql = "UPDATE ".$tmptable." SET pos = ".$tmppos1." WHERE id=".$tmpid2;
		(new database())->send_sql($sql);

		$sql = "UPDATE ".$tmptable." SET pos = ".$tmppos2." WHERE id=".$tmpid1;
		(new database())->send_sql($sql);
	}

//** ____________________________________________________________ 
//**	Submodul:		insert_new_naventry()
//**	Version:		1.0				
//**	Beschreibung:	Neuen Navigationspunkt anf�gen
//** ____________________________________________________________ 

function insert_new_naventry()
	{
	global $objConn;

		$pos = cleansort($_POST["parentid"]);
		if ($_POST["parentid"]!=0)
			{
			$sql = "SELECT ebene FROM tblcms_navigation where id=".$_POST["parentid"];
			$res = (new database())->send_sql($sql);
			if ($res->rowCount()!=0)
				{
				$data = $res->fetch();
					$ranknew = $data["ebene"]+1;
				}
			}
		else
			{	
			$ranknew=0;
			}
			
		$sql = "SELECT id FROM tblcms_templates WHERE standard=1";
		$res = (new database())->send_sql($sql);
		$data = $res->fetch();
			$lstandard = $data["id"];			
			
		$sql = "INSERT INTO tblcms_navigation ( titel, treeid, parentid, ebene, publik, pos, templateid, userid ) VALUES ( '"
				.$_POST["strtitle"]."', '".$_POST["treeid"]."', '".$_POST["parentid"]."', '".$ranknew."', '0', '".$pos."', '".$lstandard."', '".$_SESSION["userid"]."' )";
		
		return $sql;

	}
	
//** ____________________________________________________________ 
//**	Submodul:		rename_naventry()
//**	Version:		2.0				
//**	Beschreibung:	Navigationspunkt umbenennen
//** ____________________________________________________________ 

function rename_naventry()
	{
	$sql = "UPDATE tblcms_navigation SET titel = '".$_POST["strtitle"]."', userid = '".$_SESSION["userid"]."' where id=".$_POST["id"];
	return $sql;
	}
	
//** ____________________________________________________________ 
//**	Submodul:		pagereferer()
//**	Version:		1.0				
//**	Beschreibung:	Seitenweiterleitungen
//** ____________________________________________________________ 

function pagereferer($pid,$value)
	{
	global $objConn;

	$sql = "SELECT id, titel, ebene FROM tblcms_navigation where parentid=".$pid." ORDER BY pos";
	$res = (new database())->send_sql($sql);
		if ($res->rowCount()!=0)
			{
			$blankoption="";			
			while ($row  = $res->fetch())
				{
				$blankoption = str_repeat("&nbsp;", $row["ebene"]*4);
				echo ("<option value=index.php?pageid=".$row["id"]);
				$irefer = "index.php?pageid=".$row["id"];
				if ($irefer==$value) { echo " selected"; }						
				echo (">".$blankoption.$row["titel"]."</option>");
				pagereferer($row["id"],$value);
				}
			}
	}	
	
//** ____________________________________________________________ 
//**	Submodul:		loadtemplate()
//**	Version:		1.0				
//**	Beschreibung:	Template in Auswahlliste laden
//** ____________________________________________________________ 
	
function loadtemplate($value)	
	{
	global $objConn;

	$sql = "SELECT id, titel FROM tblcms_templates WHERE publik=1 ORDER BY titel";
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