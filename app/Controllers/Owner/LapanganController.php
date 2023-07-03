<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Lapangan;

class LapanganController extends BaseController
{
    protected $modelLapangan;

    public function __construct()
    {
        $this->modelLapangan = new Lapangan();
    }
    
    public function index()
    {
        return view('owner/lapangan/index', [
            'title' => "Lapangan",
            'datas' => $this->modelLapangan->getLapanganWithJadwal(),
        ]);
    }

    public function update($id)
    {
        $validationRules = $this->modelLapangan->getValidationRules();
        $validationMessages = $this->modelLapangan->getValidationMessages();

        // $imageFile = $this->request->getFile('gambar');
        // if ($imageFile->isValid() && !$imageFile->hasMoved()) {
        //     $validationRules['gambar'] = 'uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,png,jpg,jpeg]';
        //     $validationMessages['gambar'] = [   
        //         'ext_in' => 'Format gambar tidak sesuai',
        //         'max_size' => 'Ukurat gambar maximal 1MB',
        //     ];

        //     if (!$this->validate($validationRules, $validationMessages)) {
        //         $validation = \Config\Services::validation();
                
        //         session();
        //         return redirect()->to(base_url('admin/lapangan'))->with('validation', $validation->getErrors());
        //     }
            
        //     $imageFile = $this->request->getFile('gambar');
        //     $nameFile = time().$imageFile->getClientName();
        //     $imageFile->move(WRITEPATH . 'uploads', $nameFile);
            
        //     $data['gambar'] = $nameFile;
            
        //     $this->model->update($id, $data);
        // } 

        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();
            
            session();
            return redirect()->to(base_url('admin/lapangan'))->with('validation', $validation->getErrors());
        }

        $data = [
            'nomor' => $this->request->getVar('nomor'),
            'status' => $this->request->getVar('status')
        ];
        
        $this->modelLapangan->update($id, $data);

        return redirect()->to(base_url('owner/lapangan'))->with('success', "Berhasil memperbarui data lapangan");
    }
}
