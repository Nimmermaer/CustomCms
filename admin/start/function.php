<?php
session_start();

require( "../includes/userfunctions.php" );
require( "../includes/design_layout_oberflaeche.php" );
require( "../includes/databasefunction.php" );

//** Benutzerstatus �berpr�fen ---- **// 

$designpage = new designlayout;
$designpage->pagestart(0);
$designpage->boxhead("Administrationstool -- Startseite", 637);
content_data();
$designpage->boxdown(0, 637);
$designpage->pageend();


function content_data()
{
    ?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div align="center">
                    <p>Willkommen im<br>
                        Content Management System</p>
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <?php
}

?>

