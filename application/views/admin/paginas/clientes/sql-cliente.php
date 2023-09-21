<?php

error_reporting(0);
ini_set("display_errors", 0 );
ini_set("memory_limit", "-1");
set_time_limit(0);
       
    $handle = fopen("assets/data/clientes2.csv", "r");

    echo "INSERT INTO ci_clientes (id, codigo, nome, razao_social, email, telefone, tipo_negocio, grupo_negocio, rua, numero, cep, bairro, complemento, cidade, estado, pais, cnpj, inscricao_estadual, observacao, data_criacao, dia_pagamento, status, data_inativo, atendimentos_agendados, atendimentos_atrasados, atendimentos_finalizados, frequencia_coleta)
        VALUES";
    
    
    $row = 0;
    while ($v = fgetcsv($handle, 1000, ";")) {
        if ($row++ == 0) { // pula primeira linha
            continue;
        }


        echo "($v[1], \"$v[2]\", \"$v[3]\", \"$v[4]\", \"$v[5]\", \"$v[6]\", \"$v[12]\", \"$v[7]\", \"$v[8]\", \"$v[9]\", \"$v[10]\", \"$v[11]\", $v[0],0),<br>";

        
    }
   
   
        fclose($handle);

?>