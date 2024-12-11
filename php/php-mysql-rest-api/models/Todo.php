    <?php

    class Todo
    {
        private $id;
        private $cat_title;
        private $dateAdded;
        private $dbConnection;
        private $category_table = 'categories';
        private $cat_mark_table = 'bookmarks';

        public function __construct($dbConnection)
        {
            $this->dbConnection = $dbConnection;
        }

        
        public function set_Cat_title($cat_title){
            $this->cat_title = $cat_title;
        }
    
        public function get_Cat_title(){
            return $this->cat_title;
        }
    
        public function setId($id){
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function setDateAdded($dateAdded){
            $this->dateAdded = $dateAdded;
        }

        public function getDateAdded(){
            return $this->dateAdded;
        }
        // public function create()
        // {
        //     $query = "INSERT INTO " . $this->dbTable . "(task, date_added, done) VALUES(:taskName, now(),false);";
        //     $stmt = $this->dbConnection->prepare($query);
        //     $stmt->bindParam(":taskName", $this->task);
        //     if ($stmt->execute()) {
        //         return true;
        //     }
        //     // print an error message
        //     printf("Error: %s", $stmt->error);
        //     return false;
        // }

        public function createCategory()
        {
            $query = "INSERT INTO " . $this->category_table . "(title , date_added) VALUES(:title, now());";
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){
                $stmt->bindParam(":title", $this->cat_title, PDO::PARAM_STR);
                //exec command
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    echo "New record created successfully";
                    return true;
                } else {
                    echo "Error: failed to insert the new record";
                    return false;
                }
            }
        
        }


        // public function readOne()
        // {
        //     $query = "SELECT * FROM " . $this->dbTable . " WHERE id=:id";
        //     $stmt = $this->dbConnection->prepare($query);
        //     $stmt->bindParam(":id", $this->id);
        //     if ($stmt->execute() && $stmt->rowCount() == 1) {
        //         $result = $stmt->fetch(PDO::FETCH_OBJ);
        //         $this->id = $result->id;
        //         $this->task = $result->task;
        //         $this->dateAdded = $result->date_added;
        //         $this->done = $result->done;
        //         return true;
        //     }
        //     return false;
        // }

        // public function readAll()
        // {
        //     $query = "SELECT * FROM " . $this->dbTable . " WHERE done = false";
        //     $stmt = $this->dbConnection->prepare($query);
        //     if ($stmt->execute() && $stmt->rowCount() > 0) {
        //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     }
        //     return [];
        // }

        public function fetchAllCategories(){
            $query = "SELECT * FROM " . $this->category_table;
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){
                //exec command
                $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
                return [];
        }


        // public function update()
        // {
        //     $query = "UPDATE " . $this->dbTable . " SET done=:done WHERE id=:id";
        //     $stmt = $this->dbConnection->prepare($query);
        //     $stmt->bindParam(":done", $this->done);
        //     $stmt->bindParam(":id", $this->id);
        //     if ($stmt->execute() && $stmt->rowCount() ==1) {
        //         return true;
        //     }
        //     return false;
        // }

        // public function delete()
        // {
        //     $query = "DELETE FROM " . $this->dbTable . " WHERE id=:id";
        //     $stmt = $this->dbConnection->prepare($query);
        //     $stmt->bindParam(":id", $this->id);
        //     if ($stmt->execute() && $stmt->rowCount() ==1) {
        //         return true;
        //     }
        //     return false;
        // }
    }
