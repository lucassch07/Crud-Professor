<?php
    $busca = isset($_GET['busca'])?$_GET['busca']:0; 
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
 
        
    $lista = Professor::listar($tipo, $busca); 
    $itens = "";

    foreach($lista as $professor){
        $item = file_get_contents('itens_list_prof.html');

        $item = str_replace('{id}', $professor->getId(), $item);
        $item = str_replace('{nome}', $professor->getNome(), $item);
        $item = str_replace('{cpf}', $professor->getCpf(), $item);
        $item = str_replace('{rg}', $professor->getRg(), $item);
        $item = str_replace('{idade}', $professor->getIdade(), $item);
        $item = str_replace('{formacao}', $professor->getFormacao(), $item);
        $item = str_replace('{foto_sua}', $professor->getFoto_sua(), $item);
        $itens .= $item;
    }

    $listagem = file_get_contents('listagem_prof.html');
    $listagem = str_replace('{itens}', $itens, $listagem);
    print $listagem;

?>