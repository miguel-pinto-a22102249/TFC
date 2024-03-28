<?php

/**
 * Cria uma hash para a password fornecida
 *
 * @author Andre
 * 
 * @param string $password Description
 * 
 * @return string Retorna o Hash gerado
 */
function criaPasswordHash($password) {
    $options = [
        'salt' => config_item('password.salt')
    ];
    $hash = password_hash($password, config_item('password.algoritmo_encriptacao'));
    return $hash;
}

/**
 * Verifica se a password conincide com o hash
 * 
 * @author Andre
 * 
 * @param string $password
 * @param string $hash
 * 
 * @return boolean Retorna true caso a password corresponda ao Hash, caso
 * contrário devolve false
 */
function verificaPassword($password, $hash) {
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Gera senhas aleatórias 
 * SEM QUALQUER ENCRIPTAÇÃO
 *
 * @param int $qtyCaraceters quantidade de caracteres na senha, por padrão 8
 * @author André Carvalho
 * @return String 
 */
function generatePassword($qtyCaraceters = 10) {
    //Letras minúsculas embaralhadas
    $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

    //Letras maiúsculas embaralhadas
    $capitalLetters = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

    //Números aleatórios
    $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
    $numbers .= 1234567890;

    //Caracteres Especiais
//    $specialCharacters = str_shuffle('!@#$%*-');

    //Junta tudo
    $characters = $capitalLetters . $smallLetters . $numbers;

    //Embaralha e pega apenas a quantidade de caracteres informada no parâmetro
    $password = substr(str_shuffle($characters), 0, $qtyCaraceters);

    //Retorna a senha
    return $password;
}
