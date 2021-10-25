<!DOCTYPE html>
<html>
<body>
    <?php
    class agenda2
    {
        private $agenda = array();

        public function __construct($cookie = null)
        {
            if ($cookie == null) {
                $this->agenda = array();
                setcookie('agenda', json_encode($this->agenda), 0);
            } else {
                $this->agenda = $cookie;
            }
        }
        public function añadirContacto($nombre, $email)
        {
            $keyExit = $this->siExiste($nombre);
            $checkEmail = $this->checkEmail($email);
            if (!$keyExit && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return '<h4>Añadido correctamente</h4>';
            } else if ($keyExit && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return '<h4>Se a actualizado el correo</h4>';
            } 
        }
        private function siExiste($nombre)
        {
            $keys = array_keys($this->agenda);
            foreach ($keys as $key) {
                if (strtolower($key) == strtolower($nombre)) {
                    return true;
                }
            }
            return false;
        }
        private function checkEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        public function eliminarContacto($name)
        {
            if ($this->siExiste($name)) {
                unset($this->agenda[$name]);
                return '<h4>Contacto eliminado</h4>';
            }
            return '<h4>No existe ese contacto</h4>';
        }
        public function setAgenda()
        {
            setcookie('agenda',json_encode($this->agenda),0);
        }
        public function seeArray()
        {
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
    $resultado = '';
    if(!isset($_COOKIE['agenda'])){
        $obj = new agenda2();
    }else{
        $obj = new agenda2(json_decode($_COOKIE['agenda'], true));
        if (empty($_POST['nombre'])) {
            $resultado = '<h4>El nombre esta vacio</h4>';
        } else {
            $name = htmlentities($_POST['nombre']);
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $resultado = $obj->añadirContacto($name, $email);
                $resultado =  '<h4>' . $resultado . '</h4>';
            } else {
                $resultado = $obj->eliminarContacto($name);;
            }
        }
    }
    $obj->setAgenda();
    ?>
    <?php
    $user = "";
    if (!isset($_COOKIE['nombreusuario_cookies'])) {
        setcookie('nombreusuario_cookies', htmlentities($_POST['nombreusuario_cookies']));
        $user = htmlentities($_POST['nombreusuario_cookies']);
    } else {
        $user = $_COOKIE['nombreusuario_cookies'];
    }
    ?>
    <h1>Esta es la agenda de <?php echo $user; ?></h1>
    <form method="POST">
        <label>Nombre:</label> <br>
        <input type="text" name="nombre" /><br>
        <label>Email</label> <br>
        <input type="email" name="email" /> 
        <input type="submit" name="submit" />
    </form>
    <?php
    if(isset($_POST['submit'])){
        echo $resultado;
    }
    $obj->seeArray();
    ?>
</body>
</html>