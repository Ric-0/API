<?php
    include("db_connect.php");
    include("interface/GenreDAOi.php");
    global $conn;
    class GenreDAO implements GenreDAOi{
        public function createGenre($genre){
            global $conn;
            $sql = 'INSERT genre(nom) VALUES (?)';
            if($query = $conn->prepare($sql)){
                $query->bind_param('s', $genre->getNom());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function updateGenre($genre){
            global $conn;
            $sql = 'UPDATE genre SET nom = ? WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('si', $genre->getNom(), $genre->getIdGenre());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function deleteGenre($id){
            global $conn;
            $sql = 'DELETE FROM genre WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('i', $id);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function getGenre($id){
            global $conn;
            $query = $conn->prepare('SELECT * FROM genre WHERE id = ?');
            $query->bind_param('i', $id);
            $query->execute();
            $data = mysqli_fetch_array($query);
            return $data;
        }
        public function getAllGenre(){
            global $conn;
            $stmt = $conn->prepare('SELECT * FROM genre');
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $res = $result->fetch_all();
            return $res;
        }
    }
?>