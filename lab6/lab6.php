<?php
    if (isset($_POST['back'])) {
        setcookie('back', $_POST['back'], time() + 60*5);
    }
    if (isset($_POST['color-main'])) {    
        setcookie('color-main', $_POST['color-main'], time() + 60*5);
    }
    if (isset($_POST['size-main'])) {
        setcookie('size-main', $_POST['size-main'], time() + 60*5);
    }
    if (isset($_POST['color-head'])) {
        setcookie('color-head', $_POST['color-head'], time() + 60*5);
    }
    if (isset($_POST['size-head'])) {
        setcookie('size-head', $_POST['size-head'], time() + 60*5);
    }
    $back = $_POST['back'] ?? $_COOKIE['back'] ?? 'white';
    $color_main = $_POST['color-main'] ?? $_COOKIE['color-main'] ?? 'black';
    $size_main = $_POST['size-main'] ?? $_COOKIE['size-main'] ?? '12';
    $color_head = $_POST['color-head'] ?? $_COOKIE['color-head'] ?? 'black';
    $size_head = $_POST['size-head'] ?? $_COOKIE['size-head'] ?? '22';
    const BACK_VALUES = array('red' => 'Красный', 'yellow' => 'Желтый', 'green' => 'Зеленый', 
        'white' => 'Белый');
    const COLOR_MAIN_VALUES = array('red' => 'Красный', 'yellow' => 'Желтый', 'green' => 'Зеленый', 
        'black' => 'Черный');
    function generate_select($name, $selected, $values) {
        $result = "<select name=\"$name\">";
        foreach ($values as $key => $value) {
            $result .= "<option".(($key==$selected)?" selected ":" ")."value=\"$key\">$value</option>";
        }
        return $result . "</select>";
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lab6.css">
    <meta name="description" content="Выведите форму со списками выбора 
    цвета фона страницы, размера и цвета основного шрифта и заголовка. 
    При отправке соответствующих значений они должны сохраниться в COOKIE 
    пользователя. Сразу после отправки формы, а также и без отправки 
    (например, при перезагрузке страницы или повторном вызове скрипта через 
    некоторое время, не превышающее время жизни куки), если уже есть  
    соответствующая COOKIE, должны быть установлены заданные параметры 
    стилей страницы.">
    <title>Laba6</title>
    <style>
        body {
            background-color: <?php echo $back ?>
        }
        .content p {
            font-size: <?php echo $size_main ?>pt;
            color: <?php echo $color_main ?>
        }
        .content h1 {
            font-size: <?php echo $size_head ?>pt;
            color: <?php echo $color_head ?>;
        }
        .content h2 {
            font-size: <?php echo $size_head ?>pt;
            color: <?php echo $color_head ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Summa Theologiae</h1>
            <h2>ARTICULUS 1</h2>
            <p>
           
[28233] Iª q. 1 a. 1 arg. 1
<br>
Ad primum sic proceditur. Videtur quod non sit necessarium, praeter philosophicas disciplinas, aliam doctrinam haberi. Ad ea enim quae supra rationem sunt, homo non debet conari, secundum illud Eccli. III, altiora te ne quaesieris. Sed ea quae rationi subduntur, sufficienter traduntur in philosophicis disciplinis. Superfluum igitur videtur, praeter philosophicas disciplinas, aliam doctrinam haberi.
<br>
[28234] Iª q. 1 a. 1 arg. 2
<br>
Praeterea, doctrina non potest esse nisi de ente, nihil enim scitur nisi verum, quod cum ente convertitur. Sed de omnibus entibus tractatur in philosophicis disciplinis, et etiam de Deo, unde quaedam pars philosophiae dicitur theologia, sive scientia divina, ut patet per philosophum in VI Metaphys. Non fuit igitur necessarium, praeter philosophicas disciplinas, aliam doctrinam haberi.
<br>
[28235] Iª q. 1 a. 1 s. c.
<br>
Sed contra est quod dicitur II ad Tim. III, omnis Scriptura divinitus inspirata utilis est ad docendum, ad arguendum, ad corripiendum, ad erudiendum ad iustitiam. Scriptura autem divinitus inspirata non pertinet ad philosophicas disciplinas, quae sunt secundum rationem humanam inventae. Utile igitur est, praeter philosophicas disciplinas, esse aliam scientiam divinitus inspiratam.
<br>
[28236] Iª q. 1 a. 1 co.
<br>
Respondeo dicendum quod necessarium fuit ad humanam salutem, esse doctrinam quandam secundum revelationem divinam, praeter philosophicas disciplinas, quae ratione humana investigantur. Primo quidem, quia homo ordinatur ad Deum sicut ad quendam finem qui comprehensionem rationis excedit, secundum illud Isaiae LXIV, oculus non vidit Deus absque te, quae praeparasti diligentibus te. Finem autem oportet esse praecognitum hominibus, qui suas intentiones et actiones debent ordinare in finem. Unde necessarium fuit homini ad salutem, quod ei nota fierent quaedam per revelationem divinam, quae rationem humanam excedunt. Ad ea etiam quae de Deo ratione humana investigari possunt, necessarium fuit hominem instrui revelatione divina. Quia veritas de Deo, per rationem investigata, a paucis, et per longum tempus, et cum admixtione multorum errorum, homini proveniret, a cuius tamen veritatis cognitione dependet tota hominis salus, quae in Deo est. Ut igitur salus hominibus et convenientius et certius proveniat, necessarium fuit quod de divinis per divinam revelationem instruantur. Necessarium igitur fuit, praeter philosophicas disciplinas, quae per rationem investigantur, sacram doctrinam per revelationem haberi.
            </p>
        </div>
        <div class="settings">
            <form method="post">
                <p>Цвет фона:<?php echo generate_select("back", $back, BACK_VALUES) ?></p>
                <p>Размер шрифта основного текста:
                    <input type="text" pattern="[1-9]{1}[0-9]{0,1}" value="<?php echo $size_main ?>" 
                        name="size-main"/>
                </p>
                <p>Цвет шрифта основного текста:
                    <?php echo generate_select("color-main", $color_main, COLOR_MAIN_VALUES) ?>
                </p>
                <p>Размер шрифта заголовка:
                    <input type="text" pattern="[1-9]{1}[0-9]{1}" value="<?php echo $size_head ?>" 
                        name="size-head"/>
                </p>
                <p>Цвет шрифта заголовка:
                    <?php echo generate_select("color-head", $color_head, COLOR_MAIN_VALUES) ?>
                </p>
                <p><input type="submit"></p>
            </form>
            <?php //echo "<p>$status</p>" ?>
        </div>
    </div>
</body>
</hmtl>