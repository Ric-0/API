<?php
    require('Personne.php');
    class Auteur extends Personne{
        private $oeuvres;

        function __construct($nom,$prenom) {
            parent::__construct($nom,$prenom);
        }

        /**
         * @return string
         */
        public function __toString() {
        	return super()->toString()."Oeuvres: {$this->oeuvres}";
        }

        public function getOeuvres() {
        	return $this->oeuvres;
        }

        /**
        * @param $oeuvres
        */
        public function setOeuvres($oeuvres) {
        	$this->oeuvres = $oeuvres;
        }
    }
?>