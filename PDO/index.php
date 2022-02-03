<?php
    include("db_connect.php");
    require('DAO/PersonneDAO.php');
    require('DAO/AuteurDAO.php');
    require('class/Auteur.php');
    require('DAO/LivreDAO.php');
    require('class/Livre.php');
    require('DAO/GenreDAO.php');
    require('class/Genre.php');

    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    //$auteur = new Auteur('Jean','Pierre');

    $auteurDAO = new AuteurDAO();
    $personneDAO = new PersonneDAO();
    $livreDAO = new LivreDAO();
    $genreDAO = new GenreDAO();

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
                    if($lg[0] == $_POST['idL'] && $lg[1] == $_POST['idG']){
                        $etat = true;
                    }
                }
                if($etat == false){
                    $livreDAO->addGenre($_POST['idL'],$_POST['idG']);
                }
                break;
            case 'lgS':
                $livreDAO->deleteLG($_POST['idL'],$_POST['idG']);
                break;
            case 'biblioA':
                $personneDAO->addBibliotheque($_POST['idP'],$_POST['idL']);
                break;
            case 'biblioS':
                $personneDAO->supprBibliotheque($_POST['idP'],$_POST['idL']);
                break;
        }
    }
    $auteurs = $auteurDAO->getAllAuteur();
    $personnes = $personneDAO->getAllPersonne();
    $livres = $livreDAO->getAllLivre();
    $genres = $genreDAO->getAllGenre();
    $listeLG = $livreDAO->getAllLG();

    ?>
    <div>
        <h1>Auteur</h1>
        <?php
            foreach($auteurs as $auteur){ ?>
                <div class='form'>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='auteurU'>
                        <input name='id' type='hidden' value='<?= $auteur[0] ?>'>
                        <input name='nom' type='text' value='<?= $auteur[1] ?>'>
                        <input name='prenom' type='text' value='<?= $auteur[2] ?>'>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='auteurS'>
                        <input name='id' type='hidden' value='<?= $auteur[0] ?>'>
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
                        <input name='id' type='hidden' value='<?= $personne[0] ?>'>
                        <input name='nom' type='text' value='<?= $personne[1] ?>'>
                        <input name='prenom' type='text' value='<?= $personne[2] ?>'>
                        <!--<input name='fonction' type='checkbox' value='1' <?php //echo ($personne[3] == 1) ? 'checked="checked' : ""; ?>>-->
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='personneS'>
                        <input name='id' type='hidden' value='<?= $personne[0] ?>'>
                        <input type='submit' value='Supprimer'>
                    </form>
                </div>
                <?php
                $bibliotheque = $personneDAO->getBibliothequeByP($personne[0]);
                foreach($bibliotheque as $biblio){ ?>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='biblioS'>
                        <input name='idP' type='hidden' value='<?= $biblio[0] ?>'>
                        <input name='idL' type='hidden' value='<?= $biblio[1] ?>'>
                        <?php
                            foreach($livres as $livre){
                                if($livre[0] == $biblio[1]){ ?>
                                    <input type='submit' value='Supprimer le livre "<?= $livre[1] ?>"'>
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
                        <input name='id' type='hidden' value='<?= $livre[0] ?>'>
                        <input name='titre' type='text' value='<?= $livre[1] ?>'>
                        <select name='idA'>
                            <?php
                                foreach($auteurs as $auteur) {
                                    if($livre[2] == $auteur[0]){
                                        ?>
                                        <option value='<?= $auteur[0] ?>' selected='selected'><?php echo $auteur[2].' '.$auteur[1] ?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value='<?= $auteur[0] ?>'><?php echo $auteur[2].' '.$auteur[1] ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='livreS'>
                        <input name='id' type='hidden' value='<?= $livre[0] ?>'>
                        <input type='submit' value='Supprimer'>
                    </form>
                    <?php
                        foreach($listeLG as $lg){
                            if($lg[0] == $livre[0]){ ?>
                                <form action='index.php' method='post'>
                                    <input name='type' type='hidden' value='lgS'>
                                    <input name='idL' type='hidden' value='<?= $livre[0] ?>'>
                                    <input name='idG' type='hidden' value='<?= $lg[1] ?>'>
                                    <?php
                                        foreach($genres as $genre){
                                            if($genre[0] == $lg[1]){ ?>
                                                <input type='submit' value='Supprimer le genre "<?= $genre[1] ?>"'>
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
                        <option value='<?= $auteur[0] ?>'><?php echo $auteur[2].' '.$auteur[1] ?></option>
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
                        <input name='id' type='hidden' value='<?= $genre[0] ?>'>
                        <input name='nom' type='text' value='<?= $genre[1] ?>'>
                        <input type='submit' value='Modifier'>
                    </form>
                    <form action='index.php' method='post'>
                        <input name='type' type='hidden' value='genreS'>
                        <input name='id' type='hidden' value='<?= $genre[0] ?>'>
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
                <option value='<?= $livre[0] ?>'><?php echo $livre[1] ?></option>
                <?php
                    }
                ?>
            </select>
            <select name='idG'>
                <option value='0' selected="selected">Sélectionner un genre</option>
                <?php
                    foreach($genres as $genre) {
                ?>
                <option value='<?= $genre[0] ?>'><?php echo $genre[1] ?></option>
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
                <option value='<?= $livre[0] ?>'><?php echo $livre[1] ?></option>
                <?php
                    }
                ?>
            </select>
            <select name='idP'>
                <option value='0' selected="selected">Sélectionner une personne</option>
                <?php
                    foreach($personnes as $personne) {
                ?>
                <option value='<?= $personne[0] ?>'><?php echo $personne[2].' '.$personne[1] ?></option>
                <?php
                    }
                ?>
            </select>
            <input type='submit' value='Ajouter'>
        </form>
    </div>
    <?php
?>