<?php
    class Livre{
        private $idLivre;
        private $titre;
        private $genre;
        private $idAuteur;

        function __construct($titre, $idAuteur) {
        	$this->titre = $titre;
        	$this->idAuteur = $idAuteur;
        }

        /**
         * @return string
         */
        public function __toString() {
        	return "IdLivre: {$this->idLivre}, Titre: {$this->titre}, IdAuteur: {$this->idAuteur}";
        }

        public function getIdLivre() {
        	return $this->idLivre;
        }

        /**
        * @param $idLivre
        */
        public function setIdLivre($idLivre) {
        	$this->idLivre = $idLivre;
        }

        public function getTitre() {
        	return $this->titre;
        }

        /**
        * @param $titre
        */
        public function setTitre($titre) {
        	$this->titre = $titre;
        }

        public function getIdAuteur() {
        	return $this->idAuteur;
        }

        /**
        * @param $idAuteur
        */
        public function setIdAuteur($idAuteur) {
        	$this->idAuteur = $idAuteur;
        }

        public function getGenre() {
        	return $this->genre;
        }

        /**
        * @param $genre
        */
        public function setGenre($genre) {
        	$this->genre = $genre;
        }
    }
?>