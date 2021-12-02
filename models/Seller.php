<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__) . $ds . '..') . $ds;

    // Including Database
    require_once("{$base_dir}includes{$ds}Database.php");
    // Including Bcrypt
    require_once("{$base_dir}includes{$ds}Bcrypt.php");

    class Seller 
    {
        private $table = 'sellers';

        public $id;
        public $name;
        public $email;
        public $password;
        public $image;
        public $address;
        public $description;

        // Constructor
        public function __construct() {}

        // Validating if params exists or not
        public function validate_params($value) {
            return (!empty($value));
        }

        // Check if email is unique or not
        public function check_unique_email() {
            global $database;

            $this->email = trim(htmlspecialchars(strip_tags($this->email)));

            $sql = "SELECT id FROM $this->table WHERE email = '" . $database->escape_value($this->email) . "'";

            $result = $database->query($sql);

            $seller_id = $database->fetch_row($result);

            return empty($seller_id);
        }

        // Saving new data in our database
        public function register_seller() {
            global $database;

            $this->name = trim(htmlspecialchars(strip_tags($this->name)));
            $this->email = trim(htmlspecialchars(strip_tags($this->email)));
            $this->password = trim(htmlspecialchars(strip_tags($this->password)));
            $this->image = trim(htmlspecialchars(strip_tags($this->image)));
            $this->address = trim(htmlspecialchars(strip_tags($this->address)));
            $this->description = trim(htmlspecialchars(strip_tags($this->description)));

            $sql = "INSERT INTO $this->table
            (
                name, email, password, image, address, description 
            )
            VALUES
            (
                '" . $database->escape_value($this->name) . "',
                '" . $database->escape_value($this->email) . "',
                '" . $database->escape_value(Bcrypt::hashPassword($this->password)) . "',
                '" . $database->escape_value($this->image) . "',
                '" . $database->escape_value($this->address) . "',
                '" . $database->escape_value($this->description) . "'
            )";

            $seller_saved = $database->query($sql);

            if ($seller_saved) {
                //return $database->last_insert_id();
                return true;
            }
            else {
                return false;
            }
        }
    }

    // Seller object
    $seller = new Seller();

?>