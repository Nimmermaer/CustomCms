<?php
session_start();

require("../includes/userfunctions.php");
require("../includes/databasefunction.php");
require("../includes/design_layout_oberflaeche.php");
require("../includes/folders.php");

//** Parameter definieren ---- **// 

	$anhang = "?sid=".$_REQUEST["sid"]."&mainmenu=".$_REQUEST["mainmenu"];
	$action = "";
	if (isset($_REQUEST["action"]))
		$action = $_REQUEST["action"];

	
//** ------------------------- **//

//** Funktionen ausführen ---- **//

	if ($action=="update")
		insert_data();
		
	if ($action=="edit")
		$pagetitle = "Ordnerverwaltung -- Eintrag bearbeiten";

	if ($action=="new")
		{
		$id=0;
		$pagetitle = "Ordnerverwaltung -- Neuer Eintrag";
		}	

//** ------------------------- **//

//** Seiten aufbauen --------- **//

$designpage = new designlayout();
	$designpage->pagestart(1);
	$designpage->boxhead($pagetitle, 637);
	content_data();
	$designpage->boxdown(0,637);
	$designpage->pageend();
	
//** ------------------------- **//

//** Daten-Aktion ausführen -- **//

function insert_data()
	{
	global $anhang;


	
	if ($_POST["id"]!=0)
		{	$sql = edit_entry(); }
	else
		{	$sql = insert_new_entry();	}
	
	echo "<font face=Arial,Helvetica,sans-serif size=1 color=#ff6600><br>&nbsp;&nbsp;&nbsp;&nbsp;Einen Augenblick Geduld - Daten werden gespeichert</font>";
		(new database())->send_sql($sql);

	$sql = "SELECT parentid FROM tblvw_navigation WHERE id=".$_POST["mainmenu"];
	$res = (new database())->send_sql($sql);
	$data = $res->fetch();
		$mainmenu = $data["parentid"];
	open_window($mainmenu);
	}

//** ------------------------- **//

//** Seiten umschalten ------ **//

function open_window($menu)
	{
	global $anhang;
?>
<script language="javascript">
	parent.headline.location.href="head_add.php<?php echo $anhang?>";
	parent.subnav.location.href="../subnav.php<?php echo $anhang?>&mainmenu=<?php echo $menu;?>";
	document.location.href = "data_list.php<?php echo $anhang?>";
</script>
<?php
	}
//** ------------------------- **//


function load_javascripts()
	{
?>
<script language="javascript">

function sendform()
	{
	verify = checkform();
	if (verify==true)
		{
		document.input.submit();
		}
	}
function checkform()
	{
	if (document.input.strtitle.value==""
		&& document.input.strpath.value==""
		)
		{
		alert ('\nW�hlen Sie bitte ein Dokument aus.')
		return false;
		}
		else
		{
		return true;
		}
	}

</script>
<?php
	}
?>

<?php
//** Content-Bereich ---- **//

function content_data()
	{	
	$id = 0;
	$ltitle = "";

	if (isset($_REQUEST["id"]))
		$id = $_REQUEST["id"];
			
	if ($id!=0)
		{
		$sql = "SELECT titel FROM tblcms_folder WHERE ID=".$id;
		$res = (new database())->send_sql($sql);
		$data = $res->fetch();
			$ltitle = $data["titel"];
		}
		
?>
<form name="input" method="post" action="data_edit.php">
  <table width=560 cellspacing="0" cellpadding="0">
    <tr > 
      <td width=115 height="30">Ordner-Titel:<b> 
        <input type="hidden" name="id" value="<?php echo $id?>">
        <input type="hidden" name="sid" value="<?php echo $_GET["sid"]?>">
        <input type="hidden" name="mainmenu" value="<?php echo $_GET["mainmenu"];?>">
        <input type="hidden" name="action" value="update">
        </b></td>
      <td width=445 height="30"> 
        <input type="text" name="strtitle" cols="44" class="itext" value="<?php echo $ltitle?>">
      </td>
    </tr>
    <?php
if ($id==0)
	{
?>
    <tr > 
      <td width=115 height="30">Ordner-Pfad</td>
      <td width=445 height="30"><input type="text" name="strpath" size="44" class="itext"></td>
    </tr>
    <tr > 
      <td width=115 height="24">Ordnertyp:</td>
      <td height="24" class="txt">
	  	<select name="intfoldertyp" id="intfoldertyp">
          <?php
		  folders();
		  ?>
        </select>
	   </td>
    </tr>
    <?php 	} ?>
  </table> 
</form>
<?php
	}
?>


