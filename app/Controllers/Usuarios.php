<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\Base\CrudController;
use App\Models\UserModel;


class Usuarios extends CrudController
{
    protected $model;
    protected $fields = ['matricula','nome','email','permissao','cpf','ativo']; //corresponde aos campos que serão trabalhados
    protected array $formFields = [
         [
            'name'  => 'matricula',
            'label' => 'Matricula',
            'type'  => 'text',
            'required' => true
        ],
        [
            'name'  => 'nome',
            'label' => 'Nome',
            'type'  => 'text',
            'required' => true
        ],
        [
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email',
            'required' => true
        ],
        [
            'name'  => 'cpf',
            'label' => 'CPF',
            'type'  => 'text'
        ],
        [
            'name'  => 'permissao',
            'label' => 'Permissão',
            'type'  => 'select',
            'options' => [
                'admin'   => 'Administrador',
                'usuario' => 'User'
            ]
        ],
        [
            'name'  => 'ativo',
            'label' => 'Ativo',
            'type'  => 'select',
            'options' => [
                1 => 'Sim',
                0 => 'Não'
            ]
        ]
    ];

    protected $datatableColumns = [
        ['data' => 'id', 'title' => 'ID'],
        ['data' => 'matricula', 'title' => 'matricula'],
        ['data' => 'nome', 'title' => 'Nome'],
        ['data' => 'email', 'title' => 'Email'],
        ['data' => 'permissao', 'title' => 'Permissão'],
        ['data' => 'cpf', 'title' => 'CPF'],
        ['data' => 'ativo', 'title' => 'Ativo'],
    ];

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function datatable()
    {
        $request = service('request');
        $model   = new \App\Models\UserModel();

        $draw   = (int) $request->getGet('draw');
        $start  = (int) $request->getGet('start');
        $length = (int) $request->getGet('length');

        $search = $request->getGet('search')['value'] ?? '';

        $builder = $model->builder();

        // total sem filtro
        $recordsTotal = $builder->countAllResults(false);

        // filtro de busca
        if ($search) {
            $builder
                ->groupStart()
                ->like('nome', $search)
                ->orLike('email', $search)
                ->orLike('matricula', $search)
                ->orLike('cpf', $search)
                ->groupEnd();
        }

        $recordsFiltered = $builder->countAllResults(false);

        $data = $builder
            ->limit($length, $start)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
    }


    public function index()
    {
        return view('crud/index', [
            'title'    => 'Usuários',
            'endpoint' => 'usuarios',
            'columns'  => $this->datatableColumns,
            'formFields' => $this->formFields
        ]);
    }
}
