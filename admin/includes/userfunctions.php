<?php
//** ____________________________________________________________ 
//**	Modul:		Funktionen User-Überwachung
//**	Subs:		- logged_user()
//**				- exit_user()
//**				- check_user()
//**				- loginerror_user()
//**				- name_user()
//** ____________________________________________________________ 

/* ____________________________________________________________ 
/*		Submodul:		logged_user()
/*		Version:		1.0				
/*		Beschreibung:	ÜberprÜfen von Userid und Logtimeout
/*	____________________________________________________________ */

/**
 * Class userfunctions
 */
class userfunctions
{

    /**
     * @return bool|string
     */
    public function check_user()
    {
        $database = new database();
        $sql      = "SELECT userid, user, pw, publik, logtimeout FROM tblvw_intuser WHERE user='" . $_POST["user"] . "' AND ";
        $sql      = $sql . " pw='" . $_POST["pw"] . "' LIMIT 1";
        $res      = $database->send_sql($sql);
        var_dump($res->execute());
        if ($res->execute()) {
            $data = $res->fetch();
            if ($data["publik"] == 0) {
                $userid = "locked";
            } else {
                $userid               = $data["userid"];
                $_SESSION["userid"]   = $data["userid"];
                $_SESSION["username"] = $data["user"];
                $_SESSION["logtime"]  = $data["logtimeout"] * 60;
            }

            return $userid;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function login_user($id)
    {
        $database          = new database();
        $sid               = session_id();
        $_SESSION["ltime"] = time();
        $_SESSION["ocd"]   = session_id();

        $sql = "UPDATE tblvw_intuser SET lastlogin='" . date("Y-m-d") . "'  WHERE userid=" . $id;
        $database->send_sql($sql);
        $anhang = "?sid=" . $sid;

        return $anhang;
    }

    /**
     *
     */
    public function logged_user()
    {

        /* 	____________________________________
              Zeitdifferenz, mit automatischen
              Timeout vergleichen
            ____________________________________*/

        //echo ($_REQUEST["sid"]."<bR>".session_id()."<br>");
        $checksid = strcmp($_REQUEST["sid"], session_id());
        if ($_REQUEST["sid"] != session_id()) {
            $this->exit_user();
        }

        $diff = time() - $_SESSION["ltime"];
        //echo $diff."<br>";
        //echo ($_SESSION["logtime"]."<br>".$_SESSION["ltime"]."<br>");
        //echo ($_SESSION["userid"]."<br>");
        //echo ($_SESSION["username"]."<br>");
        if ($diff > $_SESSION["logtime"]) {
            $this->exit_user();
        } else {
            $_SESSION["ltime"] = time();
        }

    }

    /**
     *
     */
    public function exit_user()
    {
        $database = new database();
        $sql      = "SELECT adminpfad FROM tblvw_system LIMIT 1";
        $res      = $database->send_sql($sql);
         $data     = $res->fetch($res);
        $fileexit = $data["adminpfad"] . "/index.php";
        ?>
        <script language="JavaScript">
            parent.location.href = "<?php Echo $fileexit ?>";
        </script>
        <?php
    }
}