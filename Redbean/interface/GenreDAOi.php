<?php
    interface GenreDAOi{
        public function createGenre($genre);
        public function updateGenre($genre);
        public function deleteGenre($id);
        public function getGenre($id);
    }
?>