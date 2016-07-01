<?php
namespace Estrutura\Helpers;

use Estrutura\Helpers\Arquivo;

/**
 *
 * @author Alysson Vicuña
 *
 */
class Cache
{

    /**
     *
     * @return bool
     */
    public static function limparCacheDoSistema()
    {
        try {
            $arExcecoes = array();
            $arExcecoes[] = 'leia-me.txt';
            \Estrutura\Helpers\Arquivo::deletarArquivosNoDiretorioComExcecao('data\cache', $arExcecoes);
            \Estrutura\Helpers\Arquivo::deletarArquivosNoDiretorioComExcecao('public\assets\cache', $arExcecoes);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
}
