<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use App\Models\User;

class UserController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $data = $this->model->findAll();

        return view('');
    }

    public function profil()
    {
        return view('pelanggan/profil/index', [
            'title' => ' | Profil',
            'data' => $this->model->getProfile(session('username'))
        ]);
    }

    public function updateProfil()
    {
        $modelUser = $this->model;
        $modelPelanggan = new Pelanggan();
        $dataUser = $modelUser->where('username', session('username'))->first();

        $validationRules = $modelPelanggan->getValidationRules();
        $validationMessages = $modelPelanggan->getValidationMessages();

        $validationRules['email'] = 'required|valid_email';
        $validationMessages['email'] = [
            'required' => 'Email tidak boleh kosong',
            'email' => 'Format email salah',
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();

            return redirect()->to(base_url('pelanggan/profil/' . session('username')))->with('validation', $validation->getErrors());
        }

        $modelUser->update($dataUser['user_id'], [
            'email' => $this->request->getVar('email'),
        ]);

        $modelPelanggan->update($dataUser['user_id'], [
            'nama' => $this->request->getVar('nama'),
            'noHp' => $this->request->getVar('noHp'),
            'alamat' => $this->request->getVar('alamat')
        ]);

        $oldPassword = $this->request->getVar('passwordLama');
        if ($oldPassword || $this->request->getVar('password')) {
            if (!password_verify($oldPassword, $dataUser['password'])) {
                return redirect()->to(base_url('pelanggan/profil/' . session('username')))->with('errors', "Password lama salah");
            } else {
                $validationRulePassword = $modelUser->getValidationRules(['only' => ['password']]);
                $validationRulePassword['pass_confirm'] = 'required_with[password]|matches[password]';
                $validationMessagePassword['pass_confirm'] = [
                    'required_with' => 'Konfirmasi Password tidak boleh kosong',
                    'matches' => "Konfirmasi Password tidak sama dengan Password"
                ];
    
                if (!$this->validate($validationRulePassword, $validationMessagePassword)) {
                    $validation = \Config\Services::validation();
    
                    return redirect()->to(base_url('pelanggan/profil/' . session('username')))->with('validation', $validation->getErrors());
                }
    
                $modelUser->update($dataUser['user_id'], [
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                ]);
            }
        }

        return redirect()->to(base_url('pelanggan/profil/' . session('username')))->with('success', 'Berhasil memperbarui data pengguna.');
    }

    public function updateFoto()
    {
        $imageFile = $this->request->getFile('foto');
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $validationRules = ['uploaded[foto]|max_size[foto,1024]|ext_in[foto,png,jpg,jpeg]'];
            $validationMessages = [   
                'ext_in' => 'Format gambar tidak sesuai',
                'max_size' => 'Ukuran gambar maximal 1MB',
            ];

            if (!$this->validate($validationRules, $validationMessages)) {
                $validation = \Config\Services::validation();
                
                session();
                return redirect()->to(base_url('pelanggan/profil/'.session('username')))->with('validation', $validation->getErrors());
            }
        
            $nameFile = time().$imageFile->getClientName();
            $imageFile->move(FCPATH.'uploads/profil', $nameFile);
            
            $modelPelanggan = new Pelanggan();
            $idPelanggan = $this->model->getIdPelanggan(session('username'));
            $modelPelanggan->update($idPelanggan, ['foto' => $nameFile]);

            session()->set('foto', $nameFile);
            
            return redirect()->to(base_url('pelanggan/profil/'.session('username')))->with('success', 'Berhasil memperbarui foto.');
        } else {
            return redirect()->to(base_url('pelanggan/profil/'.session('username')))->with('errors', 'Gagal memperbarui foto.');
        }

    }

}