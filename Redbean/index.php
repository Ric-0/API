<?php
    require 'public/redbean/rb.php';//1
    R::setup('mysql:host=127.0.0.1;dbname=biblio', 'root', '');//2
    
    /*$photo = R::dispense( 'photo' );//3
    $photo->title = 'Mes vacances';
    $id = R::store( $photo );//4
    $photo_copie = R::load( 'photo', $id );//5
    R::trash( $photo_copie );//6
    $photos = R::find('photo', ' title LIKE ?', [ 'vacances' ] );//7  */




    include("db_connect.php");
    require('DAO/PersonneDAO.php');
    require('DAO/AuteurDAO.php');
    require('class/Auteur.php');
    require('DAO/LivreDAO.php');
    require('class/Livre.php');
    require('DAO/GenreDAO.php');
    require('class/Genre.php');
    require('DAO/BibliothequeDAO.php');

    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    //$auteur = new Auteur('Jean','Pierre');

    $auteurDAO = new AuteurDAO();
    $personneDAO = new PersonneDAO();
    $livreDAO = new LivreDAO();
    $genreDAO = new GenreDAO();
    $bibliothequeDAO = new BibliothequeDAO();

    $listeLG = $livreDAO->getAllLG();

    //$auteurDAO->createAuteur($auteur);

    if($_POST){
        switch($_POST['type']) {
            case 'auteurU':
                $auteur = new Auteur($_POST['nom'],$_POST['prenom']);
                $auteur->setIdPersonne($_POST['id']);
                $auteurDAO->updateAuteur($auteur);
                break;
            case 'auteurS':
                $auteurDAO->deleteAuteur($_POST['id']);
                break;
            case 'auteurA':
                $auteur = new Auteur($_POST['nom'],$_POST['prenom']);
                $auteurDAO->createAuteur($auteur);
                break;
            case 'personneU':
                $personne = new Personne($_POST['nom'],$_POST['prenom']);
                $personne->setIdPersonne($_POST['id']);
                $personneDAO->updatePersonne($personne);
                break;
            case 'personneS':
                $personneDAO->deletePersonne($_POST['id']);
                break;
            case 'personneA':
                $personne = new Personne($_POST['nom'],$_POST['prenom']);
                $personneDAO->createPersonne($personne);
                break;
            case 'livreU':
                $livre = new Livre($_POST['titre'],$_POST['idA']);
                $livre->setIdLivre($_POST['id']);
                $livreDAO->updateLivre($livre);
                break;
            case 'livreS':
                $livreDAO->deleteLivre($_POST['id']);
                break;
            case 'livreA':
                if($_POST['idA'] != 0){
                    $livre = new Livre($_POST['titre'],$_POST['idA']);
                    $livreDAO->createLivre($livre);
                }
                break;
            case 'genreU':
                $genre = new Genre($_POST['nom']);
                $genre->setIdGenre($_POST['id']);
                $genreDAO->updateGenre($genre);
                break;
            case 'genreS':
                $genreDAO->deleteGenre($_POST['id']);
                break;
            case 'genreA':
                $genre = new Genre($_POST['nom']);
                $genreDAO->createGenre($genre);
                break;
            case 'lgA':
                $etat = false;
                foreach($listeLG as $lg){
                    if($lg['id_livre'] == $_POST['idL'] && $lg['id_genre'] == $_POST['idG']){
                        $etat = true;
                    }
                }
                if($etat == false){
                    $livreDAO->addGenre($_POST['idL'],$_POST['idG']);
                }
                break;
            case 'lgS':
                $livreDAO->deleteLG($_POST['id']);
                break;
            case 'biblioA':
                $bibliothequeDAO->addBibliotheque($_POST['idP'],$_POST['idL']);
                break;
            case 'biblioS':
                $bibliothequeDAO->supprBibliotheque($_POST['id']);
                break;
        }
    }
    $auteurs = $auteurDAO->getAllAuteur();
    $personnes = $personneDAO->getAllPersonne();
    $livres = $livreDAO->getAllLivre();
    $genres = $genreDAO->getAllGenre();
    $listeLG = $livreDAO->getAllLG();

    
    R::close();//8

    ?>
    <div>
        <h1>Auteur</h1>
        <?php
            foreach($auteurs as $auteur){ ?>
                <div class='form'>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='auteurU'>
                        <input name='id' type='hidden' value='<?= $auteur['id'] ?>'>
                        <input name='nom' type='text' value='<?= $auteur['nom'] ?>'>
                        <input name='prenom' type='text' value='<?= $auteur['prenom'] ?>'>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='auteurS'>
                        <input name='id' type='hidden' value='<?= $auteur['id'] ?>'>
                        <input type='submit' value='Supprimer'>
                    </form>
                </div>
            <?php } ?>
            <form action='index.php' method='post'>
                    <input name='type' type='hidden' value='auteurA'>
                    <input name='nom' type='text' value="nom de l'auteur">
                    <input name='prenom' type='text' value="prenom de l'auteur">
                    <input type='submit' value='Ajouter'>
                </form>
            <?php
        ?>
        <h1>Personne</h1>
        <?php
            foreach($personnes as $personne){ ?>
                <div class='form'>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='personneU'>
                        <input name='id' type='hidden' value='<?= $personne['id'] ?>'>
                        <input name='nom' type='text' value='<?= $personne['nom'] ?>'>
                        <input name='prenom' type='text' value='<?= $personne['prenom'] ?>'>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='personneS'>
                        <input name='id' type='hidden' value='<?= $personne['id'] ?>'>
                        <input type='submit' value='Supprimer'>
                    </form>
                </div>
                <?php
                $bibliotheque = $bibliothequeDAO->getBibliothequeByP($personne['id']);
                foreach($bibliotheque as $biblio){ ?>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='biblioS'>
                        <input name='id' type='hidden' value='<?= $biblio['id'] ?>'>
                        <input name='idL' type='hidden' value='<?= $biblio['id_livre'] ?>'>
                        <?php
                            foreach($livres as $livre){
                                if($livre['id'] == $biblio['id_livre']){ ?>
                                    <input type='submit' value='Supprimer le livre "<?= $livre['titre'] ?>"'>
                                    <?php
                                }
                            }
                        ?>
                    </form>
                    <?php
                }
                ?>
            <?php } ?>
            <form action='index.php' method='post'>
                    <input name='type' type='hidden' value='personneA'>
                    <input name='nom' type='text' value="nom de l'auteur">
                    <input name='prenom' type='text' value="prenom de l'auteur">
                    <input type='submit' value='Ajouter'>
                </form>
            <?php
            
        ?>
        <h1>Livre</h1>
        <?php
            foreach($livres as $livre){ ?>
                <div class='form'>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='livreU'>
                        <input name='id' type='hidden' value='<?= $livre['id'] ?>'>
                        <input name='titre' type='text' value='<?= $livre['titre'] ?>'>
                        <select name='idA'>
                            <?php 
                                foreach($auteurs as $auteur) {
                                    if($livre['id_auteur'] == $auteur['id']){ 
                                        ?>
                                        <option value='<?= $auteur['id'] ?>' selected='selected'><?php echo $auteur['prenom'].' '.$auteur['nom'] ?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value='<?= $auteur['id'] ?>'><?php echo $auteur['prenom'].' '.$auteur['nom'] ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='livreS'>
                        <input name='id' type='hidden' value='<?= $livre['id'] ?>'>
                        <input type='submit' value='Supprimer'>
                    </form>
                    <?php
                        foreach($listeLG as $lg){
                            if($lg['id_livre'] == $livre['id']){ ?>
                                <form action='index.php' method='post'>
                                    <input name='type' type='hidden' value='lgS'>
                                    <input name='id' type='hidden' value='<?= $lg['id'] ?>'>
                                    <input name='idG' type='hidden' value='<?= $lg['id_genre'] ?>'>
                                    <?php
                                        foreach($genres as $genre){
                                            if($genre['id'] == $lg['id_genre']){ ?>
                                                <input type='submit' value='Supprimer le genre "<?= $genre['nom'] ?>"'>
                                                <?php
                                            }
                                        }
                                    ?>
                                </form>
                            <?php
                            }
                        }
                    ?>
                </div>
            <?php } ?>
            <form action='index.php' method='post'>
                    <input name='type' type='hidden' value='livreA'>
                    <input name='titre' type='text' value="titre du livre">
                    <select name='idA'>
                        <option value='0' selected="selected">Sélectionner un auteur</option>
                        <?php
                            foreach($auteurs as $auteur) {
                        ?>
                        <option value='<?= $auteur['id'] ?>'><?php echo $auteur['prenom'].' '.$auteur['nom'] ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <input type='submit' value='Ajouter'>
                </form>
            <?php
        ?>
        <h1>Genre</h1>
        <?php
            foreach($genres as $genre){ ?>
                <div class='form'>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='genreU'>
                        <input name='id' type='hidden' value='<?= $genre['id'] ?>'>
                        <input name='nom' type='text' value='<?= $genre['nom'] ?>'>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='genreS'>
                        <input name='id' type='hidden' value='<?= $genre['id'] ?>'>
                        <input type='submit' value='Supprimer'>
                    </form>
                </div>
            <?php } ?>
            <form action='index.php' method='post'>
                    <input name='type' type='hidden' value='genreA'>
                    <input name='nom' type='text' value="nom du genre">
                    <input type='submit' value='Ajouter'>
                </form>
            <?php
        ?>
        <h1>Ajouter un genre à un livre</h1>
        <form action='index.php' method='post'>
            <input name='type' type='hidden' value='lgA'>
            <select name='idL'>
                <option value='0' selected="selected">Sélectionner un livre</option>
                <?php
                    foreach($livres as $livre) {
                ?>
                <option value='<?= $livre['id'] ?>'><?php echo $livre['titre'] ?></option>
                <?php
                    }
                ?>
            </select>
            <select name='idG'>
                <option value='0' selected="selected">Sélectionner un genre</option>
                <?php
                    foreach($genres as $genre) {
                ?>
                <option value='<?= $genre['id'] ?>'><?php echo $genre['nom'] ?></option>
                <?php
                    }
                ?>
            </select>
            <input type='submit' value='Ajouter'>
        </form>
        <h1>Ajouter un livre à une bibliotheque</h1>
        <form action='index.php' method='post'>
            <input name='type' type='hidden' value='biblioA'>
            <select name='idL'>
                <option value='0' selected="selected">Sélectionner un livre</option>
                <?php
                    foreach($livres as $livre) {
                ?>
                <option value='<?= $livre['id'] ?>'><?php echo $livre['titre'] ?></option>
                <?php
                    }
                ?>
            </select>
            <select name='idP'>
                <option value='0' selected="selected">Sélectionner une personne</option>
                <?php
                    foreach($personnes as $personne) {
                ?>
                <option value='<?= $personne['id'] ?>'><?php echo $personne['prenom'].' '.$personne['nom'] ?></option>
                <?php
                    }
                ?>
            </select>
            <input type='submit' value='Ajouter'>
        </form>
    </div>
    <?php
?>