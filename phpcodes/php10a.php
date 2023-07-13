<?php
$array1 = array(array(77, 87), array(23, 45));
$array2 = array("w3resource", "com");
function merge_arrays_by_index($x, $y)
{
$temp = array(); $temp[] = $x; if(is_scalar($y))
{
$temp[] = $y;
}
else
{
foreach($y as $k => $v)
{
$temp[] = $v;
}
}
return $temp;
}
echo '<pre>'; print_r(array_map('merge_arrays_by_index',$array2, $array1));
?>