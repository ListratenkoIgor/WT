<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
    <title>Lab_3</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lab3.css">
    <meta name="variant" content="4">
    <meta name="description" content="Написать функцию, формирующую полный 
    список файлов в указанном каталоге (включая подкаталоги) и считающую общий
    объём файлов. Имя каталога, в котором следует выполнять поиск, получать 
    через веб-форму. Отобразить в табличном виде.">
</head>

<body>
    <!--- 
	 html form with 1 input
	 --->
    <form class="" action="lab3.php" method="post">
        <span class="intro-text">Directory for search:</span>
        <input class="input-field" type="text" name="dir">
        <?php
        $present_post = isset($_POST['dir']);
        ?>
        <button class="button-submit" type="submit" name="btn">Submit</button>

    </form>

    <p>
        <?php
        //function to print files in directory(recursive)
        function printDirectoryTree($dir, $parent = 0)
        {
            if ($parent == 0)
                echo "<ul>\r\n";
            echo "<li class=\"dir\"><a>$dir</a></li>\r\n";
            echo "<ul>\r\n";
            //get array with "files" from [$dir] directory
            $files = scandir($dir);
            foreach ($files as $file) {
                //skip parent and current directories
                if ($file == "." || $file == "..")
                    continue;
                $path = $dir . "\\" . $file;

                if (is_dir($path)) {
                    printDirectoryTree($path, 1);
                } else {
                    //if "file" is a file add its size to common size (declare in code later)
                    $GLOBALS["common_size"] += filesize($path);
                    echo "<li class=\"file\"><a>$file</a></li>\r\n";
                }
            }
            echo "</ul>\r\n";
            if ($parent == 0)
                echo "</ul>\r\n";
        }
        //function that checks direction for existens
        function checkInput($dir): bool
        {
            return is_dir($dir);
        }

        if ($present_post) {
            $dir = trim($_POST['dir'], " \\/\t\n\r\0\x0B");
            //validate input 
            if (!checkInput($dir)) {
                echo "Директории с таким названием не найдено попробуйте снова" . '<br>';
                exit;
            }

            $common_size = 0;
            //print recursive content from directory
            printDirectoryTree($dir);
            echo '<br>';
            //output size of all files in directory
            echo "Общий размер всех файлов: $common_size байт";
            unset($_POST['dir']);
        }
        ?>
    </p>
</body>

</html>