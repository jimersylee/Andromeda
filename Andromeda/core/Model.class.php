<?php
// Andromeda/core/Model.class.php
//Base Model Class;
class Model
{
    protected $db;
    protected $table;
    protected $fields = array();//

    public function __construct($table)
    {
        $dbConfig['host'] = $GLOBALS['config']['DB_HOST'];
        $dbConfig['user'] = $GLOBALS['config']['DB_USER'];
        $dbConfig['password'] = $GLOBALS['config']['DB_PASSWORD'];
        $dbConfig['db_name'] = $GLOBALS['config']['DB_NAME'];
        $dbConfig['port'] = $GLOBALS['config']['DB_PORT'];
        $dbConfig['charset'] = $GLOBALS['config']['DB_CHARSET'];

        $this->db = new Mysql($dbConfig);
        $this->table = $GLOBALS['config']['DB_PREFIX'] . $table;
        $this->getFields();

    }

    //get the list of fields
    private function getFields()
    {
        $sql = "DESC " . $this->table;
        $result = $this->db->getAll($sql);
        foreach ($result as $v) {
            $this->fields[] = $v['Field'];
            if ($v['Key'] == 'PRI') {
                //if there is ok, save it in $pk
                $pk = $v['Field'];

            }
        }

        //if there is PK, add it into fields list
        if (isset($pk)) {
            $this->fields['pk'] = $pk;

        }
    }

    /**
     * Insert records
     * @access public
     * @param $list array associative array
     * @return mixed If succeed return inserted record id, else return false
     */
    public function insert($list)
    {
        $field_list = '';//field list string
        $value_list = '';//value list string
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                $field_list .= "`" . $k . "`" . ',';
                $value_list .= "'" . $v . "'" . ',';
            }
        }

        //trim the comma on the right
        $field_list = rtrim($field_list, ',');
        $value_list = rtrim($value_list, ',');
        //Construct sql statement
        $sql = "insert into '{$this->table}' ({$field_list}) values ($value_list)";
        if ($this->db->query($sql)) {
            //insert succeed,return the last record's id;
            return $this->db->getInsertId();

        } else {
            return false;

        }
    }

    /*
    update records
    @access public
    @param $list array associative array needs to be updated
    @return mixed if succeed return the count of affected rows,else return false
    */
    public function update($list)
    {
        $upList = '';//update fields
        $where = 0;//update condition,default is 0;
        $update = '';
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                if ($k == $this->fields['pk']) {
                    //if it's PK,construct where condition
                    $where = "'$k'=$v";

                } else {
                    //if not PK,construct update list
                    $update = $update . "'$k'=$v" . ",";

                }
            }
        }
        //trim comma on the right of update list

        //construct SQL statement

        $sql = "update '{$this->table}' set {$upList} where {$where}";
        if ($this->db->query($sql)) {
            //if succeed,return the count of affected rows

            if ($rows = mysql_affected_rows()) {
                //has count of affected rows
                return $rows;

            } else {

                //failed
                return false;

            }

        } else {
            return false;

        }
    }

    /*
    delete records
    @access public
    @param $pk mixed could be an int or a array
    @return mixed if succeed,return the count of deleted rows ,if fail ,return false

    */
    public function delete($pk)
    {
        $where = 0;//condition string
        //check if $pk is a single value or array,and construct where condition accordingly

        if (is_array($pk)) {
            //is array
            $where = "'{$this->fields['pk']}' in (" . implode(',', $pk) . ")";

        } else {
            //single value
            $where = "'{$this->fields['pk']}'=$pk";

        }

        //construct SQL statement
        $sql = "DELETE FROM '{$this->table}' WHERE $where";
        if ($this->db->query($sql)) {
            //if succeed return the count of affected rows;
            if ($rows = mysql_affected_rows()) {
                //has count of affected rows
                return $rows;
            } else {
                return false;

            }

        } else {
            return false;

        }
    }

    /** * Get info based on PK
     * @param $pk int Primary Key
     * @return array an array of single record
     */

    public function selectByPk($pk)
    {
        $sql = "select * from '{$this->table}' where '{$this->fields['pk']}'=$pk";
        return $this->db->getRow($sql);

    }

    /*
    get the count of all records
    */
    public function total()
    {
        $sql = "select count(*) from {$this->table}";
        return $this->db->getOne($sql);

    }

    /*
    get info of pagination
    @param $offset int offset value
    @param $limit int number of records of each fetch
    @param $where string where condition,default is empty
    */
    public function pageRows($offset, $limit, $where = '')
    {
        if (empty($where)) {
            $sql = "select * from {$this->table} limit $offset,$limit";
        } else {
            $sql = "select * from {$this->table} where $where limit $offset,$limit";
        }
        return $this->db->getAll($sql);

    }


}
	
