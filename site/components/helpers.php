<?php
function mostrarValor($valor){
    return !empty($valor)? htmlspecialchars($valor) : "<span style='color:#888; font-style:italic;'>Desconhecido</span>";
}

function mostrarIdade($data){
    if(empty($data)){
        return "<span style='color:#888; font-style:italic;'>Desconhecido</span>";
    }

    $dataNasc = new DateTime($data);
    $hoje = new DateTime();

    $dataForm = $dataNasc->format('d/m/Y');
    $diferenca = $hoje->diff($dataNasc);

    $ano= $diferenca->y;
    $mes= $diferenca->m;

    if($ano>0){
        $idade = $ano." ano "." e ".$mes." meses ";
    } else if($mes<0){
        $idade= $mes. "meses";
    }else{
        $idade ="Recém nascido";
    }

    return $dataForm . "<span style='color:#666; font-size:0.9em;'>(" . $idade. ") </span>";
}
?>