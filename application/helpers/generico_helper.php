<?

/**
 * Se o login atual for um admin a função devolve TRUE, caso contrário devolve FALSE
 *
 * @version 1.0
 * @return boolean
 */
function eAdmin() {
    $CI = &get_instance();
    if ($CI->session->userdata('TipoUtilizador') == Login::TECNICO) {
        return true;
    }
    return false;
}

function eTecnico() {
    return eAdmin();
}

function eSuperAdmin() {
    $CI = &get_instance();
    if ($CI->session->userdata('TipoUtilizador') == Login::SUPER_ADMIN) {
        return true;
    }
    return false;
}

function eUtilizador() {
    $CI = &get_instance();
    if ($CI->session->userdata('TipoUtilizador') == Login::UTILIZADOR) {
        return true;
    }
    return false;
}



/**
 * Funcao para codificar urls
 *
 * @param string $string
 * @param boolena $lowercase
 *
 * @return string
 */
function ac_urlencode($string, $lowercase = true) {
    $comAcentos = ['à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú'];

    $semAcentos = ['a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U'];

    $string = str_replace($comAcentos, $semAcentos, $string);

    if ($lowercase == true) {
        $string = strtolower($string);
    }

    $string = urlencode(url_title(trim($string)));

    return $string;
}


/**
 * Função para redimensionar imagens
 *
 * @param string $caminho_original
 * @param string $caminho_destino
 * @param int $largura
 * @param int $altura
 * @param boolean $manter_original - Indica se a imagem original deve ser mantida (True) ou removida (False)
 */
function redimensionarImagem($caminho_original, $caminho_destino, $largura_maxima, $altura_maxima, $manter_original = false) {
    // Obtém as informações da imagem original
    $info_imagem = getimagesize($caminho_original);

    // Verifica o tipo de imagem
    $tipo_imagem = $info_imagem[2];

    // Cria a imagem original baseada no tipo
    switch ($tipo_imagem) {
        case IMAGETYPE_JPEG:
            $imagem_original = imagecreatefromjpeg($caminho_original);
            break;
        case IMAGETYPE_PNG:
            $imagem_original = imagecreatefrompng($caminho_original);
            break;
        // Add other image types as needed
        default:
            // Trate outros tipos de imagem ou retorne um erro, se necessário
            return false;
    }

    // Obtém as dimensões da imagem original
    [$largura_original, $altura_original] = getimagesize($caminho_original);

    // Calcula as novas dimensões mantendo a proporção
    $proporcao = $largura_original / $altura_original;

    if ($largura_original > $altura_original) {
        // A largura é maior ou igual à altura
        $largura = $largura_maxima;
        $altura = $largura_maxima / $proporcao;
    } else {
        // A altura é maior que a largura
        $altura = $altura_maxima;
        $largura = $altura_maxima * $proporcao;
    }

    // Cria uma nova imagem
    $nova_imagem = imagecreatetruecolor($largura, $altura);

    // Define a cor de fundo para imagens PNG (para evitar fundo preto em transparência)
    if ($tipo_imagem == IMAGETYPE_PNG) {
        $cor_fundo = imagecolorallocatealpha($nova_imagem, 255, 255, 255, 127);
        imagefill($nova_imagem, 0, 0, $cor_fundo);
        imagesavealpha($nova_imagem, true);
    }

    // Redimensiona a imagem
    imagecopyresampled($nova_imagem, $imagem_original, 0, 0, 0, 0, $largura, $altura, $largura_original, $altura_original);

    // Salva a nova imagem no mesmo formato da original
    switch ($tipo_imagem) {
        case IMAGETYPE_JPEG:
            imagejpeg($nova_imagem, $caminho_destino);
            break;
        case IMAGETYPE_PNG:
            imagepng($nova_imagem, $caminho_destino);
            break;
        // Add other image types as needed
    }

    // Libera a memória
    imagedestroy($nova_imagem);
    imagedestroy($imagem_original);

    // Remove a imagem original após o redimensionamento, se desejado
    if (!$manter_original) {
        unlink($caminho_original);
    }
}

function callback_date_valid($date){
    $day = (int) substr($date, 0, 2);
    $month = (int) substr($date, 3, 2);
    $year = (int) substr($date, 6, 4);
    return checkdate($month, $day, $year);
}


