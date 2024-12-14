    <?php

    class Todo
    {
        private $cat_id;
        private $cat_title;
        private $bookmark_id;
        private $mark_title;
        private $mark_dateadded;
        private $mark_link;
        private $cat_dateAdded;
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
    
        public function setBookmarkId($bookmark_id){
            $this->bookmark_id = $bookmark_id;
        }

        public function getBookmarkId(){
            return $this->bookmark_id;
        }

        public function setCatId($cat_id){
            $this->cat_id = $cat_id;
        }

        public function getCatId(){
            return $this->cat_id;
        }

        public function setCatDateAdded($cat_dateAdded){
            $this->cat_dateAdded = $cat_dateAdded;
        }

        public function getCatDateAdded(){
            return $this->cat_dateAdded;
        }

        public function setMarkDateAdded($mark_dateadded){
            $this->mark_dateadded = $mark_dateadded;
        }

        public function getMarkDateAdded(){
            return $this->mark_dateadded;
        }

        public function setMarkLink($link){
            $this->mark_link = $link;
        }
        public function getMarkLink(){
            return $this->mark_link;
        }
        
        public function setMarkTitle($mark_title){
            $this->mark_title = $mark_title;
        }
        public function getMarkTitle(){
            return $this->mark_title;
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

        public function deleteCategory(){

            $query = "DELETE FROM " . $this->category_table . " WHERE id=:id";
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){

                $stmt->bindParam(":id", $this->cat_id, PDO::PARAM_INT);

                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    echo "Record deleted successfully";
                    return true;
                } else {
                    echo "Error: failed to delete the record";
                    return false;
                }
            }

        }


        public function createBookMark(){
            $query = "INSERT INTO " . $this->cat_mark_table . " (cat_id , title, link, date_added) VALUES(:cat_id, :title, :link, now());";
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){
                //exec command
                $stmt->bindParam(":link", $this->mark_link, PDO::PARAM_STR);
                $stmt->bindParam(":title", $this->mark_title, PDO::PARAM_STR);
                //sent from front_end
                $stmt->bindParam(":cat_id", $this->cat_id, PDO::PARAM_INT);
                
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

        public function FetchAllBookmarks()
        {
            $query = "SELECT * FROM " . $this->cat_mark_table;
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){
                //exec command
                $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
                return [];
        }

        public function deleteMark(){
            $query = "DELETE FROM " . $this->cat_mark_table . " WHERE mark_id=:id";
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){

                $stmt->bindParam(":id", $this->bookmark_id, PDO::PARAM_INT);

                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    echo "Record deleted successfully";
                    return true;
                } else {
                    echo "Error: failed to delete the record";
                    return false;
                }
            }
            
        }
        
        public function updateBookmark(){
            $query = "UPDATE " . $this->cat_mark_table . " SET title=:title, link=:link WHERE mark_id=:id";
            $stmt = $this->dbConnection->prepare($query);
            if($stmt){

                $stmt->bindParam(":id", $this->bookmark_id, PDO::PARAM_INT);
                $stmt->bindParam(":title", $this->mark_title, PDO::PARAM_STR);
                $stmt->bindParam(":link", $this->mark_link, PDO::PARAM_STR);

                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    echo "Record updated successfully";
                    return true;
                } else {
                    echo "Error: failed to updated the record";
                    return false;
                }
            }

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

    
    }
