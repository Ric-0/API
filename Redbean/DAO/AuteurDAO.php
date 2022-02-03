<?php

    require("db_connect.php");
    require('interface/AuteurDAOi.php');
    class AuteurDAO implements AuteurDAOi{
        public function createAuteur($a){
            $auteur = R::dispense( 'personne' );
            $auteur->nom = $a->getNom();
            $auteur->prenom = $a->getPrenom();
            $auteur->auteur = true;
            $id = R::store( $auteur );
        }
        public function updateAuteur($a){
            $auteur = R::load( 'personne', $a->getIdPersonne());
            $auteur->nom = $a->getNom();
            $auteur->prenom = $a->getPrenom();
            $id = R::store($auteur);
        }
        public function deleteAuteur($id){
            $auteur = R::load('personne', $id);
            R::trash($auteur);
        }
        public function getAuteur($id){
            $auteur = R::load( 'personne', $id);
            return $auteur;
        }
        public function getAllAuteur(){
            $vars = R::findAll('personne','auteur = true');
            return $vars;
        }
        public function addOeuvre($oeuvre){

        }
        public function supprOeuvre($idO){

        }
        
    }
?>