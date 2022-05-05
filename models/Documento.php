<?php

class Documento extends Conectar{
    public function insert_documento($ticket_id,$doc_nombre){
        $conectar = parent::conexion();
        $sql="INSERT INTO td_documento (doc_id,ticket_id,doc_nombre,fech_crea,estado) VALUES (NULL,?,?,now(),1);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(1,$ticket_id);
        $sql->bindParam(2,$doc_nombre);
        $sql->execute();
    }

    public function get_documento_x_ticket($ticket_id){
        $conectar = parent::conexion();
        $sql="SELECT * FROM td_documento WHERE ticket_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(1,$ticket_id);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        
    }
}

?>