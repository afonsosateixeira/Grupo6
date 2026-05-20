<?php
    require_once '../../db.php';
    $caminhoPasta = "../../assets/img/animals/";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nome = trim($_POST['nome_animal'] ?? '');
        $specieID = (int)($_POST['specie_id'] ?? 0);
        $breed = !empty($_POST['breed_id']) ? (int)$_POST['breed_id'] : null;
        $genero = trim($_POST['gender'] ?? '');
        $porte = trim($_POST['size'] ?? '');
        $data = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
        $descricao = trim($_POST['description'] ?? '');   

        # Processo de criação do animal
        if (isset($_POST['btnCriar'])) {
            $nomeArquivo = "";

                if(!empty($_FILES['image']['name'])){
                    $nomeArquivo = $_FILES['image']['name'];

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo)) {
                        header("Location: ../animalList?status=erro_imagem");
                        exit();
                    }
                }

                $stmt=$conn->prepare("INSERT INTO animals (name, specie_id, breed_id, gender, size, image, birth_date, description) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("siisssss",$nome, $specieID, $breed, $genero, $porte, $nomeArquivo, $data, $descricao );
                $stmt->execute();
                header("Location: ../animalList?status=criado");
                exit(); 
        }

        # Processo de edição do animal
        if (isset($_POST['btnEditar'])) {
            $id = (int)$_POST['id_animal'];
            
            $nomeArquivo = null;

            if (!empty($_FILES['image']['name'])) {
                $nomeArquivo = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo);
            }
            
            $stmt = $conn->prepare("UPDATE animals SET name=?, specie_id=?, breed_id=?, gender=?, size=?, image=COALESCE(?, image), birth_date=?, description=? WHERE id=?");
            
            $stmt->bind_param("siisssssi", $nome, $specieID, $breed, $genero, $porte, $nomeArquivo, $data, $descricao, $id);
            $stmt->execute();
            header("Location: ../animalList?status=editado");
            exit();
        }
    }

    if(isset($_GET['action'])&& isset($_GET['id'])){
        $action = $_GET['action'];
        $id= intval($_GET['id']);

        # Processo de eliminação do animal
        if($action === 'eliminar'){
            $stmt= $conn->prepare("DELETE FROM animals WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("Location: ../animalList?status=apagado");
            exit();
        }
    }

    header("Location: ../animalList");
    exit();

