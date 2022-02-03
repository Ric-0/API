<?php
    class Genre{
        private $idGenre;
        private $nom;

        function __construct($nom) {
        	$this->nom = $nom;
        
        }

        /**
         * @return string
         */
        public function __toString() {
        	return "IdGenre: {$this->idGenre}, Nom: {$this->nom}";
        }

        public function getIdGenre() {
        	return $this->idGenre;
        }

        /**
        * @param $idGenre
        */
        public function setIdGenre($idGenre) {
        	$this->idGenre = $idGenre;
        }

        public function getNom() {
        	return $this->nom;
        }

        /**
        * @param $nom
        */
        public function setNom($nom) {
        	$this->nom = $nom;
        }
    }
?>