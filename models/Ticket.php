<?php
  class Ticket extends Conectar{

    public function insert_ticket($usu_id,$cat_id,$ticket_titulo,$ticket_descrip){
      
        $conectar = parent::conexion();
        parent::set_names();
        $sql="INSERT INTO tm_ticket (ticket_id,usu_id,cat_id,ticket_titulo,ticket_descrip,ticket_estado,fech_crea,usu_asig,fech_asig,estado) VALUES (NULL,?,?,?,?,'abierto',now(),NULL,NULL,'1');";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$usu_id);
        $sql->bindValue(2,$cat_id);
        $sql->bindValue(3,$ticket_titulo);
        $sql->bindValue(4,$ticket_descrip);
        $sql->execute();

        $sql1="select last_insert_id() as 'ticket_id';";
        $sql1=$conectar->prepare($sql1);
        $sql1->execute();
        return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);

    }

    public function listar_ticket_x_usu($usu_id){
      $conectar = parent::conexion();
      parent::set_names();
      $sql="SELECT 
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descrip,
                tm_ticket.ticket_estado,
                tm_ticket.fech_crea,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nombre,
                tm_usuario.usu_apellido,
                tm_categoria.cat_nombre
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.estado = 1
                AND tm_usuario.usu_id=?";
                $sql=$conectar->prepare($sql);
                $sql->bindValue(1,$usu_id);
                $sql->execute();
                return $resultado=$sql->fetchAll();

  }
    //// REVISIÓN 
    public function listar_ticket_x_id($ticket_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descrip,
                tm_ticket.ticket_estado,
                tm_ticket.fech_crea,
                tm_usuario.usu_nombre,
                tm_usuario.usu_apellido,
                tm_usuario.usu_correo,
                tm_categoria.cat_nombre
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.estado = 1
                AND tm_ticket.ticket_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

  public function listar_ticket(){
    $conectar = parent::conexion();
    parent::set_names();
    $sql="SELECT 
              tm_ticket.ticket_id,
              tm_ticket.usu_id,
              tm_ticket.cat_id,
              tm_ticket.ticket_titulo,
              tm_ticket.ticket_descrip,
              tm_ticket.ticket_estado,
              tm_ticket.fech_crea,
              tm_ticket.usu_asig,
              tm_ticket.fech_asig,
              tm_usuario.usu_nombre,
              tm_usuario.usu_apellido,
              tm_categoria.cat_nombre
              FROM 
              tm_ticket
              INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
              INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
              WHERE
              tm_ticket.estado = 1
              ";
              $sql=$conectar->prepare($sql);
              $sql->execute();
              return $resultado=$sql->fetchAll();

}



public function listar_ticketdetalle_x_ticket($ticket_id){
  $conectar = parent::conexion();
  parent::set_names();
  $sql="SELECT
    td_ticketdetalle.ticketd_id,
    td_ticketdetalle.ticketd_descrip,
    td_ticketdetalle.fech_crea,
    tm_usuario.usu_nombre,
    tm_usuario.usu_apellido,
    tm_usuario.rol_id
    FROM
    td_ticketdetalle
    INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
    WHERE
    ticket_id =?";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$ticket_id);
    $sql->execute();
    return $resultado=$sql->fetchAll();

}

public function insert_ticketdetalle($ticket_id,$usu_id,$ticketd_descrip){
      
  $conectar = parent::conexion();
  parent::set_names();
  $sql="INSERT INTO td_ticketdetalle(ticketd_id,ticket_id,usu_id,ticketd_descrip,fech_crea, `estado`) VALUES (NULL,? ,?,?,now(), '1');";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$ticket_id);
  $sql->bindValue(2,$usu_id);
  $sql->bindValue(3,$ticketd_descrip);
  $sql->execute();
  return $resultado=$sql->fetchAll();

}

public function insert_ticketdetalle_cerrar($ticket_id,$usu_id){
      
  $conectar = parent::conexion();
  parent::set_names();
  $sql="call sp_i_ticketdetalle_01(?,?)";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$ticket_id);
  $sql->bindValue(2,$usu_id);
  $sql->execute();
  return $resultado=$sql->fetchAll();

}

public function update_ticket($ticket_id){
  $conectar = parent::conexion();
  parent::set_names();
  $sql="update tm_ticket set 
  ticket_estado = 'cerrado' 
  where ticket_id  =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

}


public function update_ticket_asignacion($ticket_id,$usu_asig){
  $conectar = parent::conexion();
  parent::set_names();
  $sql="update tm_ticket 
  set 
     usu_asig = ?, 
     fech_asig = now() 

  where ticket_id  = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_asig);
            $sql->bindValue(2,$ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

}



public function get_ticket_total(){
  $conectar = parent::conexion();
  parent::set_names();
  $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket ";
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado=$sql->fetchAll();    
}

public function get_ticket_totalabierto(){
  $conectar = parent::conexion();
  parent::set_names();
  $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE  ticket_estado='abierto' ";
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado=$sql->fetchAll();    
}

public function get_ticket_totalcerrado(){
  $conectar = parent::conexion();
  parent::set_names();
  $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE ticket_estado='cerrado' ";
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado=$sql->fetchAll();    
}

public function get_ticket_grafico(){
  $conectar= parent::conexion();
  parent::set_names();
  $sql="SELECT tm_categoria.cat_nombre as nom,COUNT(*) AS total
      FROM   tm_ticket  JOIN  
          tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
      WHERE    
      tm_ticket.estado = 1
      GROUP BY 
      tm_categoria.cat_nombre 
      ORDER BY total DESC";
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado=$sql->fetchAll();
}
  }     
 
?>