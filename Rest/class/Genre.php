<?php
    require("../db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    function getGenres(){
        global $conn;
        $query = "SELECT * FROM genre";
        $response = array();        
        $result = mysqli_query($conn, $query);        
        while($row = mysqli_fetch_array($result)){            
            $response[] = $row;        
        }        
        header('Content-Type: application/json');        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function getGenre($id){
        global $conn;
        $query = "SELECT * FROM genre WHERE id = ".$id."";
        $response = array();        
        $result = mysqli_query($conn, $query);        
        while($row = mysqli_fetch_array($result)){            
            $response[] = $row;        
        }        
        header('Content-Type: application/json');        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function addGenre(){
        global $conn;
        $nom = $_POST["nom"];
        echo $query="INSERT INTO genre(nom) VALUES('".$nom."')";
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Genre ajoute avec succes.'
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

    function updateGenre($id){
        global $conn;
        $_PUT = array(); //tableau qui va contenir les données reçues
        parse_str(file_get_contents('php://input'), $_PUT);
        $nom = $_PUT["nom"];

        //construire la requête SQL
        $query="UPDATE genre SET nom='".$nom."' WHERE id=".$id;
        
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Genre mis a jour avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'Echec de la mise a jour de genre. '. mysqli_error($conn)
            );
        
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function deleteGenre($id){
        global $conn;
        $query = "DELETE FROM genre WHERE id=".$id;
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Genre supprime avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'La suppression du genre a echoue. '. mysqli_error($conn)
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    switch($request_method){        
        case 'GET': 
            if(!empty($_GET['id'])){
                $id = intval($_GET['id']);
                getGenre($id);
            }else{
                getGenres();   
            }              
            break;   
        case 'POST':
            addGenre();   
            break; 
        case 'PUT':
            $id = intval($_GET['id']);
            updateGenre($id);
            break; 
        case 'DELETE':
            $id = intval($_GET['id']);
            deleteGenre($id);
            break;
        default:// Invalid Request Method            
            header("HTTP/1.0 405 Method Not Allowed");            
            break;      
    }
?>