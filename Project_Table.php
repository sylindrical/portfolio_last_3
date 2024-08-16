<?php
class Project_Table
{
    private $table = array();
    private $db = null;
    private $table_name;
    public function initialize($db, $table_name)
    {
        $this->table_name = $table_name;
        $this->db = $db;
        if (sizeof($this->table) <= 0)
        {
        $query = "Select * from $table_name";
        $result = $this->db->query($query);
        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            array_push($this->table, $row);
        }
    }
    }

    public  function refresh()
    {
        $this->table = array();
        $query = "Select * from $this->table_name";
        $result = $this->db->query($query);
        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            array_push($this->table, $row);
        }
    }



    public function getProject($id)
    {
        if ($this->table != [] && $this->db != null)
        {
            $data = [];
            foreach ($this->table as $x)
            {
                if ($x["uid"] == $id)
                {
                    array_push($data, $x);
                }
            }
            return $data;
        }
        else
        {

        }
    }
    public function lastElem()
    {
        return end($this->table);
    }

    public function addProject($title, $start_date, $end_date, $phase, $description, $uid)
    {
        try
        {

        
        $table_size = sizeof($this->table)+1;
        $new_id = $this->lastElem()["pid"] + 1;
        $query = "INSERT into $this->table_name VALUES (:id, :title, :start_date, :end_date, :phase, :description, :uid)";
        $operation = $this->db->prepare($query);
        $operation->bindParam('id', $new_id, PDO::PARAM_INT);
        $operation->bindParam('title', $title, PDO::PARAM_STR);

        $operation->bindParam('start_date', $start_date, PDO::PARAM_STR);

        $operation->bindParam('end_date', $end_date, PDO::PARAM_STR);

        $operation->bindParam('phase', $phase, PDO::PARAM_STR);

        $operation->bindParam('description', $description, PDO::PARAM_STR);
        $operation->bindParam('uid', $uid, PDO::PARAM_INT);
        


        return $operation->execute();
        }
        catch(PDOException $ex)
        {
            return null;
        }
    }
    public function removeProject($pid)
    {
        $query = "DELETE FROM $this->table_name WHERE pid = $pid";
        $this->db->query($query);
    }
}


?>