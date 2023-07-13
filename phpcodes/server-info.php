<?php  
    #$_SERVER super global

    //create server array

    $server =[
        'Host Server Name' => 'hello',
        'Host Header' => $_SERVER['HOST_HEADER']


    ];

    foreach($server as $s)
    {
        echo $s.'<br>';
    }
  
   

    foreach($_SERVER as $key=>$val)
    {
     
         echo $key."   ". $val."<br>";
    }
    //      echo $server['Host Server Name'];
    // echo $_SERVER['SERVER_NAME'];
    // echo $_SERVER['HTTP_HOST'];
    // // echo $_SERVER['HTTP_USER_AGENT'];
    // echo $_SERVER['SERVER_PROTOCOL'];
    // echo $_SERVER['PHP_SELF'];
    // echo $_SERVER['GATEWAY_INTERFACE'];
    // echo $_SERVER['SERVER_NAME'];
    // echo $_SERVER['SERVER_ADDR'];
    // echo $_SERVER['REQUEST_METHOD'];
    // echo $_SERVER['REMOTE_ADDR'];
    // echo $_SERVER['REMOTE_HOST'];
    // echo $_SERVER['SCRIPT_NAME'];
    //create client array

?>