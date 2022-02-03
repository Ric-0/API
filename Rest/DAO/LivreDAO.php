<?php
    include("db_connect.php");
    include("interface/LivreDAOi.php");
    global $conn;
    class LivreDAO implements LivreDAOi{
        public function createLivre($livre){
            global $conn;
            $sql = 'INSERT livre(titre,idAuteur) VALUES (?,?)';
            if($query = $conn->prepare($sql)){
                $query->bind_param('si', $livre->getTitre(), $livre->getIdAuteur());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function updateLivre($livre){
            global $conn;
            $sql = 'UPDATE livre SET titre = ?, idAuteur = ? WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('sii', $livre->getTitre(), $livre->getIdAuteur(), $livre->getIdLivre());
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function deleteLivre($id){
            global $conn;
            $sql = 'DELETE FROM livre WHERE id = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('i', $id);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function getLivre($id){
            global $conn;
            $query = $conn->prepare('SELECT * FROM livre WHERE id = :id');
            $query->bind_param(':id', $id);
            $query->execute();
            $data = mysqli_fetch_array($query);
            return $data;
        }
        public function getAllLivre(){
            global $conn;
            $stmt = $conn->prepare('SELECT * FROM livre');
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $res = $result->fetch_all();
            return $res;
        }
        public function modifyAuteur($livre){
            global $conn;
            $query = $conn->prepare('UPDATE livre SET idAuteur = :idAuteur WHERE id = :id');
            $query->bind_param(':idAuteur', $livre->getIdAuteur());
            $query->bind_param(':id', $livre->getId());
            $query->execute();
        }
        public function addGenre($idL,$idG){
            global $conn;
            $sql = 'INSERT livregenre(idLivre,idGenre) VALUES (?,?)';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ii', $idL, $idG);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
        public function getAllLG(){
            global $conn;
            $stmt = $conn->prepare('SELECT * FROM livregenre');
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $res = $result->fetch_all();
            return $res;
        }
        public function deleteLG($idL,$idG){
            global $conn;
            $sql = 'DELETE FROM livregenre WHERE idLivre = ? AND idGenre = ?';
            if($query = $conn->prepare($sql)){
                $query->bind_param('ii', $idL, $idG);
                $query->execute();
            }else{
                $error = $conn->errno.' '. $conn->error;
                echo $error.'<br>';
            }
        }
    }
?>