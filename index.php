<?php
include( "includes/module_engine.php" );
?>
<html>
<head>
    <title><?php $pagetitle; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="Content-Language" content="de">
    <meta name="description" content="<?php $pagemetadesc; ?>">
    <meta name="keywords" content="<?php $pagemetakey; ?>">
    <meta name="robots" content="all">
    <link rel="stylesheet" href="css/xstyle.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
    <tr>
        <td width="150" height="108" rowspan="3"><img src="image_navi/gr_logo.gif" width="151" height="108"></td>
        <td width="1" height="108" rowspan="3"><img src="image_navi/gr_blank.gif" width="1" height="1"></td>
        <td width="649" height="40" class="bckgrndtop" align="right">

        </td>
        <td width="649" height="40" class="bckgrndtop" align="right">&nbsp;</td>
    </tr>
    <tr>
        <td width="648" height="43" class="bckgrndtop"><img src="image_navi/gr_top.gif" width="649" height="4"></td>
        <td width="648" height="43" class="bckgrndtop">&nbsp;</td>
    </tr>
    <tr>
        <td width="649" height="25" background="image_navi/gr_top_datum.gif" align="right">&nbsp;</td>
        <td width="649" height="25" background="image_navi/gr_top_datum.gif" align="right" class="txtdatum">&nbsp;</td>
    </tr>
    <tr>
        <td class="bckgrndleft" width="150" valign="top">
            <?php
            cmsbox(0);
            ?>
        </td>
        <td width="1"><img src="image_navi/gr_blank.gif" width="1" height="1"></td>
        <td width="649" valign="top">
            <table width="649" border="0" cellspacing="0" cellpadding="0" height="100%">
                <tr>
                    <td height="108" colspan="2" valign=top bgcolor="#FFCC99" class="bckgrndtopzitat">
                        <?php cmsbox(1); ?>
                    </td>
                </tr>
                <tr>
                    <td width="480" valign=top>
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
                            <tr>
                                <td height="20">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    cmsbox(2);
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign=top>
                        <?php
                        cmsbox(4);
                        ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="649" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                <tr>
                    <td height="108" class="bckgrndtopzitat"></td>
                </tr>
                <tr>
                    <td>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="150" class="bckgrndleft">
            <table width="150" border="0" cellspacing="0" cellpadding="0" height="40" class="bckgrndleft">
                <tr>
                    <td colspan="3"><img src="image_navi/gr_nav_trenner.gif" width="150" height="1"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>

                    </td>
                    <td></td>
                </tr>
            </table>
        </td>
        <td width="1"><img src="image_navi/gr_blank.gif" width="1" height="1"></td>
        <td width="649" height="40">
            <table width="649" border="0" cellspacing="0" cellpadding="0" height="40">
                <tr>
                    <td colspan="2"><img src="image_navi/gr_top.gif" width="649" height="1"></td>
                </tr>
                <tr>
                    <td width=19>&nbsp;</td>
                    <td width=630 class="txtbottom">
                        <?php
                        cmsbox(3);
                        ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="649" height="40">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" height="40">
                <tr>
                    <td colspan="2"><img src="image_navi/gr_top.gif" width="100%" height="1"></td>
                </tr>
                <tr>
                    <td width=19>&nbsp;</td>
                    <td width=630 class="txtbottom">&nbsp; </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
