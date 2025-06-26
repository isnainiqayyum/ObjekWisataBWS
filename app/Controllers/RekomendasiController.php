<?php

namespace App\Controllers;

use App\Models\WisataModel;
use App\Models\KriteriaModel;
use App\Models\NilaiAlternatifModel;
use App\Models\SubKriteriaModel;

class RekomendasiController extends BaseController
{
    protected $wisataModel;
    protected $kriteriaModel;
    protected $nilaiModel;
    protected $subKriteriaModel;

    public function __construct()
    {
        $this->wisataModel = new WisataModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->nilaiModel = new NilaiAlternatifModel();
        $this->subKriteriaModel = new SubKriteriaModel();
    }

    // Menampilkan form filter berdasarkan kriteria dan sub-kriteria
    public function filterForm()
    {
        helper('form');

        // Ambil semua data kriteria
        $kriteria = $this->kriteriaModel->findAll();

        // Kelompokkan sub-kriteria berdasarkan kriteria_id
        $subKriteria = [];
        foreach ($kriteria as $k) {
            $subKriteria[$k['nama_kriteria']] = $this->subKriteriaModel
                ->where('kriteria_id', $k['id'])
                ->findAll();
        }

        return view('rekomendasi/index', [
            'kriteria' => $kriteria,
            'subKriteria' => $subKriteria
        ]);
    }

    // Proses rekomendasi berdasarkan input filter
    public function index()
    {
        // Ambil input sub_kriteria dari form
        $subKriteriaInput = $this->request->getPost('sub_kriteria');
        //$dd($subKriteriaInput);

        // Ratakan array input sub-kriteria (jika ada yang array dalam array)
        $selectedSubKriteriaIds = [];
        foreach ($subKriteriaInput as $value) {
            if (is_array($value)) {
                $selectedSubKriteriaIds = array_merge($selectedSubKriteriaIds, $value);
            } else {
                $selectedSubKriteriaIds[] = $value;
            }
        }
        //$dd($selectedSubKriteriaIds);

        // Ambil sub_kriteria_id untuk kriteria "Jenis Wisata"
        $jenisWisataSubIds = $this->subKriteriaModel
            ->select('sub_kriteria.id')
            ->join('kriteria', 'kriteria.id = sub_kriteria.kriteria_id')
            ->where('kriteria.nama_kriteria', 'Jenis Wisata')
            ->findAll();

        $jenisWisataIds = array_column($jenisWisataSubIds, 'id');
        $jenisYangDipilih = array_intersect($selectedSubKriteriaIds, $jenisWisataIds);
        //$dd($jenisYangDipilih);

        // Filter data wisata berdasarkan jenis wisata yang dipilih
        $wisataFiltered = $this->wisataModel
            ->whereIn('sub_kriteria_id', $jenisYangDipilih)
            ->findAll();
        //$dd($wisataFiltered);

        if (empty($wisataFiltered)) {
            return view('rekomendasi/hasil', ['result' => [], 'message' => 'Tidak ditemukan wisata sesuai filter']);
        }

        // Ambil ID wisata yang lolos filter
        $wisataIds = array_column($wisataFiltered, 'id');

        // Ambil nilai alternatif untuk setiap wisata dan sub_kriteria-nya
        $db = \Config\Database::connect();
        $builder = $db->table('nilai_alternatif na');
        $builder->select('na.wisata_id, sk.kriteria_id, na.nilai');
        $builder->join('sub_kriteria sk', 'na.sub_kriteria_id = sk.id');
        $builder->whereIn('na.wisata_id', $wisataIds);

        if (!empty($selectedSubKriteriaIds)) {
            $builder->whereIn('na.sub_kriteria_id', $selectedSubKriteriaIds);
        }

        $rows = $builder->get()->getResultArray();
        //$dd($rows);

        // Hitung nilai rata-rata per kriteria untuk setiap wisata
        $nilaiSementara = [];
        foreach ($rows as $row) {
            $kriteriaId = $row['kriteria_id'];
            $nilaiSementara[$row['wisata_id']][$kriteriaId][] = $row['nilai'];
        }

        $nilaiAlternatif = [];
        foreach ($nilaiSementara as $wisataId => $kriteriaArray) {
            foreach ($kriteriaArray as $kriteriaId => $nilaiList) {
                $avg = array_sum($nilaiList) / count($nilaiList);
                $nilaiAlternatif[$wisataId][$kriteriaId] = $avg;
            }
        }
        //$dd($nilaiAlternatif);

        // Hitung hasil SAW (Simple Additive Weighting)
        $hasil = $this->hitungSAW($nilaiAlternatif);
        arsort($hasil); // Urutkan dari skor tertinggi
        $top3 = array_slice($hasil, 0, 3, true);
        //$dd($top3);

        // Ambil data wisata berdasarkan 3 skor tertinggi
        $result = [];
        foreach ($top3 as $wisataId => $score) {
            $wisata = $this->wisataModel->find($wisataId);
            $result[] = [
                'wisata' => $wisata,
                'score' => $score,
            ];
        }
        //$dd($result);

        return view('rekomendasi/hasil', compact('result'));
    }

    // Fungsi perhitungan metode SAW
    protected function hitungSAW(array $nilaiAlternatif): array
    {
        $kriteriaList = $this->kriteriaModel->findAll();
        $bobot = [];
        $tipe = [];
        $skipKriteriaIds = [];

        // Siapkan bobot dan tipe kriteria, kecuali "Jenis Wisata" yang di-skip
        foreach ($kriteriaList as $k) {
            if ($k['nama_kriteria'] === 'Jenis Wisata') {
                $skipKriteriaIds[] = $k['id'];
                continue;
            }
            $bobot[$k['id']] = floatval($k['bobot']);
            $tipe[$k['id']] = $k['type']; // benefit atau cost
        }

        // Hitung nilai max dan min untuk normalisasi
        $maxPerKriteria = [];
        $minPerKriteria = [];

        foreach ($nilaiAlternatif as $wisataId => $kriteriaNilai) {
            foreach ($kriteriaNilai as $kriteriaId => $nilai) {
                if (in_array($kriteriaId, $skipKriteriaIds)) continue;

                $maxPerKriteria[$kriteriaId] = max($maxPerKriteria[$kriteriaId] ?? $nilai, $nilai);
                $minPerKriteria[$kriteriaId] = min($minPerKriteria[$kriteriaId] ?? $nilai, $nilai);
            }
        }

        // Hitung skor akhir SAW untuk setiap wisata
        $hasil = [];
        foreach ($nilaiAlternatif as $wisataId => $kriteriaNilai) {
            $total = 0;
            foreach ($kriteriaNilai as $kriteriaId => $nilai) {
                if (in_array($kriteriaId, $skipKriteriaIds)) continue;

                $max = $maxPerKriteria[$kriteriaId] ?? 1;
                $min = $minPerKriteria[$kriteriaId] ?? 0;

                // Normalisasi nilai
                $normalized = ($tipe[$kriteriaId] === 'benefit') ? $nilai / $max : $min / $nilai;

                // Akumulasi skor
                $total += $normalized * ($bobot[$kriteriaId] ?? 0);
            }
            $hasil[$wisataId] = $total;
        }
        //$dd($hasil);

        return $hasil;
    }
}