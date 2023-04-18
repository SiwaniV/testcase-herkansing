<?php
require_once('./class/DBconfig.php');

class Movie
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($data)
    {
        try {
            $stmt = $this->con->prepare("INSERT INTO movie (title, description, actor) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $data['title'], $data['description'], $data['actor']);
            $stmt->execute();
            return $stmt->insert_id;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function read($id)
    {
        $query = "SELECT * FROM movie WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function update($data)
    {
        try {
            $stmt = $this->con->prepare("UPDATE movie SET title = ?, description = ?, actor = ? WHERE id = ?");
            $stmt->bind_param("sssi", $data['title'], $data['description'], $data['actor'], $data['id']);
            $stmt->execute();
            return $stmt->affected_rows;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->con->prepare("DELETE FROM movie WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
