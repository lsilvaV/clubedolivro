<?php

class Operacao{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__). './Conexao.php';

        $bd = new Conexao();

        $this->con = $bd->connect();
    }

    function createLivro($campo_2, $campo_3, $campo_4){
        $stmt = $this->con->prepare("INSERT INTO tblivro (nomeLivro, paginasLivro, imgLivro) VALUES (?,?,?)");

        $stmt->bind_param("sss", $campo_2, $campo_3, $campo_4);
            if($stmt->execute())
                return true;
            return var_dump($stmt);
    }

    function getLivro(){
        $stmt = $this->con->prepare("Select * from tblivro");
        $stmt->execute();
        $stmt->bind_result($uid, $nomeLivro, $paginasLivro, $imgLivro);

        $dicas = array();

        while($stmt->fetch()){
            $dica = array();
            $dica['uid'] = $uid;
            $dica['nomeLivro'] = $nomeLivro;
            $dica['paginasLivro'] = $paginasLivro;
            $dica['imgLivro'] = $imgLivro;

            array_push($dicas,$dica);

        }
        return $dicas;
    }
}

?>