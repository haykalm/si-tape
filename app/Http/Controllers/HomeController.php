<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    P_Rentan,
    Yayasan,
    Pendataan,
    PendataanHistory,
    Event,
    User,
};
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $month = Carbon::now()->format('m');

        $pendataan_month_now = PendataanHistory::whereMonth('pendataan_date',$month)->get()->count();

        $total_all_pr = P_Rentan::all()->count();

        $total_disabilitas = P_Rentan::where('kategori_pr_id', 3)->get()->count();

        $total_napi = P_Rentan::where('kategori_pr_id', 4)->get()->count();

        $total_transgender = P_Rentan::where('kategori_pr_id', 5)->get()->count();

        $total_odgj = P_Rentan::where('kategori_pr_id', 1)->get()->count();

        $total_panti_asuhan = P_Rentan::where('kategori_pr_id', 2)->get()->count();

        $total_yayasan = Yayasan::all()->count();

        $total_kegiatan_i = Event::WhereNull('yayasan_id')->get()->count();

        $total_kegiatan_y = Event::WhereNotNull('yayasan_id')->get()->count();

        $total_kegiatan = Event::all()->count();

        $total_pengguna = User::all()->count();

        $countdata = [
            'pendataanmounthnow' => $pendataan_month_now,
            'all_pr' => $total_all_pr,
            'disabilitas' => $total_disabilitas,
            'napi' => $total_napi,
            'transgender' => $total_transgender,
            'odgj' => $total_odgj,
            'panti_asuhan' => $total_panti_asuhan,
            'yayasan' => $total_yayasan,
            'kegiatan_i' => $total_kegiatan_i,
            'kegiatan_y' => $total_kegiatan_y,
            'kegiatan' => $total_kegiatan,
            'pengguna' => $total_pengguna
        ];

        // return 'testing login';
        return view('dashboard',['countdata' => $countdata]);
    }
}
