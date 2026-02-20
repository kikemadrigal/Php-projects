<?php

class Clientes_model extends CI_Model {

    //Este método lo he visto nombrado como getClientes(), find()
    public function select()
    {
        //Manejador de consulta cualquiera
        //$query=$this->db->query("SELECT * FROM clientes"); 
        //Query builder o constructores de consultas (son una manera más segura de hacer consultas)
        //1 forma query builder: $query=$this->db->select('*')->from('clientes')->get();
        //Poniendo antes de la sentencia get (la de debajo de esta líena) $query=$this->db->select('cif', 'nombre'); solo mostrará los campos cif y nombre
        $query=$this->db->get('clientes');
        //Poniendo $query=$this->db->get('clientes',5,2); el 1 parámetro sería la cantidad y el 2 la posición a partir
        //poniendo $this->db->get_compiled_select(); nos devuelve la última consulta quese generó
        /*Tenemos que devolver los clientes con la función de método encadena result()
        *Los posibles métodos que se le pueden aplicar al valor devuelto por un query builder son 
        *num_rows() que delvuelve le número de objetos que contiene
        *result_array(), 
        *result() organiza la query y la transforma en objetos
        *row() transforma en un solo objeto
        *compact("clientes") lo agrupa en una lista de clientes
        */
        if($query->num_rows()>0){
            return $query->result();
		}else{
            return null;
        }
       
    }
    //Este método lo he vist como getCliente, find($id)
    public function selectId($id){ 
        /* Manejador de consulta cualquiera
        * $sql = "SELECT * FROM clientes WHERE id = ?";
        * $query=$this->db->query($sql, $id);
        */
        //Con el constructor de consultass, el segundo parátro es la comparación, el nombre del indice tiene que ser el nombre del campo de la tabla
        $query=$this->db->get_where("clientes",array("id"=>$id));
        //Tambien es posible $query=$this->db->get('clientes')->where('id',$id);
        //Tambien es posible ponerlelos límites, el parámetro 3 es la cantidad y el 4 es a partir
        //$query=$this->db->get_where("clientes",array("id"=>$id),5,2);
        return $query->row();	
    }

    public function selectLike($nombre){
        $query=$this->db->query("SELECT * FROM clientes WHERE nombre LIKE '%$nombre%';");
        return $query->result();
    }
    //Este método lo he visto como setCliente, post
    public function insert($cif, $nombre, $datos){
        //Manejador de consulta cuaquiera
        //$fueInsertado=$this->db->query("INSERT INTO clientes VALUES(NULL,'$cif','$nombre','$datos');");
        //Constructor de consultas
        //El método insert recibe 2 parametros, 1, la tabla y 2 los datos en forma de array
        //Como la variable POST es un array podemos recibirla en lugar del cif,nombre y datos en los parámtros de la declaración del métdos y ponerla como 2 parámetro 
        $fueInsertado=$this->db->insert('clientes', array("cif"=>$cif, "nombre"=>$nombre, "datos"=>$datos));
        return $fueInsertado;
    }
    //Este método lo he visto como modifyClientes, put
    public function update($id, $cif, $nombre, $datos){
        //Manejador de consulta cuaquiera
        //$fueActualizado=$this->db->query("UPDATE clientes SET cif='$cif', nombre='$nombre', datos='$datos' WHERE id=$id;");
        //Constructor de consultas
        $fueActualizado=$this->db->update('clientes', array('id'=>$id,'cif'=>$cif,'nombre'=>$nombre,'datos'=>$datos));
        return $fueActualizado;
    }

    public function delete($id){
        //Manejador de consulta cuaquiera
        //$fueBorrado=$this->db->query("DELETE FROM clientes WHERE id=$id");
        //Constructor de consultas
        $fueBorrado=$this->db->delete('clientes', array('id'=>$id));
        return $fueBorrado;
    }

   
}