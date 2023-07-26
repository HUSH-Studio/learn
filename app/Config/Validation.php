<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $komikValidation = [
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
            'rules' => 'uploaded[sampul]|max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded' => 'Sampul tidak boleh kosong.',
                'max_size' => 'Ukuran maksimal sampul adalah 1MB.',
                'is_image' => 'File harus berupa gambar.',
                'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
            ]
        ]
    ];
}
