<?php $email = "dharundash@gmail.com";


if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
     echo '"' . $email . '" = Valid'."\n";
}
else 
{
     echo '"' . $email . '" = Invalid'."\n";
}

?>