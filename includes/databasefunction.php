<?php
// Datenbankparameter
// @todo Backendinstallation


class database
{
    /**
     * @var string
     */
    protected $host = 'localhost';

    /**
     * @var string
     */
    protected $user = 'root';

    /**
     * @var string
     */
    protected $passw = '';

    /**
     * @var string
     */
    protected $dbase = 'democms';

    /**
     * @return bool|PDO
     */
    public function databaseConnect()
    {
        $dbh = false;
        try {
            $dbh = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbase, $this->user, $this->passw, array(
                PDO::ATTR_PERSISTENT => true
            ));

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $dbh;
    }

    /**
     * @param string $sql
     *
     * @return bool|PDOStatement
     */
    public function send_sql($sql)
    {
        $res        = false;
        $connection = $this->databaseConnect();
        if ($connection) {
            $res = $connection->query($sql);
        }

        return $res;
    }


}
