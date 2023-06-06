<?php
require_once "Conexiones/ConexionBD.php";

class DatosPersonalesModelo
{
    private $conexion;
    private $status;
    private $mensaje;
    private $lugarDeError;
    private $datos;

    public function __construct()
    {
        try {
            $this->conexion = Conexion::IniciarConexion();
            $this->status = TRUE;
        } catch (Exception $e) {
            $this->status = FALSE;
            $this->mensaje = 'Error al conectarse a la BD: ' . $this->lugarDeError . 'codigo';
        }
        $this->lugarDeError = '';
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setLugarDeError($lugarDeError)
    {
        $this->lugarDeError = $lugarDeError;
    }

    public function getLugarDeError()
    {
        return $this->lugarDeError;
    }

    public function obtenerDatos()
    {
        $this->datos = (object) array('alumnos' => NULL);
        try {
            $sql = "SELECT * FROM alumnos";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            $errores = $consulta->errorInfo();
            if ($errores[0] == 0000) {
                $this->status = TRUE;
                $this->datos = $consulta->fetchAll(PDO::FETCH_OBJ);
            } else {
                throw new Exception($errores[2]);
            }
        } catch (PDOException $e) {
            $this->status = FALSE;
            $this->mensaje = 'Error al obtener la informacion: ' . $this->lugarDeError . 'codigo' . $e->getCode() . 'Modelo linea' . $e->getLine();
        } catch (Exception $e) {
            $this->status = FALSE;
            $this->mensaje = $e->getMessage();
        }
        return $this->datos;
    }

    public function insertarDatos($id, $nombre, $email)
    {
        try {
            $sql = "INSERT INTO alumnos (id, nombre, email) 
            VALUES (:id, :nombre, :email)";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':email', $email);
            $consulta->execute();
            $errores = $consulta->errorInfo();
            if ($errores[0] == "00000") {
                $this->status = TRUE;
                $this->mensaje = "Datos insertados correctamente.";
            } else {
                throw new Exception($errores[2]);
            }
        } catch (PDOException $e) {
            $this->status = FALSE;
            $this->mensaje = 'Error al insertar los datos: ' . $e->getMessage() . ' en el modelo línea ' . $e->getLine();
        } catch (Exception $e) {
            $this->status = FALSE;
            $this->mensaje = $e->getMessage();
        }
    }

    public function actualizarDatos($id, $nombre, $email)
    {
        try {
            $sql = "UPDATE alumnos SET nombre = :nombre, email = :email WHERE id = :id";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $errores = $consulta->errorInfo();
            if ($errores[0] == "00000") {
                $this->status = TRUE;
                $this->mensaje = "Datos actualizados correctamente.";
            } else {
                throw new Exception($errores[2]);
            }
        } catch (PDOException $e) {
            $this->status = FALSE;
            $this->mensaje = 'Error al actualizar los datos: ' . $e->getMessage() . ' en el modelo línea ' . $e->getLine();
        } catch (Exception $e) {
            $this->status = FALSE;
            $this->mensaje = $e->getMessage();
        }
    }


    public function eliminarDatos($id)
    {
        try {
            $sql = "DELETE FROM alumnos WHERE id = :id";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $errores = $consulta->errorInfo();
            if ($errores[0] == "00000") {
                $this->status = TRUE;
                $this->mensaje = "Registro eliminado correctamente.";
            } else {
                throw new Exception($errores[2]);
            }
        } catch (PDOException $e) {
            $this->status = FALSE;
            $this->mensaje = 'Error al eliminar el registro: ' . $e->getMessage() . ' en el modelo línea ' . $e->getLine();
        } catch (Exception $e) {
            $this->status = FALSE;
            $this->mensaje = $e->getMessage();
        }
    }

}
?>