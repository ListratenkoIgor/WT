<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
    <title>Lab_4</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lab4.css">
    <meta name="variant" content="13">
    <meta name="description" content="Дан длинный текст, в нём встречаются 
    слова длиннее 7 символов! Если слово длиннее 7 символов, то необходимо:
    оставить первые 6 символа и добавить звёздочку. Остальные символы 
    вырезаются.Текст вводить через форму.">
</head>

<body>
	 <!--- 
	 html form with 1 text area
     entered information don`t deleted when sending a request and it is conviniently to change text
	 --->
    <form class="" action="lab4.php" method="post">

        <?php
        $present_post = isset($_POST['text']);
        ?>
        <textarea class="input-field" name="text" wrap="soft"><?= htmlspecialchars($_POST['text']) ?></textarea>
        <br>
        <button class="button-submit" type="submit" name="btn"> Submit</button>

    </form>

    <p>
        <?php
        if ($present_post) {
            $text = $_POST['text'];
            /*i divided requared pattern(7 or more letters) into 2 parts
            (6 letters and 1 or more) for a more beautiful and elegant replacement
            because in fact replacement in this task will be "first submask(6 letters) + '*'"
            */
            $required_pattern = '/([A-Za-zА-Яа-яёЁ]{6})([A-Za-zА-Яа-яёЁ]{1,})/u';

            $text = preg_replace_callback($required_pattern, function ($matches) {
            /*array [$matches] keeps all pattern occurrences in string
            $matches[1] keep first submask(first 6 letters) of pattern
            */
                return $matches[1] . '*';
            }, $text);
 
            //result output
            echo '<br>Обработанный текст:<br>';
            echo "<a>$text</a>";
        }
        ?>
    </p>
</body>

</html>