<?php

class MemberRegistration {
    private $db;

    public function __construct($host, $username, $password, $dbname) {
        $this->db = new mysqli($host, $username, $password, $dbname);

        if ($this->db->connect_error) {
            throw new Exception("Connection failed: " . $this->db->connect_error);
        }
    }

    public function sanitizeInput($input) {
        return $this->db->real_escape_string($input);
    }

    public function uploadFile($file, $targetDir) {
        $targetFile = $targetDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile;
        }

        throw new Exception("File upload failed.");
    }

    public function registerMember($data, $profilePic) {
        $fullName = $this->sanitizeInput($data['full_name']);
        $birthday = $this->sanitizeInput($data['birthday']);
        $program = $this->sanitizeInput($data['program']);
        $yearSection = $this->sanitizeInput($data['year_section']);
        $position = $this->sanitizeInput($data['position']);
        $username = $this->sanitizeInput($data['username']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);

        $profilePicPath = $this->uploadFile($profilePic, 'uploads/');

        $sql = "INSERT INTO members (full_name, birthday, program, year_section, position, username, password, profile_pic) 
                VALUES ('$fullName', '$birthday', '$program', '$yearSection', '$position', '$username', '$password', '$profilePicPath')";

        if ($this->db->query($sql) === TRUE) {
            return true;
        }

        throw new Exception("Error: " . $this->db->error);
    }

    public function __destruct() {
        $this->db->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registration = new MemberRegistration('localhost', 'root', '1234', 'members');

        $registration->registerMember($_POST, $_FILES['profile_pic']);

        echo "Member registered successfully!";
        header("Location: about.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
