<?php

namespace App\Http\Controllers;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\invoices;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function __construct()
    {
        $this->middleware('permission:الاشعارات', ['only' => ['markAsread_all,markAsread']]);
    }
    public function index()
    {
        $invoices_count = invoices::count();
        $invoices_count_1 =  invoices::where('value_status',1)->count();
        $invoices_count_2 =  invoices::where('value_status',2)->count();
        $invoices_count_3 =  invoices::where('value_status',3)->count();
        $n_1 = $invoices_count == 0 ? 0 : round($invoices_count_1 / $invoices_count * 100,0);
        $n_2 = $invoices_count == 0 ? 0 : round($invoices_count_2 / $invoices_count * 100,0);
        $n_3 = $invoices_count == 0 ? 0 : round($invoices_count_3 / $invoices_count * 100,0);

            $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 250])
            ->labels(['الفواتير المدفوعة جزئيا','الفواتير الغير مدفوعة','الفواتير المدفوعة'])
            ->datasets([
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#F57738'],
                    'data' => [$n_3]
                ],
                [
                    "label" => "الفواتير الغير مدفوعة",
                    'backgroundColor' => ['#F8506C'],
                    'data' => [$n_2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#10A373'],
                    'data' => [$n_1]
                ]

            ])
            ->options([]);

            $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#F8506C', '#10A373','#F57738'],
                    'data' => [$n_2,$n_1,$n_3]
                ]
            ])
            ->options([]);

            return view('home',compact('chartjs','chartjs_2'));
    }
    //  notifications
    public function markAsread_all(){
        $notf = auth()->user()->unreadNotifications;
        if($notf){
            $notf->markAsRead();
            return back();
        }
    }
    public function markAsread($id){
        // $a= DatabaseNotification::where("data['id']",$id)->first();
        $id_not = DB::table('notifications')->where('data->id',$id)->pluck('id');
        DB::table('notifications')->where('id',$id_not)->update(['read_at'=>now()]);

        return redirect("/invoicesdetalis/$id");
    }
}
