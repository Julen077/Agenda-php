<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>
    <?php
    class agenda3{
        private $agenda = array();
        public function __construct($session = null)
        {
            if ($session == null) {
                $this->agenda = array();
                $_SESSION['agenda'] = json_encode($this->agenda);
            } else {
                $this->agenda = $session;
            }
        }
        public function añadirContacto($nombre, $email){
            $keyExit = $this->siExiste($nombre);
            $checkEmail = $this->checkEmail($email);
            if ($keyExit == null && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return '<h4>Añadido correctamente</h4>';
            } else if ($keyExit != null && $checkEmail) {
                $this->agenda[$keyExit] = $email;
                return '<h4>Correo actualizado</h4>';
            }
        }
        public function siExiste($nombre){
            $keys = array_keys($this->agenda);
            foreach ($keys as $key) {
                if (strtolower($key) == strtolower($nombre)) {
                    return $key;
                }
            }
            return null;
        }
        public function checkEmail($email){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        public function eliminarContacto($nombre){
            if ($this->siExiste($nombre)) {
                unset($this->agenda[$nombre]);
                return '<h4>Contacto eliminado</h4>';
            }
            return '<h4>No existe ese contacto</h4>';
        }
        public function setAgenda(){
            $_SESSION['agenda'] = json_encode($this->agenda);
        }
        public function mostrar(){
            $string = '<table border = 10><tr><td style=font-weight:bold;>Nombre</td><td style=font-weight:bold;>Correo</td></tr>';
            foreach ($this->agenda as $key => $value) {
                $string .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            $string .= '</table>';
            echo $string;
        }
    }
    ?>
    <?php
    session_start();
    $resultado = '';
    if (!isset($_SESSION['agenda'])) {
        $obj = new agenda3();
    } else {
        $obj = new agenda3(json_decode($_SESSION['agenda'], true));
        if (empty($_POST['nombre'])) {
            $resultado = '<h4>El nombre esta vacio</h4>';
        } else {
            $name = htmlentities($_POST['nombre']);
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $resultado = $obj->añadirContacto($name, $email);
            } else {
                $resultado = $obj->eliminarContacto($name);;
            }
        }
    }
    $obj->setAgenda();
    ?>
    <?php
    $user = "";
    if (!isset($_SESSION['nombreusuario_sessions'])) {
        $_SESSION['nombreusuario_sessions'] = htmlentities($_POST['nombreusuario_sessions']);
        $user = htmlentities($_POST['nombreusuario_sessions']);
    } else {
        $user = $_SESSION['nombreusuario_sessions'];
    }
    ?>
    <h1>Esta es la agenda de <?php echo $user; ?></h1>
        <form method="POST">
            <label>Nombre:</label><br>
            <input type="text" name="nombre" placeholder=<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>><br>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder=<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>><br>
            <input type="submit" name="submit" />
        </form>
    <?php
    if (isset($_POST['submit'])) {
        echo $resultado;
    }
    $obj->mostrar();

    ?>
</body>

</html>