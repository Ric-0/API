<?php
    require("../db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    function getPersonnes(){
        global $conn;
        $query = "SELECT * FROM personne";
        $response = array();        
        $result = mysqli_query($conn, $query);        
        while($row = mysqli_fetch_array($result)){            
            $response[] = $row;        
        }        
        header('Content-Type: application/json');        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function getPersonne($id){
        global $conn;
        $query = "SELECT * FROM personne WHERE id = ".$id."";
        $response = array();        
        $result = mysqli_query($conn, $query);        
        while($row = mysqli_fetch_array($result)){            
            $response[] = $row;        
        }        
        header('Content-Type: application/json');        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function addPersonne(){
        global $conn;
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        echo $query="INSERT INTO personne(nom,prenom) VALUES('".$nom."','".$prenom."')";
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Personne ajoute avec succes.'
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

    function updatePersonne($id){
        global $conn;
        $_PUT = array(); //tableau qui va contenir les données reçues
        parse_str(file_get_contents('php://input'), $_PUT);
        $nom = $_PUT["nom"];
        $prenom = $_PUT["prenom"];

        //construire la requête SQL
        $query="UPDATE personne SET nom='".$nom."', prenom='".$prenom."' WHERE id=".$id;
        
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Personne mis a jour avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'Echec de la mise a jour de la personne. '. mysqli_error($conn)
            );
        
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function deletePersonne($id){
        global $conn;
        $query = "DELETE FROM personne WHERE id=".$id;
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Personne supprime avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'La suppression de la personne a echoue. '. mysqli_error($conn)
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    switch($request_method){        
        case 'GET': 
            if(!empty($_GET['id'])){
                $id = intval($_GET['id']);
                getPersonne($id);
            }else{
                getPersonnes();   
            }              
            break;   
        case 'POST':
            addPersonne();   
            break; 
        case 'PUT':
            $id = intval($_GET['id']);
            updatePersonne($id);
            break; 
        case 'DELETE':
            $id = intval($_GET['id']);
            deletePersonne($id);
            break;
        default:// Invalid Request Method            
            header("HTTP/1.0 405 Method Not Allowed");            
            break;      
    }
?>