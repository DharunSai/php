<?php 

    setcookie("name", "John Watkin", time()+3600, "/","", 0);
    if(isset($_COOKIE['name']))
    {
        echo "Welcome puppy ma";
    }
    else{
        echo "sorry";
    }

    

?>