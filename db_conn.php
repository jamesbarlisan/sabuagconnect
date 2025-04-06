<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'members';
    private $username = 'root';
    private $password = '1234';
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: ". $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
    public function disconnect() {
        $this->pdo = null;
    }
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    echo "";
} catch (Exception $e) {
    echo "Error: " .$e->getMessage();
}
if (!class_exists('Database')) {
    class Database {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '1234';
        private $database = 'members';
        private $connection;

        public function __construct() {
            $this->connect();
        }

        private function connect() {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }

        public function query($sql) {
            return $this->connection->query($sql);
        }

        public function close() {
            if ($this->connection) {
                $this->connection->close();
            }
        }
    }
}
?>
<?php
$servername = "localhost"; // Change if using a different host
$username = "root"; // Change if using a different user
$password = "1234"; // Change if using a different password
$database = "members"; // Ensure this matches the actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
