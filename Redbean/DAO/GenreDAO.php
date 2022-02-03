<?php
    include("db_connect.php");
    include("interface/GenreDAOi.php");
    global $conn;
    class GenreDAO implements GenreDAOi{
        public function createGenre($g){
            $genre = R::dispense( 'genre' );
            $genre->nom = $g->getNom();
            $id = R::store( $genre );
        }
        public function updateGenre($g){
            $genre = R::load( 'genre', $g->getIdGenre());
            $genre->nom = $g->getNom();
            $id = R::store($genre);
        }
        public function deleteGenre($id){
            $genre = R::load('genre', $id);
            R::trash($genre);
        }
        public function getGenre($id){
            $genre = R::load( 'genre', $id);
            return $genre;
        }
        public function getAllGenre(){
            $vars = R::findAll('genre');
            return $vars;
        }
    }
?>