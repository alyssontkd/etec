<?php

namespace BancaExaminadora\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\JsonModel;
use Estrutura\Helpers\Cript;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Data;

class BancaExaminadoraController extends AbstractCrudController
{
    /**
     * @var \BancaExaminadora\Service\BancaExaminadora
     */
    protected $service;

    /**
     * @var \BancaExaminadora\Form\BancaExaminadora
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction() {
  		return new ViewModel([
  				'service' => $this->service,
  				'form' => $this->form,
  				'controller' => $this->params('controller'),
  				'atributos' => array()
  		]);
  	}

    /*
    * Chamado quando é filtrado algo
    */
    public function indexPaginationAction()
    {
      $filter = $this->getFilterPage();

      $camposFilter = [
          '0' => [
              'filter' => "DATE(banca_examinadora.dt_banca) LIKE STR_TO_DATE(?, '%d/%m/%Y') ",
          ],
          '1' => NULL,
      ];

      $paginator = $this->service->getBancaExaminadoraPaginator($filter, $camposFilter);

      $paginator->setItemCountPerPage($paginator->getTotalItemCount());

      $countPerPage = $this->getCountPerPage(
          current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
          );

      $paginator->setItemCountPerPage($this->getCountPerPage(
          current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
          ))->setCurrentPageNumber($this->getCurrentPage());

          $viewModel = new ViewModel([
              'service' => $this->service,
              'form' => $this->form,
              'paginator' => $paginator,
              'filter' => $filter,
              'countPerPage' => $countPerPage,
              'camposFilter' => $camposFilter,
              'controller' => $this->params('controller'),
              'atributos' => array()
          ]);

          return $viewModel->setTerminal(TRUE);
    }

    public function gravarAction() {
      try {
          $controller = $this->params('controller');
          $request = $this->getRequest();
          $service = $this->service;
          $form = $this->form;

          if (!$request->isPost()) {
              throw new \Exception('Dados Inv�lidos');
          }

          $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

          $files = $request->getFiles();
          $upload = $this->uploadFile($files);

          $post = array_merge($post, $upload);

          if (isset($post['id']) && $post['id']) {
              $post['id'] = Cript::dec($post['id']);
          }

          #################################################################
          # Customizaçao dos Valores antes de gravar no banco
          $post['dt_banca'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_banca']);
          #################################################################

          $form->setData($post);

          if (!$form->isValid()) {
              $this->addValidateMessages($form);
              $this->setPost($post);
              $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
              return false;
          }

          $service->exchangeArray($form->getData());
          $this->addSuccessMessage('Registro Alterado com sucesso');
          $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
          return $service->salvar();

      } catch (\Exception $e) {

          $this->setPost($post);
          $this->addErrorMessage($e->getMessage());
          $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
          return false;
      }
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
}
