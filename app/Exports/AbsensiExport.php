<?php

namespace App\Exports;

use App\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AbsensiExport implements FromView
{
	use Exportable;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($absensi)
    {
        $this->absensi = $absensi;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	// View
    	return view('absensi/admin/excel', [
    		'absensi' => $this->absensi
    	]);
    }
}
