

<p>Enter a number </p><br>
<form method="GET" action="php32.php">
<input type="number" name="number" />
<input type="submit">

<p><?php echo $sum ?></p>
</form>
<?php

$value = $_REQUEST['number'];

// echo $value;
$value1 = $value;


while ($value1>1)
{   
    $r=0;
    $r3=0;
    $r = $value1%10;

    $r3=$r**3;
    
    $sum+=$r3;
    $value1=$value1/10;
    
    // echo $value1;
    

}



echo $sum;

if($sum==$value)
{
    echo "<p>It is an amstrong number</p>";
}
else{
    echo "<p>Not an amstrong number</p>";
}




?>