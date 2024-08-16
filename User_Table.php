<?php
/*

This table will follow a philosophy of being very simple; It will be independent of any external logic
and will have the most fundamental minimum so it can be accomodated without change in various programs
*/
class User_Table
{
    protected $User_Objects = array();

    protected $db = null;
    protected $table_name = null;
    public function initialize($db, $table)
    {
        $this->db = $db;
        $this->table_name= $table;
        if (sizeof($this->User_Objects) <= 0)
        {
        $query = "Select * from $table";
        $result = $db->query($query);
        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            array_push($this->User_Objects, $row);
        }
    }
}



    public function refresh()
    {
        if ($this->db != null && $this->table_name != null)
        {
            $this->User_Objects = array();
            $query = "Select * from $this->table_name";
            $result = $this->db->query($query);
            while ($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                array_push($this->User_Objects, $row);
            }
        }
    }


    public function returnAllInformation()
    {
        return $this->User_Objects;
    }
    public function printAll()
    {
        foreach ($this->User_Objects as $user)
        {
            echo $user[1];
        }
    }

    // fundamentally simple compares username and password
    // with db and then tries to ascertain the record;
    // applicable for hashed passwords


    public function getAccount($username, $password)
    {
        $arr = $this->User_Objects;
        for ($i =0; $i< sizeof($this->User_Objects); $i++)
        {
            if ($arr[$i]["username"] == $username && $arr[$i]["password"] == $password)
            {
                return $arr[$i];
            }
        }
    }

    public function S_getAccount($username, $password)
    {
        $arr = $this->User_Objects;
        for ($i =0; $i< sizeof($this->User_Objects); $i++)
        {
            if ($arr[$i]["username"] == $username && password_verify($password, $arr[$i]["password"]))
            {
                return $arr[$i];
            }
        }


    }

    public function addAccount($p_username, $p_password, $p_email)
    {
        if ($this->table_name !=  null && $this->db != null)
        {
            try
            {
            $size = sizeof($this->User_Objects);
            $lastid = self::lastElem()["uid"] + 1;
            $query = "INSERT Into $this->table_name Values (:id, :username, :password, :email)";
            $operation = $this->db->prepare($query);
            $operation->bindParam("id", $lastid, PDO::PARAM_INT);
            $operation->bindParam("username", $p_username, PDO::PARAM_STR);
            $operation->bindParam("password", $p_password, PDO::PARAM_STR);
            $operation->bindParam("email", $p_email, PDO::PARAM_STR);


            $result = $operation->execute();
            $this->refresh();
            }
            catch(PDOException $ex)
            {
                return $ex;
            }

        }
    }
    public function modifyAccount($ID, $username = "", $password = "", )
    {
        $acc = $this->get($ID);
        if ($acc != null)
        {
            if ($username != "")
            {
                $query = "UPDATE from $this->table_name SET username=:Name where ID=:ID";
                $operator = $this->db->prepare($query);
                $operator->bindParam(":Name", $username, PDO::PARAM_STR);
                $operator->bindParam(":ID", $ID, PDO::PARAM_INT);

                $operator->execute();
                $this->refresh();
            }
            if ($password != "")
            {
                $query = "UPDATE from $this->table_name SET password=:Name where ID=:ID";
                $operator = $this->db->prepare($query);
                $operator->bindParam(":Name", $password, PDO::PARAM_STR);
                $operator->bindParam(":ID", $ID, PDO::PARAM_INT);

                $operator->execute();
                $this->refresh();
            }
        }
    }
    // public function deleteAccount($p_username, $p_password, $p_email)
    // {
    //     if ($this->table_name != null & $this->db != null)
    //     {
    //         $acc = self::getAccount($p_username, $p_password);
    //         $id = $acc["uid"];
    //         $query = "DELETE from :table_name where id=:id_name";
    //         $operation = $this->db->prepare($query);
    //         $operation->bindParams(":table_name", $this->table_name, PDO::PARAM_STR);
    //         $operation->bindParams(":id_name", $id, PDO::PARAM_STR);
    //         $operation->execute();
            
    //         $this->refresh();
    //     }
    // }
    public function directDelete($id)
    {
        if ($this->table_name != null & $this->db != null)
        {
            $query = "DELETE from $this->table_name where uid=:id_name";
            $operation = $this->db->prepare($query);
            $operation->bindParam("id_name", $id, PDO::PARAM_INT);
            $operation->execute();
            
            $this->refresh();
        }
    }
    public function lastElem()
    {
        return end($this->User_Objects);
    }

    public function get($ID)
    {
        foreach ($this->User_Objects as $user)
        {
            if ($user[0] == $ID)
            {
                return $user;
            }
        }
        return null;
    }

    public function p_returnUserObjects()
    {
        return $this->User_Objects;
    }
}

?>