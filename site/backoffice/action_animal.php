<?php
    require_once '../db.php';
    $caminhoPasta = "../assets/img/animals/";

    /* criar e guardar */

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome_animal'] ?? '');
        $specieID = (int)($_POST['specie_id'] ?? 0);
        $breed_bruto = !empty($_POST['breed_id']) ? $_POST['breed_id'] : null;
        $breed_seguro = ($breed_bruto === null) ? "NULL" : (int)$breed_bruto;
        $data_bruta = $_POST['data_nascimento'] ?? '';
        $genero = trim($_POST['gender'] ?? '');
        $porte = trim($_POST['size'] ?? '');
        $descricao = trim($_POST['description'] ?? '');

        $nome_seguro = $conn->real_escape_string($nome);
        $genero_seguro = $conn->real_escape_string($genero);
        $porte_seguro = $conn->real_escape_string($porte);
        $descricao_segura = $conn->real_escape_string($descricao);
        $data_segura = empty($data_bruta) ? "NULL" : "'" . $conn->real_escape_string($data_bruta) . "'";

        // criar
        if (isset($_POST['btnCriar'])) {
            $nomeArquivo = "";

                if(!empty($_FILES['image']['name'])){
                    $nomeArquivo = $_FILES['image']['name'];

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo)) {
                        header("Location: animalList?status=erro_imagem");
                        exit();
                    }
                }

                $sql = "INSERT INTO animals (name, specie_id, breed_id, birth_date, gender, size, description, image) 
                        VALUES ('$nome_seguro', $specieID, $breed_seguro, $data_segura, '$genero_seguro', '$porte_seguro', '$descricao_segura', '$nomeArquivo')";
                $conn->query($sql);
                header("Location: animalList?status=criado");
                exit(); 
        }

        // editar/guardar
        if (isset($_POST['btnEditar'])) {
            $id = (int)$_POST['id_animal'];
            
            $sql = "UPDATE animals SET 
                    name = '$nome_seguro', 
                    specie_id = $specieID,
                    breed_id = $breed_seguro, 
                    birth_date = $data_segura,
                    gender = '$genero_seguro',
                    size = '$porte_seguro',
                    description = '$descricao_segura'
                    ";

            if (!empty($_FILES['image']['name'])) {
                $nomeArquivo = $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo)) {
                    $sql .= ", image = '$nomeArquivo'";
                }
            }

            $sql .= " WHERE id = $id";
            
            $conn->query($sql);
            header("Location: animalList?status=editado");
            exit();
        }
    }

    /* Botões da tabela */

    // ELIMINAR
    if (isset($_GET['btnEliminar'])) {
        $id = (int)$_GET['btnEliminar'];
        $conn->query("DELETE FROM animals WHERE id = $id");
        header("Location: animalList?status=apagado");
        exit();
    }

    // EDITAR
    if (isset($_GET['btnEditar'])) {
        $id = (int)$_GET['btnEditar'];
        header("Location: animalList?btnEditar=$id");
        exit();
    }

    header("Location: animalList");
    exit();