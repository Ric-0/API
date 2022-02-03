<?php

    require("db_connect.php");
    require('interface/AuteurDAOi.php');
    class AuteurDAO implements AuteurDAOi{
        public function createAuteur($auteur){
            global $conn;
            $sql = 'INSERT personne(id,nom,prenom,auteur) VALUES (null,?,?,true)';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ss', $auteur->getNom(), $auteur->getPrenom());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function updateAuteur($auteur){
            global $conn;
            $sql = 'UPDATE personne SET nom = ? ,prenom = ? WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ssi', $auteur->getNom(), $auteur->getPrenom(), $auteur->getIdPersonne());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function deleteAuteur($id){
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
        public function getAuteur($id){
            global $conn;
            $query = $conn->prepare('SELECT * FROM personne WHERE id = :id AND auteur = 1');
            $query->bind_param(':id', $id);
            $query->execute();
            $data = mysqli_fetch_array($query);
            return $data;
        }
        public function getAllAuteur(){
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM personne WHERE auteur = 1");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $res = $result->fetch_all();
            return $res;
        }
        public function addOeuvre($oeuvre){

        }
        public function supprOeuvre($idO){

        }
        
    }
?>