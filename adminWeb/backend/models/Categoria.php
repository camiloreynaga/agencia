<?php

class Categoria
{
    private $id;
    private $nombre;
    private $tipo;
    private $foto;
    private $idioma_id;
    private $estado;

    private $idioma_nombre;



    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        return $this->$name=$value;
        
    }
    
    private $pdo;
    
    /**
     * lista los valores de las columnas solicitadas
     * @param type $table 
     * @param type $rows
     * @return \Sede
     */
    public function Listar()
    {
        $this->pdo = new Conexion();
        try
        {
            $result = array();
            
            $stm = $this->pdo->prepare('SELECT c.id,c.nombre, c.tipo,c.foto, c.idioma_id,c.estado,i.nombre AS idioma_nombre FROM categoria c INNER JOIN idioma i ON i.id=c.idioma_id');
            $stm->execute();
            
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $alm = new Categoria();
                $alm->__SET('id',$r->id);
                $alm->__SET('nombre',$r->nombre);
                $alm->__SET('tipo',$r->tipo);
                $alm->__SET('foto',$r->foto);
                $alm->__SET('idioma_id',$r->idioma_id);
                $alm->__SET('estado',$r->estado);
                $alm->__SET('idioma_nombre',$r->idioma_nombre);
                $result[] = $alm;
            }
            return $result;
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());

        }
    }

// muestra 3 categorias aleatorios en el index
    public function ListaCategoria($id)
    {
        $this->pdo = new Conexion();
        try
        {
            $result = array();
            
            $stm = $this->pdo->prepare('SELECT c.id,c.nombre, c.tipo, c.idioma_id,c.estado, c.foto FROM categoria c WHERE c.estado=1 AND c.idioma_id='.$id.' ORDER BY RAND() LIMIT 3');
            $stm->execute();
            
            foreach($stm->fetchAll(PDO::FETCH_ASSOC) as $r)
            {
                array_push($result, $r);
            }
            return $result;
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());

        }
    }


    public function ListarCategoria($id)
    {
        $this->pdo = new Conexion();
        try
        {
            $result = array();
            
            $stm = $this->pdo->prepare('SELECT c.id,c.nombre, c.tipo, c.idioma_id,c.estado, c.foto FROM categoria c WHERE c.estado=1 AND c.idioma_id='.$id);
            $stm->execute();
            
            foreach($stm->fetchAll(PDO::FETCH_ASSOC) as $r)
            {
                array_push($result, $r);
            }
            return $result;
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());

        }
    }
    
    /**
     * lista la el id y nombre para cargar en un combo
     * retorna: id, nombre
     * estado = 1 (activo)
     */
    public function ListarCombo()
    {
        $this->pdo = new Conexion();
        try
        {
            $result = array();
            
            $stm = $this->pdo->prepare('SELECT c.id, c.nombre AS nombre, i.nombre AS idioma_nombre FROM categoria c INNER JOIN idioma i ON i.id=c.idioma_id WHERE c.estado=1');
            $stm->execute();
            
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $alm = new Categoria();
                $alm->__SET('id',$r->id);
                $alm->__SET('nombre',$r->nombre);
                $alm->__SET('idioma_nombre',$r->idioma_nombre);
                $result[] = $alm;
            }
            return $result;
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());

        }

    }
    /*
    lista datos para cargar combo devolviendo array

    */
        public function ListarComboArray($idioma)
    {
        $this->pdo = new Conexion();
        try
        {
            $result = array();
            
            $stm = $this->pdo->prepare('SELECT id,nombre FROM categoria  WHERE estado=1 and idioma_id='.$idioma);
            $stm->execute();
            
            foreach($stm->fetchAll(PDO::FETCH_ASSOC) as $r)
            {
                array_push($result,$r);
            }
            return $result;
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());

        }

    }
    
    /**
     * Obtiene los datos de un registro especifico
     * @param type $id
     * @return \Sede
     */
    public function Obtener($id)
    {
        $this->pdo = new Conexion();
        try{
            
            $stm = $this->pdo
                    ->prepare("SELECT * FROM categoria WHERE id =?");
            
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $alm = new Categoria();
            
            $alm->__SET('id',$r->id);
            $alm->__SET('nombre',$r->nombre);
            $alm->__SET('tipo',$r->tipo);
            $alm->__SET('foto',$r->foto);
            $alm->__SET('idioma_id',$r->idioma_id);
            $alm->__SET('estado',$r->estado);
                        
            return $alm;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    
    /**
     * Elimnar un registro
     * @param type $id
     */
    public function Eliminar($id)
    {   
        $this->pdo = new Conexion();
        try
        {
            $stm = $this->pdo->prepare('DELETE FROM categoria WHERE id=?');
            $stm->execute(array($id));
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());
        }
    }
    
    /**
     * Actualiza los datos en la BD
     * @param Sede $data
     */
    public function Actualizar(Categoria $data)
    {
        $this->pdo = new Conexion();
        try
        {
            $sql = "UPDATE categoria SET 
                            nombre=?,
                            tipo=?,
                            foto=?,
                            idioma_id=?,
                            estado=?
                            
                    WHERE id=? ";
            $this->pdo->prepare($sql)
                    ->execute(
                        array(
                                $data->__GET('nombre'),
                                $data->__GET('tipo'),
                                $data->__GET('foto'),
                                $data->__GET('idioma_id'),
                                $data->__GET('estado'),
                                $data->__GET('id'),
                                )
                        );
                    
                    
        } catch (Exception $ex) 
        {
            die($ex->getMessage());
        }
    }
    /**
     * Registra los datos en la BD
     * @param Sede $data
     */
    public function Registrar(Categoria $data)
    {
        $this->pdo = new Conexion();
        
        try
        {
            $sql ="INSERT INTO Categoria (nombre,tipo,foto,idioma_id,estado)
                   VALUES (?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                    ->execute(
                        array(
                                $data->__GET('nombre'),
                                $data->__GET('tipo'),
                                $data->__GET('foto'),
                                $data->__GET('idioma_id'),
                                $data->__GET('estado'),
                            )
                        );
        } 
        catch (Exception $ex) 
        {
            die($ex->getMessage());

        }
    }
}


?>

