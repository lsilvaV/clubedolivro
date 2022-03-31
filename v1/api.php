<?php
    require_once('../model/Operacao.php');

    function isTheseParametersAvailable($params){
        $available = true;
        $missingParams="";

        foreach($params as $param){
            if(!isset($_POST[$param]) || strlen($_POST[$param]) <= 0){
                $available = false;
                $missingParams = $missingParams.", ".$param;
            }
        }

        if(!$available){
            $response = array();
            $response['error'] = true;
            $response['message'] = 'Parameters '.substr($missingParams, 1, strlen($missingParams)).' missing';
    
            echo json_encode($response);

            die();
            
        }
    }

    $response = array();
    
    if(isset($_GET['apicall'])){
        switch($_GET['apicall']){

            case 'createLivro':
                isTheseParametersAvailable(array('campo_2','campo_3','campo_4'));

                $db = new Operacao();

                $result = $db->createLivro(
                    $_POST['campo_2'],
                    $_POST['campo_3'],
                    $_POST['campo_4'],
                );

                if($result){
                    $response['error'] = false;
                    $response['message'] = 'Dados inseridos com sucesso.';
                    $response['dadoscreate'] = $db->getLivro();
                }else{
                    $response['error'] = true;
                    $response['message'] = 'Dados não foram inseridos';
                }
            break;

            case 'getLivro':
                $db = new Operacao();
                $response['error'] = false;
                $response['message'] = 'Dados listados com sucesso.';
                $response['dadosLista']=$db->getLivro();
            break;
        }
    }else{

        $response['error'] = true;
        $response['message'] = 'Chamada de API com defeito.';
    }

    echo json_encode($response);
?>