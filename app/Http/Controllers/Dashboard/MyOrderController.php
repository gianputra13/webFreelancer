<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Pesan;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashbaord\MyOrder\UpdateMyOrderRequest;
use App\Http\Requests\Dashbaord\Service\UpdateServiceRequest;
use App\Models\Tagline;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Pesan::where('freelancer_id', Auth::user()->id)->get();
        return view('pages.Dashboard.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pesan $order)
    {
        $service = Service::where('id', $order['service_id'])->first();

        $advantage_service = AdvantageService::where('service_id', $order['service_id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $order['service_id'])->get();
        $thumbnail = ThumbnailService::where('service_id', $order['service_id'])->get();
        $tagline = Tagline::where('service_id', $order['service_id'])->get();

        return view('pages.Dashboard.order.detail', compact('order','service', 'advantage_service', 'advantage_user', 'thumbnail', 'tagline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesan $order)
    {
        return view('pages.Dashboard.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyOrderRequest $request, Pesan $order)
    {
        $data = $request->all();

        dd($data);
        if(isset($data['file'])){
            $data['file'] = $request->file('file')->store(
                'assets/order/attachment', 'public'
            );
        }

        $order = Pesan::find($order->id);
        $order->file = $data['file'];
        $order->note = $data['note'];
        $order->save();

        toast()->success('Submmit order has been success');
        return redirect()->route('member.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }

    public function accepted($id){
        $order = Pesan::find($id);
        $order->pesan_status_id = 2;
        $order->save();

        toast()->success('Accept Order has been success');
        return back();
    }

    public function rejected($id){
        $order = Pesan::find($id);
        $order->pesan_status_id = 3;
        $order->save();

        toast()->success('Reject Order has been success');
        return back();
    }
}
