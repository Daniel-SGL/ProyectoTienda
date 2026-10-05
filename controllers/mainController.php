<?php

require_once("db.php");
$conn = db::connect();
require_once("models/User.php");

session_start();

if (isset($_GET['login'])) {
    require_once "views/login.phtml";
    exit();
}

if (isset($_GET['register'])) {
    require_once "views/register.phtml";
    exit();
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $q = "SELECT * FROM Usuario WHERE correo='{$_POST['correo']}'";
    $result = $conn->query($q);
    if (isset($_POST['correo']) && isset($_POST['password'])) {
        if ($row = $result->fetch_assoc()) {
            if ($row['password'] == md5($_POST['password'])) {
                $_SESSION['user'] = new User($row['id'], $row['nombre'], $row['correo'], $row['direccion']);
            } else {
                $info = "Contraseña incorrecta";
            }
        } else {
            $info = "El usuario no existe";
        }
    }
}

if (isset($_POST['register'])) {
    if (isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['password']) && isset($_POST['direccion'])) {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $password = md5($_POST['password']);
        $direccion = $_POST['direccion'];

        $qRegister = "INSERT INTO Usuario (nombre, correo, password, direccion) 
                      VALUES ('$nombre', '$correo', '$password', '$direccion')";

        if ($conn->query($qRegister) === TRUE) {
            $info = "Usuario registrado correctamente";
        } else {
            $info = "Error al registrar el usuario: " . $conn->error;
        }
    }
}

require_once "views/mainView.phtml";
