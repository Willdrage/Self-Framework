<?php
namespace App\Models;
Use PDO;
use App\Core\Connection;


abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected array $wheres = [];
    protected array $bindings = [];

    /**
     * Constructor initializes the database connection.
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    /**
     * Executes a SQL query with optional parameters and returns the PDOStatement.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters to bind to the query.
     * @return PDOStatement The executed statement.
     */
    protected function query($sql , $params =[])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Selects specific columns from the table with optional WHERE conditions.
     * 
     * This method allows you to select specific columns and apply WHERE conditions
     * that were previously set using the where() method. The method automatically
     * resets the query builder state after execution.
     *
     * @param string ...$columns The column names to select. If no columns are specified, all columns will be selected.
     * @return array An array of associative arrays representing the selected records.
     * 
     * @example
     * $users = $userModel->where('age', '>', 18)->select('name', 'email');
     * $allUsers = $userModel->select('*');
     */
    public function select(...$columns)
    {
        $columnsStr= implode(', ',$columns);
        $sql = "SELECT $columnsStr FROM {$this->table}";
        if (!empty($this->wheres)){
            $sql .= " WHERE ". implode(' AND ', $this->wheres);
        }
        $stmt = $this->query($sql, $this->bindings ?? []);
        $this->resetQuery();        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Adds a WHERE condition to the query builder.
     * 
     * This method allows you to chain multiple WHERE conditions. The conditions
     * are stored and will be applied when select() is called. Supports various
     * operators like =, >, <, >=, <=, !=, LIKE, etc.
     *
     * @param string $column The column name to filter by.
     * @param string $operator The comparison operator (default: '=').
     * @param mixed $value The value to compare against.
     * @return $this Returns the current instance for method chaining.
     * 
     * @example
     * $userModel->where('age', '>', 18)->where('status', '=', 'active');
     * $userModel->where('name', 'LIKE', '%john%');
     */
    public function where(string $column, string $operator = '=', $value)
    {
        $paramCount = $column . count($this->wheres);
        $this->wheres[] = "{$column} {$operator} :{$paramCount}";
        $this->bindings[$paramCount] =$value;
        return $this;
    }

    /**
     * Resets the query builder state.
     * 
     * Clears all WHERE conditions and parameter bindings, allowing
     * the query builder to be reused for a new query.
     *
     * @return void
     */
    protected function resetQuery()
    {
        $this->wheres = [];
        $this->bindings = [];
    }

    /**
     * Retrieves all records from the associated table.
     *
     * @return array An array of objects representing all records.
     */
    public function all(): array
    {
        $stmt = $this->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
    }

    /**
     * Finds a single record by its ID.
     *
     * @param int $id The ID of the record to find.
     * @return object|null The found record as an object, or null if not found.
     */
    public function find(int $id): ?object
    {
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        return $stmt->fetch() ?: null;
    }


    /**
     * Inserts a new record into the associated table.
     *
     * @param array $data An associative array of column => value pairs to insert.
     * @return void
     */
    public function create(array $data)
    {
        $columns= implode(',', array_keys($data));
        $placeholders= ':'.implode(',:', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ($columns ) VALUES ( $placeholders )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }


    /**
     * Updates the current record in the associated table.
     *
     * @param array $data An associative array of column => value pairs to update.
     * @return void
     */
    public function update(array $data)
    {
        $update = [];
        foreach (array_keys($data) as $key) {
            $update[] = "{$key} = :{$key}";
        }
        $updateStr = implode(',', $update);

        $sql = "UPDATE {$this->table} SET {$updateStr} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $this->id ?? null;
        $stmt->execute($data);
    }

    /**
     * Deletes the current record from the associated table.
     *
     * @return void
     */
    public function delete()
    {
        $sql= "DELETE FROM {$this->table} WHERE id= :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id'=>$this->id ?? null]);
    }
}