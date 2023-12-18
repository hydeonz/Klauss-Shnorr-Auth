<?php
namespace app;
require_once '../vendor/autoload.php';
class User implements IUser
{
    public IAuth $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function setE(): int
    {
        return random_int(0, pow(2,51)-1);
    }

    public function result(int $s, $e)
    {
        $result = bcpowmod($this->auth->g, $s, $this->auth->p);
        $result *= bcpowmod($this->auth->y, $e, $this->auth->p);
        $result = bcmod($result, $this->auth->p);
        echo "{$this->auth->r} = {$result}" . "<br>";
    }
}

session_start();

if (isset($_POST['pnq'])) {
    unset($_SESSION['user']);
}

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = new User();
}

$u = $_SESSION['user'];

if (isset($_POST['privateKey'])) {
    $u->auth->setX();
    $_SESSION['privateKey'] = $u->auth->x;
    unset($_SESSION['publicKey'], $_SESSION['s'], $_SESSION['e']);
}

if (isset($_POST['publicKey'])) {
    $u->auth->setY();
    $_SESSION['publicKey'] = $u->auth->y;
    unset($_SESSION['s'], $_SESSION['e']);
}

if (isset($_POST['auth'])) {
    $u->auth->setK();
    $u->auth->setR();
    $_SESSION['e'] = $u->setE();
    $_SESSION['s'] = $u->auth->setS($_SESSION['e']);
}
echo "<div class='output'>";
if (isset($_POST['pnq']) && !isset($p,$q)) {
    echo "p = " . $u->auth->p . "<br>";
    echo "q = " .$u->auth->q . "<br>";
    $_SESSION['privateKey'] = null;
    $_SESSION['publicKey'] = null;
    $_SESSION['s'] = null;
    $_SESSION['e'] = null;
}

if (isset($_POST['privateKey'])) {
    echo "p = " . $u->auth->p . "<br>";
    echo "q = " . $u->auth->q . "<br>";
    echo "Приватный ключ = " . $_SESSION['privateKey'] . "<br>";
}

if (isset($_POST['publicKey'])) {
    echo "p = " .$u->auth->p . "<br>";
    echo "q = " .$u->auth->q . "<br>";
    echo "Приватный ключ = " .$_SESSION['privateKey'] . "<br>";
    echo "Публичный ключ = " .$_SESSION['publicKey'] . "<br>";
}

if (isset($_POST['auth'])) {
    echo "p = " .$u->auth->p . "<br>";
    echo "q = " .$u->auth->q . "<br>";
    echo "Приватный ключ = " .$_SESSION['privateKey'] . "<br>";
    echo "Публичный ключ = " .$_SESSION['publicKey'] . "<br>";
    echo "s = " . $_SESSION['s'] . "<br>";
    echo "e = " . $_SESSION['e'] . "<br>";
    $u->result($_SESSION['s'], $_SESSION['e']);
}
echo "</div>";
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="submit"] {
            padding: 10px 20px;
            margin-bottom: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .output {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-style: oblique;
            border: 2px solid #4CAF50;
            padding: 20px;
            border-radius: 10px;
            background-color: #f2f2f2;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
    </style>
</head>
<form action="User.php" method="post">
    <input type="submit" value="Генерация простых чисел" name="pnq">
</form>
<form action="User.php" method="post">
    <input type="submit" value="Генерация закрытого ключа" name="privateKey">
</form>
<form action="User.php" method="post">
    <input type="submit" value="Генерация открытого ключа" name="publicKey">
</form>
<form action="User.php" method="post">
    <input type="submit" value="Аутентификация" name="auth">
</form>
</html>