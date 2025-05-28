<?php

  include 'Database.class.php';

  class Professor{
    private $id;
    private $nome;
    private $cpf;
    private $rg;
    private $idade;
    private $formacao;
    private $foto_sua;

    public function __construct($id, $nome, $cpf, $rg, $idade, $formacao, $foto_sua){
      $this->id = $id;
      $this->nome = $nome;
      $this->cpf = $cpf;
      $this->rg = $rg;
      $this->idade = $idade;
      $this->formacao = $formacao;
      $this->foto_sua = $foto_sua;
    }

    public function setId($id){
      if($id == ''){
        throw new Exception("Error");
      }
      else {
        $this->id = $id;
      }
    }

    public function setNome($nome){
      if($nome == ''){
        throw new Exception("Error");
      }
      else {
        $this->nome = $nome;
      }
    }

    public function setCpf($cpf){
      if($cpf == ''){
        throw new Exception("Error");
      }
      else {
        $this->cpf = $cpf;
      }
    }

    public function setRg($rg){
      if($rg == ''){
        throw new Exception("Error");
      }
      else {
        $this->rg = $rg;
      }
    }

    public function setIdade($idade){
        if($idade == ''){
          throw new Exception("Error");
        }
        else {
          $this->idade = $idade;
        }
    }
    public function setFormacao($formacao){
        if($formacao == ''){
          throw new Exception("Error");
        }
        else {
          $this->formacao = $formacao;
        }
    }

    public function setFoto_sua($foto_sua){
        if($foto_sua == ''){
          throw new Exception("Error");
        }
        else {
          $this->foto_sua = $foto_sua;
        }
    }

    public function getId(): int{
      return $this->id;
    }

    public function getNome(): String{
      return $this->nome;
    }

    public function getCpf(): String{
      return $this->cpf;
    }
    public function getRg(): String{
      return $this->rg;
    }
    public function getIdade(): Int{
        return $this->idade;
    }
    public function getFormacao(): String{
        return $this->formacao;
    }
    public function getFoto_sua(): String{
        return $this->foto_sua;
      }

    public function __toString():String{
      $str = "Professor: $this->id - $this->nome - Cpf: $this->cpf - Rg: $this->rg - Idade: $this->idade - Formação: $this->formacao - Foto Sua: $this->foto_sua";

      return $str;
    }

    public function inserir():Bool {
      

      //montar o sql
      $sql = "INSERT INTO professor (nome, cpf, rg, idade, formacao, foto_sua) VALUES(:nome, :cpf, :rg, :idade, :formacao, :foto_sua)";
      
      $parametros = array(':nome'=>$this->getNome(),
                          ':cpf'=> $this->getCpf(),
                          ':rg'=> $this->getRg(),
                          ':idade'=> $this->getIdade(),
                          ':formacao'=> $this->getFormacao(),
                          ':foto_sua'=> $this->getFoto_sua());

      //executar o comando
      
      return Database::executar($sql, $parametros) == true;
    }

    public static function listar($tipo=0, $info=''): Array {
      
      $sql = "SELECT * FROM professor";
      if($tipo > 0){
        switch($tipo){
          case 1: $sql .= " WHERE id = :info ORDER BY id"; break; // filtro por id
          case 2: $sql .= " WHERE formacao like :info ORDER BY formacao"; $info = '%'.$info.'%'; break; // filtro por descrição
          case 3: $sql .= " WHERE nome like :info ORDER BY nome"; $info = '%'.$info.'%'; break;
        }
      }

      $parametros = array();
      if ($tipo > 0){
        $parametros = [':info'=>$info];
      }      
      
      $comando = Database::executar($sql, $parametros);
      //$resultado = $comando ->fetchAll();
      $professores = [];
      while ($registro = $comando->fetch()){
        $professor = new Professor($registro['id'], $registro['nome'], $registro['cpf'], $registro['rg'], $registro['idade'], $registro['formacao'], $registro['foto_sua']);
        array_push($professores, $professor);
      }
      return $professores;
    }

    public function alterar(): Bool {
      
      $sql = "UPDATE professor
                 SET nome = :nome,
                     cpf = :cpf,
                     rg = :rg,
                     idade = :idade,
                     formacao = :formacao
               WHERE id = :id";

      $parametros = array(
          ':id'=> $this->getId(),
          ':nome'=> $this->getNome(),
          ':cpf'=> $this->getCpf(),
          ':rg'=> $this->getRg(),
          ':idade'=> $this->getIdade(),
          ':formacao'=> $this->getFormacao());

      return Database::executar($sql, $parametros) == true;
    }

    public function excluir(): Bool {

      $sql = "DELETE FROM professor
                    WHERE id = :id"; 

      $parametros = array(':id'=> $this->getId());
    
      return Database::executar($sql, $parametros) == true;
    }
  } 
  
?>