<form action="<?php $_PHP_SELF ?>" method="GET">
<label>Enter details</label>

<input type="text" name="text" />
<input type="submit" />

</form>


<?php

if($_GET['text'])
{
    echo $_GET['text'];
}


?>