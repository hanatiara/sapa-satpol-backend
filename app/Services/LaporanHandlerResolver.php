<?php
namespace App\Services;

use App\Services\Handlers\LaporanKransosHandler;
use App\Services\Handlers\LaporanPamwalHandler;
use App\Services\Handlers\LaporanPengamananHandler;
use App\Services\Handlers\LaporanPerizinanHandler;
use App\Services\Handlers\LaporanPiketHandler;
use App\Services\Handlers\LaporanPklHandler;
use App\Services\Handlers\LaporanReklameHandler;

class LaporanHandlerResolver
{
    protected $handlers = [
        'kransos' => LaporanKransosHandler::class,
        'pamwal' => LaporanPamwalHandler::class,
        'pengamanan' => LaporanPengamananHandler::class,
        'perizinan' => LaporanPerizinanHandler::class,
        'piket' => LaporanPiketHandler::class,
        'pkl' => LaporanPklHandler::class,
        'reklame' => LaporanReklameHandler::class,

    ];

    public function resolveByType(string $type): LaporanHandlerInterface
    {
    if (!isset($this->handlers[$type])) {
        throw new \Exception("Unknown laporan type: {$type}");
    }

    return app($this->handlers[$type]);
    }

}
