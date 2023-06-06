<?php

class Pagina
{
    private $tipoPagina = 'externa';
    private $tituloPagina;
    private $mensaje;
    private $tipoMensaje;
    private $mensajeNoHayDatos;

    public function setMensaje($mensaje, $tipoMensaje = 'error')
    {
        $this->mensaje = (strcmp(trim($mensaje), trim($this->mensaje)) !== 0) ? $this->mensaje . ' ' . $mensaje : $this->mensaje;
        $this->tipoMensaje = $tipoMensaje;
    }

    // Es recomendable personalizar el nombre de la sesión para evitar problemas
    public function setMensajeNoHayDatos($mensajeNoHayDatos)
    {
        $this->mensajeNoHayDatos = $mensajeNoHayDatos;
    }

    public function getMensajeNoHayDatos()
    {
        return $this->mensajeNoHayDatos;
    }

    public function __construct($tituloPagina, $tipoPagina = 'externa')
    {
        $this->tipoPagina = $tipoPagina;
        $this->tituloPagina = $tituloPagina;
        if ($this->tipoPagina == 'externa') {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_name('Inicio');
                session_start();
            }
        }
    }

    public function inicializaEncabezado($ruta, $datosEncabezado = null)
    {
        include_once $ruta;
        if ($this->tipoPagina == 'externa') {
            (new EncabezadoExterno())->template($this->tituloPagina, $datosEncabezado);
        } else {
            (new EncabezadoInterno())->template($this->tituloPagina, $datosEncabezado);
        }
    }

    public function inicializaPie($ruta)
    {
        include_once $ruta;
        if ($this->tipoPagina == 'externa') {
            (new PieExterno())->template($this->mensaje, $this->tipoMensaje, $this->mensajeNoHayDatos);
        } else {
            (new PieInterno())->template();
        }
    }

    public static function noHayRegistros($datos, $columnas)
    {
        if (count($datos) == 0) {
            ?>
            <tr>
                <td colspan="<?php echo $columnas; ?>" class="text-center h2" id="td-no-hay-datos"></td>
            </tr>
            <?php
            return true;
        } else {
            return false;
        }
    }
}
?>