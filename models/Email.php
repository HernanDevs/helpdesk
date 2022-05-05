<?php
/* librerias necesarias para que el proyecto pueda enviar emails */
require('class.phpmailer.php');
include("class.smtp.php");

/* llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../models/Ticket.php");

class Email extends PHPMailer{
  protected $gcorreo='jsonh@outlook.es'; //variable que contiene el correo del destinario
  protected $gcontrasena ='Sarita2015%#'; //variable que contiene la contraseña del destinario

  public function ticket_abierto($ticket_id){
    $ticket = new Ticket();
    $datos = $ticket->listar_ticket_x_id($ticket_id);
    foreach ($datos as $row){
      $id = $row["ticket_id"];  
      $usu = $row["usu_nombre"];
      $titulo = $row["ticket_titulo"];
      $categoria = $row["cat_nombre"];
      $gcorreo = $row["usu_correo"];

    }
    

    //igual
    $this->IsSMTP();
    $this->Host = 'smtp.office365.com';//Aqui el server
    $this->Port = 587;//Aqui el puerto
    $this->SMTPAuth = true;
    $this->Username = $this->gCorreo;
    $this->Password = $this->gContrasena;
    $this->From = $this->gCorreo;
    $this->SMTPSecure = 'tls';
    $this->FromName = $this->tu_nombre = "Ticket Abierto ".$id;
    $this->CharSet = 'UTF8';
    $this->addAddress($correo);
    $this->WordWrap = 50;
    $this->IsHTML(true);
    $this->Subject = "Ticket Abierto";

     //Igual//
     $cuerpo = file_get_contents('../public/NuevoTicket.html'); /* Ruta del template en formato HTML */
      /* parametros del template a remplazar */
      $cuerpo = str_replace("xnroticket", $id, $cuerpo);
      $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
      $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
      $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

      $this->Body = $cuerpo;
      $this->AltBody = strip_tags("Ticket Abierto");
      return $this->Send();
  }

  public function ticket_cerrado($ticket_id){
    
  }

  public function ticket_asignado($ticket_id){
    
  }
}



?>  