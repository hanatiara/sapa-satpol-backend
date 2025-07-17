<?php
namespace App\Services;

use App\Models\Laporan;

interface LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data);

    public function update(Laporan $laporan, array $data);
}
