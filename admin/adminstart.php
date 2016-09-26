<?php
//** Parameter definieren ---- **//
session_start();
if (isset( $_REQUEST["sid"] )) {
    $anhang = "?sid=" . $_REQUEST["sid"];
} else {
    header("location: index.php");
}
?>

<html>
<head>
    <title>Custom Cms</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="68,*" frameborder="NO" border="0" framespacing="0">
    <frame name="navprim" scrolling="NO" noresize src="nav_prim.php<?php echo $anhang ?>">
    <frameset cols="191,*" frameborder="NO" border="0" framespacing="0">
        <frame name="subnav" src="subnav.php<?php echo $anhang ?>">
        <frameset rows="41,*" frameborder="NO" border="0" framespacing="0">
            <frame name="headline" scrolling="No" noresize src="gheadline.php<?php echo $anhang ?>">
            <frame name="funktion" scrolling="AUTO" noresize src="start/function.php<?php echo $anhang ?>">
        </frameset>
    </frameset>
</frameset>
<noframes>
    <body bgcolor="#FFFFFF" text="#000000">
    </body>
</noframes>
</html>
