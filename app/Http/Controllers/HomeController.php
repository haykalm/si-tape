<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{P_Rentan,Yayasan,Pendataan,PendataanHistory,Event,User};
use Carbon\Carbon;

class HomeController extends Controller
{
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

        $Jan = PendataanHistory::whereMonth('pendataan_date', 1)->get()->count();
        $Feb = PendataanHistory::whereMonth('pendataan_date', 2)->get()->count();
        $Mar = PendataanHistory::whereMonth('pendataan_date', 3)->get()->count();
        $Apr = PendataanHistory::whereMonth('pendataan_date', 4)->get()->count();
        $May = PendataanHistory::whereMonth('pendataan_date', 5)->get()->count();
        $Jun = PendataanHistory::whereMonth('pendataan_date', 6)->get()->count();
        $Jul = PendataanHistory::whereMonth('pendataan_date', 7)->get()->count();
        $Aug = PendataanHistory::whereMonth('pendataan_date', 8)->get()->count();
        $Sept = PendataanHistory::whereMonth('pendataan_date', 9)->get()->count();
        $Oct = PendataanHistory::whereMonth('pendataan_date', 10)->get()->count();
        $nov = PendataanHistory::whereMonth('pendataan_date', 11)->get()->count();
        $Dec = PendataanHistory::whereMonth('pendataan_date', 12)->get()->count();
        $data = [$Jan, $Feb, $Mar, $Apr, $May, $Jun, $Jul, $Aug, $Sept, $Oct, $nov, $Dec];

        $Jan_k = Event::whereMonth('created_at', 1)->get()->count();
        $Feb_k = Event::whereMonth('created_at', 2)->get()->count();
        $Mar_k = Event::whereMonth('created_at', 3)->get()->count();
        $Apr_k = Event::whereMonth('created_at', 4)->get()->count();
        $May_k = Event::whereMonth('created_at', 5)->get()->count();
        $Jun_k = Event::whereMonth('created_at', 6)->get()->count();
        $Jul_k = Event::whereMonth('created_at', 7)->get()->count();
        $Aug_k = Event::whereMonth('created_at', 8)->get()->count();
        $Sept_k = Event::whereMonth('created_at', 9)->get()->count();
        $Oct_k = Event::whereMonth('created_at', 10)->get()->count();
        $nov_k = Event::whereMonth('created_at', 11)->get()->count();
        $Dec_k = Event::whereMonth('created_at', 12)->get()->count();
        $data_k = [$Jan_k, $Feb_k, $Mar_k, $Apr_k, $May_k, $Jun_k, $Jul_k, $Aug_k, $Sept_k, $Oct_k, $nov_k, $Dec_k];

        $data = json_encode($data);
        $data_k = json_encode($data_k);

        return view('dashboard',['countdata' => $countdata, 'data' => $data, 'data_k' => $data_k]);
    }
}
