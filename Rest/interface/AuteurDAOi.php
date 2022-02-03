<?php
    interface AuteurDAOi{
        public function createAuteur($auteur);
        public function updateAuteur($auteur);
        public function deleteAuteur($id);
        public function getAuteur($id);
        public function addOeuvre($oeuvre);
        public function supprOeuvre($idO);
    }
?>