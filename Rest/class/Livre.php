<?php
    require("../db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    function getLivres(){
        global $conn;
        $query = "SELECT * FROM livre";
        $response = array();        
        $result = mysqli_query($conn, $query);        
        while($row = mysqli_fetch_array($result)){            
            $response[] = $row;        
        }        
        header('Content-Type: application/json');        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function getLivre($id){
        global $conn;
        $query = "SELECT * FROM livre WHERE id = ".$id."";
        $response = array();        
        $result = mysqli_query($conn, $query);        
        while($row = mysqli_fetch_array($result)){            
            $response[] = $row;        
        }        
        header('Content-Type: application/json');        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function addLivre(){
        global $conn;
        $titre = $_POST["titre"];
        $auteur = $_POST["auteur"];
        echo $query="INSERT INTO livre(titre, idAuteur) VALUES('".$titre."', '".$auteur."')";
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Livre ajoute avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'ERREUR!.'. mysqli_error($conn)
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function updateLivre($id){
        global $conn;
        $_PUT = array(); //tableau qui va contenir les données reçues
        parse_str(file_get_contents('php://input'), $_PUT);
        $titre = $_PUT["titre"];
        $auteur = $_PUT["auteur"];

        //construire la requête SQL
        $query="UPDATE livre SET titre='".$titre."', idAuteur='".$auteur."' WHERE id=".$id;
        
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Livre mis a jour avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'Echec de la mise a jour de livre. '. mysqli_error($conn)
            );
        
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function deleteLivre($id){
        global $conn;
        $query = "DELETE FROM livre WHERE id=".$id;
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Livre supprime avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'La suppression du livre a echoue. '. mysqli_error($conn)
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    switch($request_method){        
        case 'GET': 
            if(!empty($_GET['id'])){
                $id = intval($_GET['id']);
                getLivre($id);
            }else{
                getLivres();   
            }              
            break;   
        case 'POST':
            addLivre();   
            break; 
        case 'PUT':
            $id = intval($_GET['id']);
            updateLivre($id);
            break; 
        case 'DELETE':
            $id = intval($_GET['id']);
            deleteLivre($id);
            break;
        default:// Invalid Request Method            
            header("HTTP/1.0 405 Method Not Allowed");            
            break;      
    }
?>