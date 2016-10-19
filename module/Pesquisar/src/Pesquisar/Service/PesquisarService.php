<?php

/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 05/10/2016
 * Time: 17:04
 */

namespace Pesquisar\Service;

class PesquisarService
{

    public function pesquisarTcc($where = NULL)
    {

        $sql = new Sql($this->getAdapter());

        $select = $sql->select('tcc')->columns([
            'id_tcc',
            'id_usuario_cadastro',
            'id_usuario_alteracao',
            'tx_titulo_tcc',
            'tx_resumo',
            'dt_cadastro',
            'dt_alteracao',
            'nr_nota_final',
            'ar_arquivo',
        ])
            // Buscando dados das Fks
            ->join('banca_examinadora', 'banca_examinadora.id_banca_examinadora = tcc.id_banca_examinadora', ['dt_banca'])
            ->join('area_conhecimento', 'area_conhecimento.id_area_conhecimento = tcc.id_area_conhecimento', ['nm_area_conhecimento'])
            ->join('tipo_tcc', 'tipo_tcc.id_tipo_tcc = tcc.id_tipo_tcc', ['nm_tipo_tcc'])
            ->join('professor', 'professor.id_professor = tcc.id_professor_orientador', ['nm_professor']);

        $where = [
            'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
            #'banca_examinadora.dt_banca' => '2016-10-14 00:00:00',
        ];

        $select->where($where)->order(['id_tcc DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return $sql->prepareStatementForSqlObject($select)->execute();
    }
}