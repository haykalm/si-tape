<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Event,
    EventImages,
    Yayasan,
};
use RealRashid\SweetAlert\Facades\Alert;
// use DB;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;


class EventController extends Controller
{
    public function __construct()
    {
        // function event_image($id){
        //     $image=EventImages::where('events_id',$id)->first();
        //     return $image->img_file;
        // }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event = DB::table('events as e')
                ->leftJoin('yayasan as y', 'y.id', '=', 'e.yayasan_id')
                // ->leftJoin('event_images as i', 'i.events_id', '=', 'e.id')
                ->select('e.id as id_event','e.event_name','e.event_location','e.date','y.name as yayasan_name')
                ->orderBy('e.id', 'DESC')
                ->WhereNotNull('e.yayasan_id')
                ->get();
        // return $event;
        $yayasan = Yayasan::all();

        return view('event.yayasan.index',['event'=>$event,'yayasan'=>$yayasan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yayasan = Yayasan::all();
        return view('event.yayasan.create',['yayasan'=>$yayasan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_location' => 'required',
            // 'name_file' => 'required|mimes:png,jpeg,jpg|max:2000',
            'date' => 'required'
        ]);
        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }
        }

        $yayasan = Yayasan::where('id', $request->yayasan_id)->first();

        $new_event = new Event;
        $new_event->yayasan_id = $yayasan->id ?? NULL;
        $new_event->event_name = $request->event_name;
        $new_event->event_location = $request->event_location;
        $new_event->date = Carbon::parse($request->date)->format('Y-m-d');
        $new_event->save();

        if ($request->hasfile('name_file')) {
            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $new_event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }


        // return redirect()->route('event.index')->with(Alert::success('Success', 'Data berhasil ditambahkan!'));
        return redirect()->route('event.index')->with('success', 'Successfully Add Data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $image = EventImages::join('events', 'events.id', '=', 'event_images.events_id')
        //         ->WhereNotNull('events.yayasan_id')
        //         ->where('event_images.id',$id)
        //         ->get();
        $image = EventImages::where('events_id', $id)->get();

        return view('event.yayasan.show', ['image' => $image]);        
        // return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = base64_decode($id);
        $event = Event::find($id);
        $oldyayasan = Event::join('yayasan', 'yayasan.id', '=', 'events.yayasan_id')
                            ->where('yayasan.id',$event->yayasan_id)
                            ->select('yayasan.id as id_yayasan','yayasan.name as name_yayasan')
                            ->first();
        $yayasan = Yayasan::select('*')->orderBy('id','DESC')->get();
        $date = Carbon::parse($event->date)->format('m/d/Y');
        return view('event.yayasan.edit',['event' => $event,'yayasan' => $yayasan,'oldyayasan' => $oldyayasan,'date' => $date]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_location' => 'required',
            'date' => 'required'
        ]);
        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }
        }

        $nameimages = EventImages::where('events_id', $id)->get();
        if ($nameimages) {
            foreach ($nameimages as $key => $value) {
               File::delete(public_path().'/files/event/'. $value->name_file);
            }
        }

        $event = Event::where('id', $id)->first();

        $event->yayasan_id = $request->yayasan_id ?? NULL;
        $event->event_name = $request->event_name;
        $event->event_location = $request->event_location;
        $event->date = Carbon::parse($request->date)->format('Y-m-d');
        $event->save();

        if ($request->hasfile('name_file')) {
            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }
        return redirect()->route('event.index')->with('success', 'Successfully Updated Data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);

        $nameimages = EventImages::where('events_id', $id)->get();
        // return $nameimages;
        if ($nameimages) {
            foreach ($nameimages as $key => $value) {
               File::delete(public_path().'/files/event/'. $value->name_file);
            }
        }

        $data = Event::find($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'success deleted data',
                'data' => $data
            ];
            $http_code = 200;

            $data->delete();

            Alert::success('Success', 'Data berhasil dihapus!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to delete data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Data gagal dihapus!');
            return back();
        }
    }

    public function event_internal()
    {
        $event = Event::WhereNull('yayasan_id')->orderBy('id', 'DESC')->get();

        return view('event.internal.index',['event'=>$event]);
    }

    public function create_event_internal()
    {
        return view('event.internal.create');
    }

    public function store_event_internal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_location' => 'required',
            'date' => 'required',
            // 'name_file' => 'required|mimes:png,jpeg,jpg|max:2000',
        ]);
        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all()
            ];
            // foreach ($out as $key => $value) {
                Alert::error('Failed!', $out);
                return back();
            // }
        }

        $new_event = new Event;
        $new_event->yayasan_id = NULL;
        $new_event->event_name = $request->event_name;
        $new_event->event_location = $request->event_location;
        $new_event->date = Carbon::parse($request->date)->format('Y-m-d');
        $new_event->save();

        if ($request->hasfile('name_file')) {
            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $new_event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }

        return redirect()->route('event.internal')->with('success', 'Successfully Add Data.');
    }

    public function edit_event_internal($id)
    {
        $id = base64_decode($id);
        $event = Event::find($id);
        $yayasan = Yayasan::select('*')->orderBy('id','DESC')->get();
        $date = Carbon::parse($event->date)->format('m/d/Y');
        return view('event.internal.edit',['event' => $event,'date' => $date,'yayasan' => $yayasan]);
    }
}
