<?php
$url = "http://localhost/rest/Rest/Personne/7"; // modifier le livre 1
$data = array('nom' => 'Proust','prenom' => 'Marcel');

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

$response = curl_exec($ch);

var_dump($response);

if (!$response){
    return false;
}
?>