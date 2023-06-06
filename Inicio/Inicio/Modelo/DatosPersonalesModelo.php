<?php
require_once "Conexiones/ConexionBD.php";
class DatosPersonalesModelo{
    private $conexion,
            $status,
            $mensaje,  
            $lugarDeError,
            $datos,

            $clave,  
            $obtenerpor,
            $id,
            $nombre,
            $email;
    
    public function __CONSTRUCT()
    {
        try{
            $this->conexion = Conexion::IniciarConexion();
            $this->status = TRUE;
        }catch (Exception $e){
            $this->status = FALSE;
            $this->mensaje = 'Error al conectarse a la BD: '. $this->lugarDeError. 'codigo';
        }
        $this->lugarDeError='';
    }
    public function setStatus($status){$this->clave = $status;}
    public function getStatus(){return $this->status;}

    public function setMensaje($mensaje){$this->clave = $mensaje;}
    public function getMensaje(){return $this->mensaje;}

    public function setLugarDeError($lugarDeError){$this->clave = $lugarDeError;}
    public function getLugarDeError(){return $this->lugarDeError;}


    public function setId ($id){$this->id = $id;}
    public function getId(){return $this->id;} 

    public function setNombre ($nombre){$this->nombre = $nombre;}
    public function getNombre(){return $this->nombre;}

    public function setEmail ($email){$this->email= $email;}
    public function getEmail(){return $this->email;}

    
    public function obtenerDatos()
    {
        $this-> datos = (object) array('alumnos' => NULL);
        try{
            $sql = "SELECT * FROM alumnos";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            $errores = $consulta->errorInfo();
            if ($errores[0]== 0000)
            {
                $this->status = TRUE;
                $this->datos = $consulta->fetchAll(PDO::FETCH_OBJ);
            }else{
                throw new Exception($errores[2]);
            }
        }
        catch (PDOException $e){
            $this->status = FALSE;
            $this->mensaje= 'Error al obtener la informacion: '. $this->lugarDeError. 'codigo'. $e->getCode() . 'Modelo linea'. $e->getLine();
        }
        catch (Exception $e)
        {
            $this->status=FALSE;
            $this->mensaje=$e->getMessage();
        }
        return $this->datos;
    }
} 