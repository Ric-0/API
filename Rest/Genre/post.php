<?php
  $url = 'http://localhost/rest/Rest/Genre';
  $data = array('nom' => 'Fable');

  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if ($result === FALSE) { 
    /* Handle error */ 
  }

  var_dump($result);