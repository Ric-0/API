<?php
    interface LivreDAOi{
        public function createLivre($livre);
        public function updateLivre($livre);
        public function deleteLivre($id);
        public function getLivre($id);
        public function modifyAuteur($auteur);
    }
?>