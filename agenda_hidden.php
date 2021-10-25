<!DOCTYPE html>
<html>
<body>
    <?php
    class agenda1{
        private $agenda;
        public function __construct($array = null){
            if ($array == null) {
                $this->agenda = array();
            } else {
                $this->agenda = json_decode($_POST['array'], true);
            }
        }
        public function añadirContacto($nombre, $email){
            $existe = $this->siExiste($nombre);
            $checkEmail = $this->checkEmail($email);
            if (!$existe && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return 'Añadido correctamente';

            } else if ($existe && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return 'Se ha actualizado el correo';

            }
        }
        private function siExiste($nombre){
            $keys = array_keys($this->agenda);
            foreach ($keys as $key) {
                if (strtolower($key) == strtolower($nombre)) {
                    return true;
                }
            }
            return false;
        }
        private function checkEmail($email){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        public function eliminaContacto($nombre){
            if ($this->siExiste($nombre)) {
                unset($this->agenda[$nombre]);
            }
        }
        public function setAgenda(){
            $agenda = json_encode($this->agenda);
            return $agenda;
        }
        public function mostrar(){
            $tabla = '<table border = 10><tr><td style=font-weight:bold;>Nombre</td><td style=font-weight:bold;>Correo</td></tr>';
            foreach ($this->agenda as $key => $value) {
                $tabla .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            $tabla .= '</table>';
            echo $tabla;
        }
    }
    ?>

    <?php
    $resultado = '';
    if (!isset($_POST['array'])) {
        $obj = new agenda1();
    } else {
        $obj = new agenda1($_POST['array']);
        if (empty($_POST['nombre'])) {
            $resultado = '<h4>El nombre esta vacio</h4>';
        } else {
            $name = htmlentities($_POST['nombre']);
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $resultado = $obj->añadirContacto($name, $email);
                $resultado =  '<h4>' . $resultado . '</h4>';
            } else {
                $obj->eliminaContacto($name);
                $resultado = '<h4>Contacto eliminado</h4>';
            }
        }
    }
    ?>
    <?php
        $user = "";
        if(isset($_POST['nombreusuario_hidden'])){
            $user = htmlentities($_POST['nombreusuario_hidden']);
        }else{
            $user = $_POST['user'];
        }
    ?>
    <h1>Esta es la agenda de <?php echo $user ;?></h1>
    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value=<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?> ><br>
        <label>Email:</label><br>
        <input type="email" name="email" value=<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?> ><br>
        <input type="submit" />
        <input type="hidden" name="array" value=<?php echo $obj->setAgenda(); ?> />
        <input type="hidden" name="user" value=<?php echo $user ;?> />
    </form>
    <?php
    echo $resultado;
    $obj->mostrar();
    ?>
</body>

</html>