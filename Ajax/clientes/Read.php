<?php
        session_start();
        include_once '../../includes/config.php';

        $message = '';

        $search = strip_tags(filter_input(type: INPUT_POST, var_name:'searching', filter: FILTER_SANITIZE_STRIPPED));

        if(empty($search)){
            $message = ['status'=> 'info', 'message'=> 'Favor, preencha o campo de busca', 'redirect'=> '', 'Lines' => 0];
            echo json_encode($message);
            return;
        }else{
            $Read = $pdo->prepare(query:"SELECT cliente_id, cliente_nome, cliente_email, cliente_status, cliente_cadastro FROM si_clientes WHERE cliente_nome = :cliente_nome AND cliente_status = :cliente_status");

            $Read -> bindValue(param:'cliente_nome', value: $search);
            $Read -> bindValue(param:'cliente_status', value:1);
            $Read -> execute();

            $Lines = $Read -> rowCount();

            if($Lines == 0){
                $message = ['status'=> 'info', 'message'=> 'Cliente não localizado!', 'redirect'=> '', 'Lines' => 0];
                echo json_encode($message);
                return;
            }else{
                foreach($Read as $Show){
                    $register = ($Show['cliente_cadastro'] == '' || $Show['cliente_cadastro'] == '0000-00-00 00:00:00' ? '-' : date('d/m/Y H:i', strtotime($Show['cliente_cadastro'])));
                    $stats = ($Show['cliente_status'] == '0' ? 'INATIVO' : 'ATIVO');
                    $message = ['status'=> 'success',
                    'message'=> 'Cliente encontrado',
                    'cliente_nome' => strip_tags($Show['cliente_nome']),
                    'cliente_email' => strip_tags($Show['cliente_email']),
                    'cliente_status' => strip_tags($stats),
                    'cliente_cadastro' => strip_tags($register),
                    'cliente_id' => strip_tags($Show['cliente_id'])];

                    echo json_encode($message);
                    return;
                }
            }
        }
?>