<?php
    include("db_connect.php");
    include("interface/LivreDAOi.php");
    global $conn;
    class LivreDAO implements LivreDAOi{
        public function createLivre($l){
            $livre = R::dispense( 'livre' );
            $livre->titre = $l->getTitre();
            $livre->id_auteur = $l->getIdAuteur();
            $id = R::store( $livre );
        }
        public function updateLivre($l){
            $livre = R::load( 'livre', $l->getIdLivre());
            $livre->titre = $l->getTitre();
            $livre->id_auteur = $l->getIdAuteur();
            $id = R::store($livre);
        }
        public function deleteLivre($id){
            $livre = R::load('livre', $id);
            R::trash($livre);
        }
        public function getLivre($id){
            $livre = R::load( 'livre', $id);
            return $livre;
        }
        public function getAllLivre(){
            $vars = R::findAll('livre');
            return $vars;
        }
        public function modifyAuteur($livre){
            
        }
        public function addGenre($idL,$idG){
            $lg = R::dispense( 'livregenre' );
            $lg->id_livre = $idL;
            $lg->id_genre = $idG;
            $id = R::store( $lg );
        }
        public function getAllLG(){
            $vars = R::findAll('livregenre');
            return $vars;
        }
        public function deleteLG($id){
            $lg = R::load('livregenre', $id);
            R::trash($lg);
        }
    }
?>