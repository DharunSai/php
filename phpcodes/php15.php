<?php
$all_lines=file('https://www.w3resource.com/');

foreach($all_lines  as $linenum=> $line)
{
    echo "Line number  {$linenum} ". htmlspecialchars($line)."<br>";
}


echo $all_lines;
?>