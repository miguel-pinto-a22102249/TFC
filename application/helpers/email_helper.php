<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Deve ser passado um array com os campos menssagem, from, nome(em que nome é enviado o emial),
 * to, subject e debugger_mode(true ou false)
 * 
 * @author André Carvalho
 * 
 * @param array $config
 * @return boolean Retorna true caso seja enviado com sucesso
 */
function enviaEmail($config) {

    $configEmail['protocol'] = config_item('email.protocol');
    $configEmail['smtp_user'] = config_item('email.smtp_user');
    $configEmail['smtp_pass'] = config_item('email.smtp_pass');
    $configEmail['smtp_crypto'] = config_item('email.smtp_crypto');
    $configEmail['smtp_host'] = config_item('email.smtp_host');
    $configEmail['smtp_port'] = config_item('email.smtp_port');
    $configEmail['mailtype'] = config_item('email.mailtype');
    $configEmail['charset'] = config_item('email.charset');
    $configEmail['newline'] = config_item('email.newline');
    $configEmail['wordwrap'] = config_item('email.wordwrap');

    $CI = &get_instance();


    $CI->load->library('email');
    $CI->email->initialize($configEmail);

    if (isset($config['from']) && $config['from'] != "" && isset($config['nome']) && $config['nome'] != "") {
        $CI->email->from($config['from'], $config['nome']);
    }

    if (isset($config['to']) && $config['to'] != "") {
        $CI->email->to($config['to']);
    }

    if (isset($config['subject']) && $config['subject'] != "") {
        $CI->email->subject($config['subject']);
    }

    if (isset($config['mensagem']) && $config['mensagem'] != "") {
        $CI->email->message($config['mensagem']);
    }
    
    if (isset($config['reply_to']) && $config['reply_to'] != "") {
        $CI->email->reply_to($config['reply_to']);
    }



    if ($CI->email->send() == 1) {
        if (isset($config['debugger_mode']) && $config['debugger_mode'] == TRUE) {
            echo $CI->email->print_debugger();
        }
        return true;
    }
    return false;
}
