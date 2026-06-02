<?php 
function processo($msg, $cor, $link){
    $href = $link !== '' ? $link : '#';
    
    echo '<a href="' . htmlspecialchars($href) . '" class="btn btn-' . $cor . '">
            <i class="fa-solid fa-heart me-2"></i> ' . htmlspecialchars($msg) . '
          </a>';
}

if(isset($animal)):
    if(empty($_SESSION['auth'])):
        $paginaAtual = "animalDetails?id=" . $animal['id']; 
        $linkTarget = "login?redirect=" . urlencode($paginaAtual);

        processo('Adotar ' . $animal['name'], 'success', $linkTarget);

    else:
        $user_id = (int)$_SESSION['id_user'];
        $animal_id = (int)$animal['id'];

        $processo =prepareQuery($conn, 'SELECT id, status FROM adoption_processes WHERE user_id = ? AND animal_id = ? LIMIT 1', 'ii', $user_id, $animal_id)->get_result()->fetch_assoc();

        if(!$processo){
            $linkTarget = "backoffice/components/action_adoption.php?action=adotar&id_animal=" . $animal['id'];
            processo('Adotar ' . $animal['name'], 'success', $linkTarget);
        } 
        elseif($processo['status'] === 'Pendente'){
            $linkCancel = "backoffice/components/action_adoption.php?action=cancelar_processo&id=" . $processo['id'] . "&id_animal=" . $animal['id'];
            processo('Cancelar Processo', 'warning', $linkCancel);
        } 
        elseif($processo['status'] === 'Aprovado'){
            processo('Aprovado', 'outline-success',''); 
        } 
        elseif($processo['status'] === 'Rejeitado'){
            processo('Rejeitado', 'danger','');
        }

    endif; 
endif; 