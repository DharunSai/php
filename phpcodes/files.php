<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

        // $filename='hello.txt';

        // $file=fopen($filename,'r');

        // if($file==false)
        // {
        //     echo "error in opening the file";
        //     exit();
        // }

        // $filesize=filesize($filename);
        // $filetext = fread($file, 33);

        // fclose($file);

        // echo "<p>{$filetext}</p>";

        $filename1="spanish.txt";
        $file = fopen($filename1,"w");

        

        if($file==false)
        {
            echo "error in opening the file hey<br>";
           
        }


        if(file_exists($filename1))
        {
            echo filesize($filename);



        }
        else{
            echo "no file exists";
        }

        if($file)
        {
            echo "hello";
        }
        else
        {
            echo "worst behaviour";
        }


        fwrite($file,"This isawesome ");

        fclose($file);

        
    
    ?>
</body>
</html>