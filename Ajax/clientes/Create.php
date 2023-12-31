<?php
        session_start();
        include_once '../../includes/config.php';

        $message = '';

        $searching = filter_input_array(type: INPUT_POST, options: FILTER_SANITIZE_STRIPPED);
        $search = array_map('strip_tags', $searching);

        //Verifica campo cliente
        if(empty($search['client'])){
            $message = ['status'=> 'info', 'message'=> 'Favor, preencha o campo cliente', 'redirect'=> '', 'Lines' => 0];
            echo json_encode($message);
            return;
        }

        //Verifica campo email
        if(empty($search['email'])){
            $message = ['status'=> 'info', 'message'=> 'Favor, preencha o campo e-mail', 'redirect'=> '', 'Lines' => 0];
            echo json_encode($message);
            return;
        }
        
        //Verifica campo CPF
        if(empty($search['email']) && $search['doc'] == 1){
            $message = ['status'=> 'info', 'message'=> 'Favor, preencha o campo CPF', 'redirect'=> '', 'Lines' => 0];
            echo json_encode($message);
            return;
        }

        //Verifica campo CNPJ
        if(empty($search['cnpj']) && $search['doc'] == 2){
            $message = ['status'=> 'info', 'message'=> 'Favor, preencha o campo CNPJ', 'redirect'=> '', 'Lines' => 0];
            echo json_encode($message);
            return;
        }

        $fileCount = '';

        //Verifica se há algum documento anexado
        if($_FILES['files']['name'] == ''){
            $message = [
                    "message" => "Favor, anexe uma foto no cadastro do cliente",
                    "status" => "info",
                    "redirect" => ""
                    ];
            echo json_encode($message);
            return;
            $fileCount = 'no';
        }       
        
        //Verifica o tipo de documento
        if($search['doc'] == 1){
            $doc = strip_tags($search['cpf']);
        }else{
            $doc = strip_tags($search['cnpj']);
        }

            $Read = $pdo->prepare(query:"SELECT cliente_documento FROM si_clientes WHERE cliente_documento = :cliente_documento");

            $Read -> bindValue(param:'cliente_documento', value: $doc);
            $Read -> execute();

            $Lines = $Read -> rowCount();

            if($Lines >= 1){
                $message = ['status'=> 'info', 'message'=> 'Cliente já registrado!', 'redirect'=> '', 'Lines' => 0];
                echo json_encode($message);
                return;
            }

            //Verifica se foi ou não anexado uma imagem, se não foi recebe null, senão faz o upload
            if ($fileCount == 'no') {
                
                $FileName = 'NULL';
                $CreateFileName = 'NULL';
                $ext = 'NULL';
                
            }else{
            
            //Captura o nome do arquivo
            $FileName = strip_tags(mb_strtolower($_FILES['files']['name']));

            //Recupera a extensão do arquivo
            $FileExtension = strip_tags($_FILES['files']['type']);

            //Pega o diretório temporário onde o arquivo está
            $FilePath = strip_tags($_FILES['files']['tmp_name']);

            //Pega o tamanho do arquivo
            $FileSize = strip_tags($_FILES['files']['size']);

            //Definimos a pasta para o download do arquivo
            $_UP['pasta'] = '../../Images/Clients/';

            //Limpa possíveis caracteres, acentuação e extensões.
            $cover = str_replace(
                array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú',
                    'Û', 'Ü', 'ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó',
                    'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ý', 'ý', 'þ', 'ÿ', '"', '!', '@', '#', '$', '%', '&', '*', '(', ')', '_', '-', '+', '=', '{',
                    '[', '}', ']', '/', '?,', ';', ':', 'ª', 'º', '.docx', '.pdf', '.doc', '.htm', '.jfif', '.jpg', '.jpeg', '.png', '.msg', '.txt', '.xls', '.xlsx', '.tif', '.tiff', '.p7s', '.html', '.dat', '.oft', '.xlsm', '.rar', '.zip'),
                array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u',
                    'u', 'u', 'u', 'y', '', '', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'n', 'o', 'o',
                    'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'y', '', 'y', '', '', '', '', '', '', '', '', '', '', '', '-', '', '', '', '', '', '', '', '', '', '', '', '', '-' . date('d-m-Y H-i-s') . '.docx', '-' . date('d-m-Y H-i-s') . '.pdf', '-' . date('d-m-Y H-i-s') . '.doc', '-' . date('d-m-Y H-i-s') . '.htm', '-' . date('d-m-Y H-i-s') . '.jfif', '-' . date('d-m-Y H-i-s') . '.jpg', '-' . date('d-m-Y H-i-s') . '.jpeg', '-' . date('d-m-Y H-i-s') . '.png', '-' . date('d-m-Y H-i-s') . '.msg', '-' . date('d-m-Y H-i-s') . '.txt', '-' . date('d-m-Y H-i-s') . '.xls', '-' . date('d-m-Y H-i-s') . '.xlsx', '-' . date('d-m-Y H-i-s') . '.tif', '-' . date('d-m-Y H-i-s') . '.tiff', '-' . date('d-m-Y H-i-s') . '.p7s', '-' . date('d-m-Y H-i-s') . '.html', '-' . date('d-m-Y H-i-s') . '.dat', '-' . date('d-m-Y H-i-s') . '.oft', '-' . date('d-m-Y H-i-s') . '.xlsm', '-' . date('d-m-Y H-i-s') . '.rar', '-' . date('d-m-Y H-i-s') . '.zip')
                , $FileName);
            

            //Consultamos informações sobre o arquivo e selecionamos que tipo de extensão é o arquivo.
            $path = pathinfo($FileName);
            $ext = $path['extension'];

            //Verificamos as extensões
            if ($ext == 'js' || $ext == 'php' || $ext == 'html' || $ext == 'htm' || $ext == 'xhtml' || $ext == 'css' || $ext == 'ini' || $ext == 'py' || $ext == 'htaccess' || $ext == 'xml' || $ext == 'gz' || $ext == 'json' || $ext == 'go' || $ext == 'jsp' || $ext == 'cs' || $ext == 'asp' || $ext == 'aspx' || $ext == 'bat' || $ext == 'exe' || $ext == 'sql' || $ext == 'c' || $ext == '*' || $ext == 'rb' || $ext == 'erb' || $ext == 'jbuilder' || $ext == 'zip' || $ext == 'rar') {

                $message = [
                    "message" => "Este arquivo não é permitido",
                    "status" => "error",
                    "redirect" => ""
                ];

                //O JSON retorna para o usuário via AJAX a mensagem de sucesso na tela.
                echo json_encode($message);
                return false;
                die;

            }

            $guid = rand(1000, 10000);
            //Cria novo nome para o arquivo (criptografado)
            $CreateFileName = $guid . '-' . hash('sha256', $cover) . rand(10, 200) . '.' . $ext;

            //Definimos a pasta de destino + o nome do arquivo.
            $destiny = $_UP['pasta'] . '' . $CreateFileName;

            //Realizamos o upload
            move_uploaded_file($FilePath, $destiny);}

            $token = rand(100,100). '-'. $search['client'];
            $Create = $pdo->prepare(query:"INSERT INTO ". DB_CLIENTS ."
            (cliente_imagem, cliente_nome, cliente_email, cliente_endereco, cliente_cep, cliente_cidade, cliente_estado, cliente_documento, cliente_telefone, cliente_token, cliente_status, cliente_sessao)
             VALUES (:cliente_imagem, :cliente_nome, :cliente_email, :cliente_endereco, :cliente_cep, :cliente_cidade, :cliente_estado, :cliente_documento, :cliente_telefone, :cliente_token, :cliente_status, :cliente_sessao)");
            $Create -> bindValue(param: ':cliente_imagem', value: $CreateFileName);
            $Create -> bindValue(param: ':cliente_nome',value: $search['client']);
            $Create -> bindValue(param: ':cliente_email',value: $search['email']);
            $Create -> bindValue(param: ':cliente_endereco',value: $search['address']);
            $Create -> bindValue(param: ':cliente_cep',value: $search['zipcode']);
            $Create -> bindValue(param: ':cliente_cidade',value: $search['city']);
            $Create -> bindValue(param: ':cliente_estado',value: $search['state']);
            $Create -> bindValue(param: ':cliente_documento',value: $doc);
            $Create -> bindValue(param: ':cliente_telefone',value: $search['phone']);
            $Create -> bindValue(param: ':cliente_token',value: $token);
            $Create -> bindValue(param: ':cliente_status', value: 1);
            $Create -> bindValue(param: ':cliente_sessao', value: 0);
            $Create -> execute();

            $message = ['status'=> 'success', 'message'=> 'Cliente registrado com sucesso', 'redirect'=> 'clients'];
            echo json_encode($message);
            return;
        
?>