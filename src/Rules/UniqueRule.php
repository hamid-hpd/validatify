<?php
namespace Hpd\Validatify\Rules;

class UniqueRule implements RuleInterface {
	protected $db;
	public function __construct($db){
		 {
        $this->db = $db;
    }
	}
    public function validate($value, $parameters = null): bool {
      
       
		if (count($parameters) < 2) {
            throw new \InvalidArgumentException("Unique rule requires both table name and column name.");
        }

        [$table, $column] = $parameters;

        // Perform database query to check uniqueness
        // Example: Using PDO (adapt as per your database library)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        $count = $stmt->fetchColumn();

        return $count == 0;
    }
}