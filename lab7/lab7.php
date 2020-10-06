
<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
    <title>Laba_7</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lab7.css">
    <meta name="description" content="Написать скрипт, 
    отправляющий полученное через форму письмо списку 
    адресатов, хранящемуся в БД.">
</head>

<body>

    <form method="POST" action="lab7.php">
        <p>
            <label for="subject">Тема: </label>
            <input type="text" id="subject" name="subject" />
        </p>
        <p>
            <label for="message">Сообщение: </label><br>
            <textarea class="input-field" id="message" name="message" wrap="soft"></textarea>
            <br>
        </p>
        <?php
            $present_post = isset($_POST['message']) && isset($_POST['subject'])&& isset($_POST['subject']);
        ?>
        <p>
            <button type="submit">Send</button>
        </p>
    </form>


    <?php
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;




    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '7415151asd');
    define('DB_NAME', 'receivers');

    error_reporting(0);
    function connectToDB($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME)
    {
        $mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
        if ($mysqli->connect_ernno)
            exit('Ошибка соединения с БД');
        return $mysqli;
    }
    function getReceiversfromDB($mysqli)
    {
        $query = "SELECT `email` FROM `emails` ORDER BY `id`";
        $result = $mysqli->query($query);

        if ($result === false) {
            exit('Ошибка соединения с БД');
        }
        $receivers = [];
        while ($arr = $result->fetch_assoc()) {
            $receivers[] = $arr['email'];
        }
        return $receivers;
    }
    function checkPost()
    {
        if (strlen($_POST['message']) == 0) {
            echo "Пустое сообщение";
            return false;
        }
        return true;
    }

    if ($present_post) {
        if (checkPost()) {
            $link = connectToDB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $receivers =  getReceiversfromDB($link);
            $link->close();
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = 'true';
            $mail->SMTPSecure = 'tls';
            $mail->Port = '587';
            $mail->CharSet = "utf-8";
            $mail->Username = 'countrouge0@gmail.com';
            $mail->Password = 'countrouge7415151';
            $mail->Subject = $_POST['subject'];
            $mail->setFrom('countrouge0@gmail.com');
            $mail->addReplyTo('countrouge0@gmail.com');
            $mail->Body = $_POST['message'];

            foreach ($receivers as $key => $value) {
                $mail->addAddress($value);
            }
            echo '<br>';
            if ($mail->Send()) {
                echo "Сообщения успешно отправлены";
            } else {
                echo "Произошла ошибка при отправлении сообщений";
            }
            echo '<br>';
            $mail->smtpClose();;
            $present_post = null;
            $mail = null;
        }
    }
    $_POST = array();
    
    ?>
</body>
</html>