<?php
    include("db_connect.php");
    include("interface/PersonneDAOi.php");
    global $conn;
    class PersonneDAO implements PersonneDAOi{
        public function createPersonne($personne){
            global $conn;
            $sql = 'INSERT personne(nom,prenom) VALUES (?,?)';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ss', $personne->getNom(), $personne->getPrenom());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function updatePersonne($personne){
            global $conn;
            $sql = 'UPDATE personne SET nom = ? ,prenom = ? WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ssi', $personne->getNom(), $personne->getPrenom(), $personne->getIdPersonne());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function deletePersonne($id){
            global $conn;
            $sql = 'DELETE FROM personne WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('i', $id);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function getPersonne($id){
            $query = $conn->prepare('SELECT * FROM personne WHERE id = :id');
            $query->bind_param(':id', $id);
            $query->execute();
            $data = mysqli_fetch_array($query);
            return $data;
        }
        public function getAllPersonne(){
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM personne");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $res = $result->fetch_all();
            return $res;
        }
        public function addBibliotheque($id,$idL){
            global $conn;
            $sql = 'INSERT bibliotheque(idPersonne,idLivre) VALUES (?,?)';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ii', $id, $idL);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function supprBibliotheque($idP,$idL){
            global $conn;
            $sql = 'DELETE FROM bibliotheque WHERE idPersonne = ? AND idLivre = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ii', $idP, $idL);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function getBibliothequeByP($idP){
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM bibliotheque WHERE idPersonne = ?");
            $stmt->bind_param('i',$idP);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $res = $result->fetch_all();
            return $res;
        }
    }
?>