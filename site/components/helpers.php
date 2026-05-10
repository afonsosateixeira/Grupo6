<?php
function mostrarValor($valor){
    return !empty($valor)? htmlspecialchars($valor) : "<span style='color:#888; font-style:italic; font-size:0.9em;'>Desconhecido</span>";
}

function mostrarValor2($valor){
    return !empty($valor)? htmlspecialchars($valor) : "<span style='color:#888; opacity:0.5;'>&mdash;</span>";
}

function corStatus($status){
    switch($status){
        case 'Disponível':
            return '#2eaf55';
        case 'Em processo':
            return '#eb8729';
        case 'Adotado':
            return '#cc3f14';
    }
}

function mostrarIdade($data){
    if(empty($data)){
        return "<span style='color:#888; font-style:italic; font-size:0.9em;'>Desconhecido</span>";
    }

    $dataNasc = new DateTime($data);
    $hoje = new DateTime();

    $dataForm = $dataNasc->format('d/m/Y');
    $diferenca = $hoje->diff($dataNasc);

    $ano= $diferenca->y;
    $mes= $diferenca->m;

    $mes == 1? $mes = $mes. " mês" : $mes = $mes. " meses";
    $ano == 1? $ano = $ano. " ano" : $ano = $ano. " anos";

    if($ano>1){
        $idade = $ano." e ". $mes;
    } else if($ano<0 || $mes>0){
        $idade= $mes;
    }else{
        $idade ="Recém nascido";
    }

    return $dataForm . " <span style='color:#666; font-size:0.9em;'>(" . $idade. ") </span>";
}
?>