<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
    <title>Lab_5</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lab5.css">
    <meta name="description" content="Написать скрипт, отображающий структуру 
    и данные всех таблиц указанной БД. (таблиц не менее 4-х, отобразить также 
    первичные и вторичные ключи, и типы полей).">
</head>

<body>

    <?php

    $link;

    function getTables($mysqli, $db_name)
    {
        $res = $mysqli->query("SHOW TABLES from " . $db_name);
        //var_dump($res)
        if ($res == false) {
            echo '<a class="error" style="color: aliceblue">Данная БД не содержит таблиц или таблицы пусты</a>';
            exit();
        }
        while ($row = $res->fetch_row()) {
            $tables[] = $row[0];
        }
        return $tables;
    }

    function getColumns($mysqli, $table)
    {
        $res = $mysqli->query("SHOW COLUMNS FROM " . $table);
        //var_dump($res);
        while ($row = $res->fetch_row()) {
            $columns[] = array("name" => $row[0], "type" => $row[1], "null" => $row[2], "key" => $row[3], "default" => $row[4], "extra" => $row[5]);
        }
        return $columns;
    }
    function getRows($link, $tableName)
    {
        $data = array();
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($link, $query);
        if ($result) {
            $rows = mysqli_num_rows($result);
            for ($i = 0; $i < $rows; ++$i) {
                $data[] = mysqli_fetch_row($result);
            }
            mysqli_free_result($result);
        }
        return $data;
    }
    function getTablesInfo($link, $db_name)
    {
        $tablesNames = getTables($link, $db_name);
        $tablesInfo = array();
        foreach ($tablesNames as $tableName) {
            $tablesInfo[$tableName]["fields"] = getColumns($link, $tableName);
            $tablesInfo[$tableName]["data"] = getRows($link, $tableName);
        }
        return $tablesInfo;
    }
    function init($host, $user, $password, $database)
    {
        $link = mysqli_init();
        $link = mysqli_connect($host, $user, $password, $database);
        if ($link->connect_errno) exit('Ошибка соединения с БД');
        if ($link == null) {
            echo '<br>Ошибка соединения с БД. Проверьте введённые данные<br>';
            exit();
        }
        return $link;
        //$link->mysqli;
    }
    function drawTables($tables)
    {

        echo '<div class="tabs">';
        $i = 1;
        foreach ($tables as $tableName => $val) {

            echo     '<input type="radio" name="inset" value="" id="tab_' . $i . '" checked>';
            echo '<label for="tab_' . $i . '">' . "$tableName" . '</label>';
            echo '<style type="text/css">';
            echo '#tab_' . $i . ':checked ~ #cont_' . $i . '{ display: block; }';
            echo '</style>';
            $i++;
        }
        $i = 1;
        foreach ($tables as $table) {
            echo '<div class="content "id="cont_' . "$i" . '"><p>';
            //таблица
            echo '<table class="tg">';

            $count = count($table["fields"]);

            echo "<tr>";
            for ($j = 0; $j < $count; $j++) {
                echo "<th>" . $table["fields"][$j]["name"];
                /*
                echo '<div hidden>';
                foreach ($table["fields"][$j] as $key => $val) {

                    echo '<br>' . $key . ':' . $val;
                }
                echo '</div>';
                */
                echo "</th>";
            }
            echo "</tr>";
            foreach ($table["data"] as $data) {
                echo "<tr>";
                foreach ($data as $item) {
                    if (!$item) {
                        echo "<td>-</td>";
                    } else
                        echo "<td>$item</td>";
                }
                echo "</tr>";
            }
            echo "</table>"; {

                echo '<table class="tg">';
                echo "<tr>Fields info</tr><tr>";
                $count = count($table["fields"]);
                foreach ($table["fields"][0] as $key => $val) {


                    echo '<th>' . $key . '</th>';
                }
                echo "</tr>";
                for ($j = 0; $j < $count; $j++) {

                    echo "<tr>";
                    foreach ($table["fields"][$j] as $key => $val) {

                        if (!$val) {
                            echo "<td>-</td>";
                        } else
                            echo "<td>$val</td>";
                    }

                    echo "</tr>";
                }

                echo "</table>";
            }

            echo  '</p></div>';
            $i++;
        }

        echo '</div>';
    }


    //if ($present_post) 
    {
        //$addres = $_POST["adress"];
        //$root = $_POST["root"];
        //$password = $_POST["password"];
        //$db_name = "information_schema";
        //$db_name = "empty";
        //$db_name = $_POST["db_name"];
        $addres = "localhost";
        $root = "root";
        $password = "7415151asd";
        $db_name = "labs";

        $link = init($addres, $root, $password, $db_name);
        $tables = getTablesInfo($link, $db_name);
        drawTables($tables);
        //unset($_POST);
    }
    ?>


</body>

</html>