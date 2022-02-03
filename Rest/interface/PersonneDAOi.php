<?php
    interface PersonneDAOi{
        public function createPersonne($personne);
        public function updatePersonne($personne);
        public function deletePersonne($id);
        public function getPersonne($id);
        public function addBibliotheque($id,$idL);
        public function supprBibliotheque($idP,$idL);
    }
?>