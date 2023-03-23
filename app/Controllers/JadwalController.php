<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\Lapangan;

class JadwalController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Jadwal();
        session();
    }

    public function index()
    {
        $modelJam = new Jam();
        $modelLapangan = new Lapangan();
        // dd($this->model->getJadwalWithLapanganAndJams());

        return view('admin/jadwal/index', [
            'datas' => $this->model->findAll(),
            'dataJams' => $modelJam->findAll(),
            'dataLapangans' => $modelLapangan->findAll()
        ]);
    }

    public function store()
    {        
        $modelJam = new Jam();

        $validationRules = $this->model->getValidationRules(['except' => ['status_booking']]);
        $validationMessages = $this->model->getValidationMessages();

        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();

            return redirect()->to(base_url('admin/jadwal'))->with('validation', $validation->getErrors());
        }

        $modelJam->save(['jam' => $this->request->getVar('id_jam')]);

        $this->model->save([
            'id_jam' => $modelJam->getInsertID(),
            'id_lapangan' => $this->request->getVar('id_lapangan'),
            'tanggal' => $this->request->getVar('tanggal'),
            'harga' => $this->request->getVar('harga'),
            'status_booking' => 0,
        ]);

        return redirect()->to(base_url('admin/jadwal'))->with('success', "Berhasil menambah data jadwal!");
    }

    public function update($id)
    {
        $validationRules = $this->model->getValidationRules(['except' => ['id_jam', 'id_lapangan']]);
        $validationMessages = $this->model->getValidationMessages();

        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();

            return redirect()->to(base_url('admin/jadwal'))->with('validation', $validation->getErrors());
        }

        $this->model->update($id, [
            'id_jam' => 1,
            'id_lapangan' => 1,
            'tanggal' => $this->request->getVar('tanggal'),
            'harga' => $this->request->getVar('harga'),
            'status_booking' => "booking",
        ]);

        return redirect()->to(base_url('admin/jadwal'))->with('success', "Berhasil memperbarui data jadwal!");
    }
    
    public function destroy($id)
    {
        $this->model->where('jadwal_id', $id)->delete();
        
        return redirect()->to(base_url('admin/jadwal'))->with('success', "Berhasil menghapus data jadwal!");
    }

    public function indexJadwal()
    {
        return view('pelanggan/jadwal/index', [
            'datas' => $this->model->getJadwalWithLapanganAndJams()
        ]);
    }

    // Pelanggan Method
    public function getLapanganExist()
    {
        $tanggal = $this->request->getVar('tanggal');
        $jamMulai = $this->request->getVar('jamMulai');
        $jamAkhir = $this->request->getVar('jamAkhir');

        return view('pelanggan/pesanlapangan/index', [
            'title' => ' | Pesan Lapangan',
            'datas' => $this->model->getJadwalLapanganExit($tanggal, $jamMulai, $jamAkhir)
        ]);
    }
}
