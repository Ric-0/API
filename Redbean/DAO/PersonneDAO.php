<?php
    include("db_connect.php");
    include("interface/PersonneDAOi.php");
    global $conn;
    class PersonneDAO implements PersonneDAOi{
        public function createPersonne($p){
            $personne = R::dispense( 'personne' );
            $personne->nom = $p->getNom();
            $personne->prenom = $p->getPrenom();
            $id = R::store( $personne );
        }
        public function updatePersonne($p){
            $personne = R::load( 'personne', $p->getIdPersonne());
            $personne->nom = $p->getNom();
            $personne->prenom = $p->getPrenom();
            $id = R::store($personne);
        }
        public function deletePersonne($id){
            $personne = R::load('personne', $id);
            R::trash($personne);
        }
        public function getPersonne($id){
            $personne = R::load( 'personne', $id);
            return $personne;
        }
        public function getAllPersonne(){
            $vars = R::findAll('personne');
            return $vars;
        }
    }
?>