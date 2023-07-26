<?php

namespace App\Controllers;

use \App\Models\KomikModel;

class Komik extends BaseController
{
    //contoh membuat construct agar dapat di akses oleh turunan nya
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    //end
    public function index()
    {
        $data = [
            'title' => 'Daftar Komik | Learn CI',
            'komik' => $this->komikModel->getKomik()
        ];

        return view('komik/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        //handler untuk mengatasi data komik jika kosong
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        //pengiriman data ke create
        $data = [
            'title' => 'Form Tambah Data Komik',
        ];
        return view('komik/create', $data);
    }

    public function save()
    {
        $rulesSet = [
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong.',
                    'is_unique' => 'Judul tidak boleh sama.'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penulis tidak boleh kosong.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerbit tidak boleh kosong.'
                ]
            ],
            'sampul' => [
                'label' => 'Image File',
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal sampul adalah 1MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];
        //komikValidation app\Config\Validation.php
        //validation input
        if (!$this->validate($rulesSet)) {
            //membuat session ceklis
            session()->setFlashdata('cekList', 'Cek list form');
            //withInput aktif jika session() telah di panggil > dan session() diset app\Controllers\BaseController.php
            return redirect()->back()->withInput();
        }
        //mengambil file upload
        $fileSampul = $this->request->getFile('sampul');
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            //generate random name
            $namaSampul = $fileSampul->getRandomName();
            //mengcopy file upload
            $fileSampul->move('img', $namaSampul);
            //mengambil nama file upload
            // $namaSampul = $fileSampul->getName();
        }
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        return redirect()->to('komik/');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);
        //hapus gambar
        if ($komik['sampul'] != 'default.jpg') {
            unlink('img/' . $komik['sampul']);
        }
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('komik/');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }

    public function update($id)
    {
        d($this->request->getVar('slug'));
        //cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        $slugBaru = url_title($this->request->getVar('judul'), '-', true);
        // d($komikLama['slug']);
        // d($slugBaru);
        if ($komikLama['slug'] == $slugBaru) {
            $rule_judul = 'required';
            $eror_judul = [
                'required' => 'Judul tidak boleh kosong.'
            ];
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
            $eror_judul = [
                'required' => 'Judul tidak boleh kosong.',
                'is_unique' => 'Judul tidak boleh sama.'
            ];
        }
        // d($this->request->getVar('judul'));
        // dd($rule_judul);
        //set rules
        $rules = [
            'judul' => [
                'rules' => $rule_judul,
                'errors' => $eror_judul
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penulis tidak boleh kosong.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerbit tidak boleh kosong.'
                ]
            ],
            'sampul' => [
                'label' => 'Image File',
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal sampul adalah 1MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];
        //validation input
        if (!$this->validate($rules)) {
            // Jika validasi gagal, ambil pesan validasi dari pustaka validasi
            return redirect()->to('/komik/edit/' . $komikLama['slug'])->withInput();
        }
        $fileSampul = $this->request->getFile('sampul');
        //mengambil file upload
        if ($fileSampul->getError() == 4) {
            $namaSampul = $komikLama['sampul'];
        } else {
            $namaSampul = $fileSampul->getName();
            if ($namaSampul != $komikLama['sampul']) {
                if ($komikLama['sampul'] != 'default.jpg') {
                    unlink('img/' . $komikLama['sampul']);
                }
                //generate random name
                $namaSampul = $fileSampul->getRandomName();
                //mengcopy file upload
                $fileSampul->move('img', $namaSampul);
            } else {
                $namaSampul = $komikLama['sampul'];
            }
        }
        // d($namaSampul);
        // dd($komikLama['sampul']);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slugBaru,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('komik/');
    }
}
