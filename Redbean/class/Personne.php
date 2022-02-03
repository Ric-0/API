<?php
    class Personne{
        private $idPersonne;
        private $nom;
        private $prenom;
        private $bibliotheque;

        function __construct($nom, $prenom) {
        	$this->nom = $nom;
        	$this->prenom = $prenom;
        }

        /**
         * @return string
         */
        public function __toString() {
        	return "IdPersonne: {$this->idPersonne}, Nom: {$this->nom}, Prenom: {$this->prenom}, Bibliotheque: {$this->bibliotheque}";
        }

        public function getIdPersonne() {
        	return $this->idPersonne;
        }

        /**
        * @param $idPersonne
        */
        public function setIdPersonne($idPersonne) {
        	$this->idPersonne = $idPersonne;
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

        public function getPrenom() {
        	return $this->prenom;
        }

        /**
        * @param $prenom
        */
        public function setPrenom($prenom) {
        	$this->prenom = $prenom;
        }

        public function getBibliotheque() {
        	return $this->bibliotheque;
        }

        /**
        * @param $bibliotheque
        */
        public function setBibliotheque($bibliotheque) {
        	$this->bibliotheque = $bibliotheque;
        }
    }
?>