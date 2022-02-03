<?php
    class BibliothequeDAO{
        public function addBibliotheque($id,$idL){
            $bibliotheque = R::dispense( 'bibliotheque' );
            $bibliotheque->id_personne = $id;
            $bibliotheque->id_livre = $idL;
            var_dump($bibliotheque);
            $id = R::store( $bibliotheque );
        }
        public function supprBibliotheque($id){
            $bibliotheque = R::load('bibliotheque', $id);
            R::trash($bibliotheque);
        }
        public function getBibliothequeByP($idP){
            $vars = R::findAll('bibliotheque','id_personne = '.$idP.'');
            return $vars;
        }
    }
?>