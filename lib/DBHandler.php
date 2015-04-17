<?php

/**
 * Description of DB
 *
 * @author rnest
 */
class DBHandler extends mysqli
{

    protected $table = null;

    public function __construct($host, $user, $pass, $db)
    {
        parent::__construct($host, $user, $pass, $db);
        $this->set_charset('utf8');
        if (mysqli_connect_error()) {
            throw new Exception(mysqli_connect_error());
        }
    }

    public function setTable($t)
    {
        $this->table = $t;
    }

    public function simpleQueryFetch($query)
    {
        $result = $this->query($query);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            $res[] = $row;
        }
        return $res;
    }

    public function insert(Array $rowData)
    {
        if (null === $this->table) {
            throw new Exception('Table name is required.');
        }
        
        while($elem = each($rowData)){
            $data[$elem['key']] = isset($elem['value']) ? (string) str_replace(':', '', str_replace('.', '', $elem['value'])) : 'brak danych';
        }
        
        $keys = implode(',', array_keys($data));
        $rowValues = array_values($data);
        $values = '';
        
        while($v = each($rowValues)){
            $values .= "'" . $v['value'] . "',";
        }
        
        $query = 'INSERT INTO ' . $this->table . ' (' . $keys . ') '
                . 'VALUES(' . rtrim($values, ',') . ')';
        
        $res = $this->query($query);

        if (!$res) {
            throw new Exception('Errors during query execution.');
        }
    }

}
