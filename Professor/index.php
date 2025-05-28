<?php

    require_once("../classes/Professor.class.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = isset($_POST['id'])?$_POST['id']:0;
        $nome = isset($_POST['nome'])?$_POST['nome']:"";
        $cpf = isset($_POST['cpf'])?$_POST['cpf']:"";
        $rg = isset($_POST['rg'])?$_POST['rg']:"";
        $idade = isset($_POST['idade'])?$_POST['idade']:0;
        $formacao = isset($_POST['formacao'])?$_POST['formacao']:"";
        //$anexo = isset($_POST['anexo'])?$_POST['anexo']:"";
        $acao = isset($_POST['acao'])?$_POST['acao']:"";
        
        $destino_anexo = 'uploads/'.$_FILES['foto_sua']['name'];


        move_uploaded_file($_FILES['foto_sua']['tmp_name'], PATH.UPLOAD.$destino_anexo);
        $professor = new Professor($id, $nome, $cpf, $rg, $idade, $formacao, $destino_anexo);

        if($acao == "salvar"){
            if($id > 0){
                $resultado = $professor->alterar();
            } else {
                $resultado = $professor->inserir();
            }
        } else 
            $resultado = $professor->excluir();
        

        if($resultado){
            header('Location: index.php');
        } else {
            echo "Erro ao salvar dados: ". $professor;
        }
    } else if($_SERVER['REQUEST_METHOD'] == 'GET'){

        $formulario = file_get_contents('form_cad_prof.html');
        
        $id = isset($_GET['id'])?$_GET['id']:0;
        $resultado = Professor::listar(1,$id);

        if ($resultado){
            $professor = $resultado[0];
            $formulario = str_replace('{id}', $professor->getId(), $formulario);
            $formulario = str_replace('{nome}', $professor->getNome(), $formulario);
            $formulario = str_replace('{cpf}', $professor->getCpf(), $formulario);
            $formulario = str_replace('{rg}', $professor->getRg(), $formulario);
            $formulario = str_replace('{idade}', $professor->getIdade(), $formulario);
            $formulario = str_replace('{formacao}', $professor->getFormacao(), $formulario);
            $formulario = str_replace('{foto_sua}', $professor->getFoto_sua(), $formulario);
        } else{
            $formulario = str_replace('{id}', '', $formulario);
            $formulario = str_replace('{nome}', '', $formulario);
            $formulario = str_replace('{cpf}', '', $formulario);
            $formulario = str_replace('{rg}', '', $formulario);
            $formulario = str_replace('{idade}', '', $formulario);
            $formulario = str_replace('{formacao}', '', $formulario);
            $formulario = str_replace('{foto_sua}', '', $formulario);
        }
        print($formulario);
        include_once('list_prof.php');
    }
?>