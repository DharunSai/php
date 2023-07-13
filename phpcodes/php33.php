<p>Enter a number </p><br>
<form method="POST" action="php33.php">
<input type="number" name="number" />
<input type="submit">

<p><?php echo $sum ?></p>
</form>
<?php

$value = $_REQUEST['number'];

// echo $value;

$val = $value;

while($val>=1)
{
    $binary=strval($binary).strval($val%2);
    
    $val=$val/2;
}

echo "The binary is ".strrev($binary);

$bstring = strrev($binary);

if($bstring[2]==$bstring[3])
{
    echo $bstring[2];
}
else
{
    echo $bstring[3];
}




?>