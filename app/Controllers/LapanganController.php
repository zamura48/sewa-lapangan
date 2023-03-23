<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Lapangan;

class LapanganController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Lapangan();
    }

    public function index()
    {
        session();
        return view('admin/lapangan/index', ['datas' => $this->model->findAll()]);
    }

    public function store()
    {
        // $this->model->setValidationRule('gambar', 'required|uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,png,jpg,jpeg]');
        $validationRules = $this->model->getValidationRules();
        $validationMessages = $this->model->getValidationMessages();
        
        $validationRules['gambar'] = 'uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,png,jpg,jpeg]';
        $validationMessages['gambar'] = [
            'required' => 'Gambar tidak boleh kosong',
            'ext_in' => 'Format gambar tidak sesuai',
            'max_size' => 'Ukurat gambar maximal 4MB',
        ];
        
        if (!$this->validate($validationRules, $validationMessages)) {

            $validation = \Config\Services::validation();

            session();
            return redirect()->to(base_url('admin/lapangan'))->with('validation', $validation->getErrors());
        }

        $imageFile = $this->request->getFile('gambar');
        $nameFile = time().'_'.$imageFile->getClientName();
        $imageFile->move(FCPATH.'uploads/image/' . 'lapangan', $nameFile);

        $this->model->save([
            'nomor' => $this->request->getVar('nomor'),
            'gambar' => $nameFile,
            'status' => "1"
        ]);

        return redirect()->to(base_url('admin/lapangan'))->with('success', "Berhasil menambah data lapangan!");
    }

    public function update($id)
    {
        $validationRules = $this->model->getValidationRules();
        $validationMessages = $this->model->getValidationMessages();

        $data = [
            'nomor' => $this->request->getVar('nomor'),
            'status' => "1"
        ];

        $imageFile = $this->request->getFile('gambar');
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $validationRules['gambar'] = 'uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,png,jpg,jpeg]';
            $validationMessages['gambar'] = [   
                'ext_in' => 'Format gambar tidak sesuai',
                'max_size' => 'Ukurat gambar maximal 1MB',
            ];

            if (!$this->validate($validationRules, $validationMessages)) {
                $validation = \Config\Services::validation();
                
                session();
                return redirect()->to(base_url('admin/lapangan'))->with('validation', $validation->getErrors());
            }
            
            $imageFile = $this->request->getFile('gambar');
            $nameFile = time().$imageFile->getClientName();
            $imageFile->move(WRITEPATH . 'uploads', $nameFile);
            
            $data['gambar'] = $nameFile;
            
            $this->model->update($id, $data);
        } 

        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();
            
            session();
            return redirect()->to(base_url('admin/lapangan'))->with('validation', $validation->getErrors());
        }
        
        $this->model->update($id, $data);

        return redirect()->to(base_url('admin/lapangan'))->with('success', "Berhasil memperbarui data lapangan");
    }

    public function destroy($id)
    {
        $this->model->where('lapangan_id', $id)->delete();
        
        return redirect()->to(base_url('admin/lapangan'))->with('success', "Berhasil menghapus data lapangan");
    }

    
}