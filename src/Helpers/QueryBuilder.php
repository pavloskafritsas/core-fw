<?php

namespace Pk\Core\Helpers;

use PDO;
use PDOstmt;


/**
 * Δημιουργία δυναμικών SQL statements
 */
class QueryBuilder
{
    private ?DB $db;

    private ?string $modelClass = null;

    private ?string $table = null;

    private array $sqlQuery = [
        'insert' => '',
        'select' => '',
        'update' => '',
        'where' => [],
        'orderBy' => '',
    ];

    /**
     * @var PDOstmt|false $stmt
     */
    private $stmt;

    public function __construct(?string $table = null, ?string $modelClass = null)
    {
        $this->db = DB::getInstance();

        $this->table = $table;
        $this->modelClass = $modelClass;
    }

    /**
     * Κατασκευή κομματιού SELECT του SQL query
     */
    public function select(array $columns = ['*']): self
    {
        $this->sqlQuery['select'] = 'SELECT ' . implode(',', $columns) . " FROM {$this->table} ";

        return $this;
    }

    /**
     * Κατασκευή κομματιού DELETE του SQL query
     * 
     * @return bool
     */
    public function delete()
    {
        $this->sqlQuery['delete'] = "DELETE FROM {$this->table} ";

        return $this->prepareDeleteQuery();
    }

    /**
     * Κατασκευή κομματιού WHERE του SQL query
     * 
     * @param null|string $column
     * @param string $operator
     * @param null|string $value
     */
    public function where($column, $operator, $value)
    {
        $this->sqlQuery['where'][] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
        ];

        return $this;
    }

    /**
     * Κατασκευή κομματιού WHERE του SQL query με operator "="
     * 
     * @param null|string $key
     * @param null|string $value
     * 
     * @return self
     */
    public function whereEqual($key, $value)
    {
        return $this->where($key, '=', $value);
    }

    /**
     * Εκτέλεση query με σκοπό την επιστροφή του πρώτου αποτελέσματος
     */
    public function first(?array $columns = null)
    {
        if (!$this->sqlQuery['select'] || $columns) {
            $this->select($columns ?? ['*']);
        }

        $this->prepareSelectQuery();

        $this->setFetchMode();

        $data = $this->stmt->fetch();

        $this->cleanup();

        return $data;
    }

    /**
     * Καθαρισμός property του πίνακα sqlQuery
     */
    private function cleanup()
    {
        $this->sqlQuery = [
            'insert' => '',
            'select' => '',
            'update' => '',
            'where' => [],
            'orderBy' => '',
        ];
    }

    /**
     * Εκτέλεση query με σκοπό την επιστροφή όλων των αποτελεσμάτων (rows)
     * 
     * @param null|array $columns
     * 
     * @return array<null|object>
     */
    public function get($columns = null)
    {
        if (!$this->sqlQuery['select']) {
            $this->select($columns ?? ['*']);
        }

        $this->prepareOrderBy();

        $this->prepareSelectQuery();

        $this->setFetchMode();

        $data = $this->stmt->fetchAll();

        $this->cleanup();

        return $data ?? [];
    }

    /**
     * Εκτέλεση query με σκοπό την καταμέτρηση των αποτελεσμάτων
     * 
     * @return int
     */
    public function count()
    {
        return count($this->get());
    }

    /**
     * @param  string $columns
     * 
     * @return self
     */
    public function orderBy($columns, $direction = 'ASC')
    {
        $this->sqlQuery['orderBy'] = [
            $columns => $direction
        ];

        return $this;
    }

    /**
     * @return void
     */
    public function prepareOrderBy()
    {
        if (!$this->sqlQuery['orderBy']) {
            return;
        }

        $orderBy = ' ORDER BY ';

        foreach ($this->sqlQuery['orderBy'] as $column => $direction) {
            $orderBy .= "$column $direction ";
        }

        $this->sqlQuery['orderBy'] = $orderBy;
    }

    /**
     * Ταύτηση αποτελεσμάτων SQL με το συγκεκριμένο modelClass
     */
    private function setFetchMode()
    {
        if ($this->modelClass) {
            $this->stmt->setFetchMode(PDO::FETCH_CLASS, $this->modelClass);
        }
    }

    /**
     * Εκτέλεση SELECT query (με περιορισμούς WHERE εάν υπάρχουν) για λήψη δεδομένων απο τη βάση δεδομένων με χρήση prepared statement
     * 
     * @return void
     */
    private function prepareSelectQuery()
    {
        $s = $this->sqlQuery['select'];

        $o = $this->sqlQuery['orderBy'];

        if ($w = $this->getWhereQuery()) {
            $this->stmt = $this->db->prepare($s . $w['sql'] . $o);
            $this->stmt->execute($w['params']);
        } else {
            $this->stmt = $this->db->query($s . $o);
        }
    }

    /**
     * Εκτέλεση DELETE query (με περιορισμούς WHERE εάν υπάρχουν) για διαγραφή δεδομένων απο τη βάση δεδομένων με χρήση prepared statement
     * 
     * @return void
     */
    private function prepareDeleteQuery()
    {
        $d = $this->sqlQuery['delete'];
        $w = $this->getWhereQuery();

        $this->stmt = $this->db->prepare($d . $w['sql']);
        return $this->stmt->execute($w['params']);
    }

    /**
     * Προσβαση στον PDO driver
     * 
     * @return null|PDO
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Προσθήκη WHERE statement και των παραμέτρων τους στο sqlQuery
     * 
     * @return array
     */
    private function getWhereQuery()
    {
        $w = ['sql' => ''];

        foreach ($this->sqlQuery['where'] ?? [] as $where) {
            if (!$w['sql']) {
                $w['sql'] = ' WHERE ';
            } else {
                $w['sql'] .= ' AND ';
            }

            $w['sql'] .= $where['column'] . ' ' . $where['operator'] . ' :' . $where['column'];

            $w['params'][$where['column']] = $where['value'];
        }

        return $w['sql'] ? $w : [];
    }

    /**
     * Προσθήκη row σε πίνακα και επιστροφή του id του
     * 
     * @param array $data
     * 
     * @return string
     */
    public function insert($data = [])
    {
        $cols = implode(',', array_keys($data));

        $values = array_values($data);

        $placeholders = substr(str_repeat('?,', count($data)), 0, -1);

        $sql = 'INSERT INTO ' . $this->table . "($cols) VALUES ($placeholders)";

        $this->db->prepare($sql)->execute($values);

        return $this->db->lastInsertId();
    }

    /**
     * Κλείσιμο ενεργής σύνδεσης PDO με το DBMS (mysqld)
     */
    public static function closeDBConnection()
    {
        $queryBuilder = (new self);

        $queryBuilder->db = null;
    }
}
