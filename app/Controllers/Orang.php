<?php

namespace App\Controllers;

use \App\Models\OrangModel;

class Orang extends BaseController
{
    //contoh membuat construct agar dapat di akses oleh turunan nya

    protected $orangModel;
    public function __construct()
    {
        $this->orangModel = new OrangModel();
    }
    //end
    public function index()
    {
        // d($this->request->getVar('keyword'));
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $orang = $this->orangModel->search($keyword);
        } else {
            $orang = $this->orangModel;
        }
        $current_page = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;
        $data = [
            'title' => 'Daftar Orang | Learn CI',
            'orang' => $orang->paginate(6, 'orang'),
            'pager' => $this->orangModel->pager,
            'current_page' => $current_page
        ];

        return view('orang/index', $data);
    }
}
