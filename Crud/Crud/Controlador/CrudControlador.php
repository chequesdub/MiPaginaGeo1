<?php
include_once "Crud/Crud/Vista/VistaFormulario.php";
include_once "Crud/Crud/Modelo/DatosPersonalesModelo.php";
include_once "clases/pagina.php";

class CrudControlador
{
    private $modelo;
    private $pagina;
    private $datos;

    public function __construct()
    {
        $this->modelo = new DatosPersonalesModelo();
        $this->pagina = new pagina("Mi pagina");
    }

    public function index()
    {
        $this->pagina->inicializaEncabezado("clases/html/encabezadoExterno.php");
        $vista = new Formulario();
        $vista->template();

        // Obtener el tipo de formulario
        if (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
            // Ejecutar la acción correspondiente según el tipo de formulario
            switch ($tipo) {
                case 'crear':
                    $this->Insertar();
                    break;
                case 'actualizar':
                    $this->Actualizar();
                    break;
                case 'eliminar':
                    $this->Eliminar();
                    break;
                default:
                    $this->index();
                    break;
            }
        }
    }
    public function Insertar()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        print_r ($_POST);
        $this->modelo->insertarDatos($id, $nombre, $email);
        echo "EL alumno " . $nombre . " fue agregado correctamente";
    }

    public function Actualizar()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        print_r ($_POST);
        $this->modelo->actualizarDatos($id, $nombre, $email);
        echo "EL alumno " . $nombre . " fue actualizado correctamente";
    }

    public function Eliminar()
    {
        $id = $_POST['id'];
        print_r ($_POST);
        $this->modelo->eliminarDatos($id);
        echo "EL alumno " . $id . " fue eliminado correctamente";
    }
}
?>