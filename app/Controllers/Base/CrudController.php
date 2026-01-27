<?php

namespace App\Controllers\Base;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

abstract class CrudController extends BaseController
{
    protected $model;
    protected $fields = [];
    protected $datatableColumns = [];
    
    public function index()
    {
        return view('crud/index', ['columns' => $this->datatableColumns, 'endpoint' => base_url($this->request->getUri()->getPath())]);
    }
    //===========
    public function datatable()
    {
        $request = service('request');

        $draw   = $request->getGet('draw');
        $start  = $request->getGet('start');
        $length = $request->getGet('length');

        $total = $this->model->countAllResults(false);

        $data = $this->model
            ->limit($length, $start)
            ->find();

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }
    public function save()
    {
        $data = $this->request->getPost();

        $this->model->save($data);

        return $this->response->setJSON(['success' => true]);
    }


    public function edit($id)
    {
        return $this->response->setJSON(
            $this->model->find($id)
        );
    }

    public function delete($id)
    {
        if (!$id) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'ID inválido']);
        }

        $registro = $this->model->find($id);

        if (!$registro) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['success' => false, 'message' => 'Registro não encontrado']);
        }

        $this->model->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Registro removido com sucesso'
        ]);
    }
}
