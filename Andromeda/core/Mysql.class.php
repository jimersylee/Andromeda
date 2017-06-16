<?php

/**
 * Mysql驱动类
 * Class Mysql
 */
class Mysql{

    protected $conn = false;  //DB connection resources

    protected $sql;           //sql statement

   

    /**

     * Constructor, to connect to database, select database and set charset

     * @param array:$config string configuration array

     */

    public function __construct($config = array()){

        $host = isset($config['host'])? $config['host'] : 'localhost';

        $user = isset($config['user'])? $config['user'] : 'root';

        $password = isset($config['password'])? $config['password'] : '';

        $db_name = isset($config['db_name'])? $config['db_name'] : '';

        $port = isset($config['port'])? $config['port'] : '3306';

        $charset = isset($config['charset'])? $config['charset'] : '3306';

       

        $this->conn = @mysqli_connect($host,$user,$password,$db_name,$port) or die('Database connection error');
        $this->setChar($charset);

    }

    /**

     * Set charset

     * @access private

     * @param $charset string charset

     */

    private function setChar($charset){

        $sql = 'set names '.$charset;

        $this->query($sql);

    }

    /**

     * Execute SQL statement

     * @access public

     * @param $sql string SQL query statement

     * @return array|bool|: $result:if succeed, return resources; if fail return error message and exit

     */

    public function query($sql){        

        $this->sql = $sql;

        // Write SQL statement into log


        $result = mysqli_query($this->conn,$this->sql);

       

        if (! $result) {

            die($this->getErrorNo().':'.$this->getErrorMsg().'<br />Error SQL statement is '.$this->sql.'<br />');

        }

        return $result;

    }

    /**

     * Get the first column of the first record

     * @access public

     * @param $sql string SQL query statement

     * @return array null :return the value of this column

     */

    public function getOne($sql){

        $result = $this->query($sql);

        if($result==false){
            return null;
        }
        $row = mysqli_fetch_row($result);

        if ($row) {

            return $row[0];

        } else {

            return null;

        }

    }

    /**

     * Get one record

     * @access public

     * @param $sql: SQL query statement

     * @return array|null associative array

     */

    public function getRow($sql){

        if ($result = $this->query($sql)) {

            $row = mysqli_fetch_row($result);

            return $row;

        } else {

            return null;

        }

    }

    /**

     * Get all records

     * @access public

     * @param $sql:sql query statement

     * @return array $list an 2D array containing all result records

     */

    public function getAll($sql){

        $result = $this->query($sql);

        $list = array();

        while ($row = mysqli_fetch_array($result)){

            $list[] = $row;

        }

        return $list;

    }

    /**

     * Get the value of a column

     * @access public

     * @param $sql string SQL query statement

     * @return array $list array an array of the value of this column

     */

    public function getCol($sql){

        $result = $this->query($sql);

        $list = array();

        while ($row = mysqli_fetch_row($result)) {

            $list[] = $row[0];

        }

        return $list;

    }


   

    /**

     * Get last insert id

     */

    public function getInsertId(){

        return mysqli_insert_id($this->conn);

    }

    /**

     * Get error number

     * @access private

     * @return int number

     */

    public function getErrorNo(){

        return mysqli_errno($this->conn);

    }

    /**

     * Get error message

     * @access private

     * @return String message

     */

    public function getErrorMsg(){

        return mysqli_error($this->conn);

    }

}
