<?php

error_reporting(0);
ini_set("display_errors", 0);
ini_set("memory_limit", "-1");
set_time_limit(0);

$handle = fopen("assets/petroecol_clientes.csv", "r");

echo "INSERT INTO ci_clientes (id_antigo, codigo, nome, razao_social, email, telefone, tipo_negocio, grupo_negocio, rua, numero, cep, bairro, complemento, cidade, estado, pais, cnpj, inscricao_estadual, observacao, data_criacao, dia_pagamento, status, data_inativo, atendimentos_agendados, atendimentos_atrasados, atendimentos_finalizados, frequencia_coleta) 
        VALUES <br>";

$row = 0;
while ($v = fgetcsv($handle, 1000, ";")) {
    if ($row++ == 0) { // pula primeira linha 
        continue;
    }

    // Formatar a data para o formato americano (YYYY-MM-DD)
    $data_criacao = date("Y-m-d", strtotime(str_replace("/", "-", $v[19])));
    $data_inativo = date("Y-m-d", strtotime(str_replace("/", "-", $v[22])));

    echo "($v[0], \"$v[1]\", \"$v[2]\", \"$v[3]\", \"$v[4]\", \"$v[5]\", \"$v[6]\", \"$v[7]\", \"$v[8]\", \"$v[9]\", \"$v[10]\", \"$v[11]\", \"$v[12]\", \"$v[13]\", \"$v[14]\", \"$v[15]\", \"$v[16]\", \"$v[17]\", \"$v[18]\", '$data_criacao', \"$v[20]\", \"$v[21]\", '$data_inativo', \"$v[23]\", \"$v[24]\", \"$v[25]\", \"$v[26]\"),<br>";
}

fclose($handle);

?>
