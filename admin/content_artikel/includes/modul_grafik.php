<?php
	global $anhang;
	global $artikelid, $cbnr;

	$artikel_pic="";
	$artikel_pic_id="";
	$artikel_pictitle="";
	$artikel_pictitle_id="";
	$artikel_piclink="";
	$artikel_piclink_id="";		

	$sql = "SELECT id, content, cmsboxtype FROM tblcms_artikel_content WHERE artikelid=".$_REQUEST["id"]." and cmsbox=".$cbnr;
	$res = $objConn->query($sql);
	if ($res->num_rows!=0) 
		{
		while ($row  = $res->fetch_array())		
			{
			switch ($row["cmsboxtype"])
				{
				case 1:
					if ($row["content"]!="")
						$artikel_pic="<img src=../../uploadfiles/pictures/".$row["content"]." width=120 height=125 border=0>";
					$artikel_pic_id=$row["id"];
					break;
				case 2:
					$artikel_pictitle=$row["content"];
					$artikel_pictitle_id=$row["id"];
					break;
				case 3:
					$artikel_piclink=$row["content"];
					$artikel_piclink_id=$row["id"];
					break;				
				}
			}
		}
?>	
<table width=560 cellspacing="0" cellpadding="0">
  <tr> 
    <td height="24" class="txtformpflicht" colspan="2">CMS-Box&nbsp;<?echo $cbnr;?>&nbsp;-&nbsp;Grafik</td>
  </tr>
  <tr> 
  	<td height="22" width=95 valign="top" class="cmsboxedit"><a class="cmsboxlink" href="data_edit_art_bild.php<?echo $anhang;?>&cmsboxtype=1&cmsbox=<?echo $cbnr;?>&contentid=<?echo $artikel_pic_id;?>" target="funktion" onClick="dateiload('head_content_save.php<?echo $anhang;?>')">&nbsp;<img src=../image_cms/gr_arrow_down.gif border=0>Bild</a></td>
    <td width=5 height="8"></td>
	<td height="22" width=460 valign="top" class="txt"><?echo $artikel_pic?></td>
  </tr>
  <tr> 
    <td colspan="2" height="8"></td>
  </tr>
  <tr>
	<td height="22" width=95 valign="top" class="cmsboxedit"><a class="cmsboxlink" href="data_edit_art_headline.php<?echo $anhang;?>&cmsboxtype=2&cmsbox=<?echo $cbnr;?>&contentid=<?echo $artikel_pictitle_id;?>" target="funktion" onClick="dateiload('head_content_save.php<?echo $anhang;?>')">&nbsp;<img src=../image_cms/gr_arrow_down.gif border=0>Bildtitel</a></td>
    <td width=5 height="8"></td>
    <td height="22" width=460 valign="top" class="txt"><?echo $artikel_pictitle?></td>
  </tr>
  <tr> 
    <td colspan="2" height="8"></td>
  </tr>
  <tr>
    <td height="22" width=95 valign="top" class="cmsboxedit"><a class="cmsboxlink" href="data_edit_art_bildlink.php<?echo $anhang;?>&cmsboxtype=3&cmsbox=<?echo $cbnr;?>&contentid=<?echo $artikel_piclink_id;?>" target="funktion" onClick="dateiload('head_content_save.php<?echo $anhang;?>')">&nbsp;<img src=../image_cms/gr_arrow_down.gif border=0>Bildlink</a></td>
    <td width=5 height="8"></td>    
	<td height="22" width=460 valign="top" class="txt"><?echo $artikel_piclink?></td>
  </tr>  
</table>
