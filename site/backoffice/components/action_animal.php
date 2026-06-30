<?php
    require_once '../../db.php';
    require_once '../../components/helpers.php';
    $caminhoPasta = "../../assets/img/animals/";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id = (int)($_POST['id_animal'] ?? 0);
        $nome = trim($_POST['nome_animal'] ?? '');
        $specieID = (int)($_POST['specie_id'] ?? 0);
        $breed = !empty($_POST['breed_id']) ? (int)$_POST['breed_id'] : null;
        $genero = trim($_POST['gender'] ?? '');
        $porte = trim($_POST['size'] ?? '');
        $data = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
        $descricao = trim($_POST['description'] ?? '');  
        
        if (empty($nome) || $specieID <= 0 || !in_array($genero, ['Macho', 'Fêmea'])) {
            redirect("../animalList?status=erro_validacao");
            exit; 
        }

        # Processo de criação do animal
        if (isset($_POST['btnCriar'])) {
            $nomeArquivo = "";

                if(!empty($_FILES['image']['name'])){
                    $nomeArquivo = $_FILES['image']['name'];

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo)) {
                        redirect("../animalList?status=erro_imagem");
                    }
                }
                prepareQuery($conn, "INSERT INTO animals (name, specie_id, breed_id, gender, size, image, birth_date, description) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 'siisssss', $nome, $specieID, $breed, $genero, $porte, $nomeArquivo, $data, $descricao);
                redirect("../animalList?status=criado");
        }

        # Processo de edição do animal
        if (isset($_POST['btnEditar'])) {            
            $nomeArquivo = null;

            if (!empty($_FILES['image']['name'])) {
                $nomeArquivo = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo);
            }
            prepareQuery($conn, "UPDATE animals SET name=?, specie_id=?, breed_id=?, gender=?, size=?, image=COALESCE(?, image), birth_date=?, description=? WHERE id=?", 'siisssssi', $nome, $specieID, $breed, $genero, $porte, $nomeArquivo, $data, $descricao, $id);
            redirect("../animalList?status=editado");
        }
    }

    if(isset($_GET['action'])&& isset($_GET['id'])){
        $action = $_GET['action'];
        $id= intval($_GET['id']);

        # Processo de eliminação do animal
        if($action === 'eliminar'){
            prepareQuery($conn, "DELETE FROM animals WHERE id = ?", 'i', $id);
            redirect("../animalList?status=eliminado");
        }
    }
    redirect("../animalList");