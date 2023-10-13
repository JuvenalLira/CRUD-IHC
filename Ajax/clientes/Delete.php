<?php
        session_start();
        include_once '../../includes/config.php';

        $message = '';

        $search = strip_tags(filter_input(type: INPUT_GET, var_name:'val', filter: FILTER_SANITIZE_STRIPPED));


            $Delete = $pdo->prepare(query:"DELETE FROM si_clientes WHERE cliente_id = :cliente_id");

            $Delete -> bindValue(param:'cliente_id', value: $search);
            $Delete -> execute();

            $message = ['status'=> 'success',
            'message'=> 'Cliente removido',
            'redirect' => 'clients'];

            echo json_encode($message);
            return;

?>