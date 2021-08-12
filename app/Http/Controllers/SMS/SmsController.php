<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Dotenv\Regex\Success;
use Illuminate\Http\Request;
use MessageBird\Client as MessageBird;

class SmsController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $MessageBird = new MessageBird('ZIwAaEaORkZ5zYzuDWPJQHiVo');
        // $messageList = $MessageBird->messages->getList();
        // dd($messageList);
        return view('sms.index');
    }

    public function list()
    {
        $MessageBird = new MessageBird('ZIwAaEaORkZ5zYzuDWPJQHiVo');
        $messageList = $MessageBird->messages->getList(['limit' => 200, 'limit' => 30]);
        // dd($messageList);
        foreach ($messageList->items as $msg) {

            $msg->_id = $msg->getid();
            $msg->created_at = $msg->getCreatedDatetime();
            // dump($msg);
        }
        return response()->json($messageList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('sms.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        // dd($request->phone);
        $recipient = [];
        foreach ($request->phone as $value) {
            array_push($recipient, $value['name']);
        }
        try {
            //code...
            $MessageBird = new \MessageBird\Client('ZIwAaEaORkZ5zYzuDWPJQHiVo');
            $Message = new \MessageBird\Objects\Message();
            $Message->originator = '61448852116';
            $Message->recipients = $recipient;
            // $Message->recipients = $request->phone;
            $Message->body = $request->body;
            $send = $MessageBird->messages->create($Message);

            return response()->json(['status' => 'success', 'message' => 'Message successfully sent']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reply(Request $request)
    {
        // dd($request->all());
        $recipient = [];
        // foreach ($request->phone as $value) {
        array_push($recipient, $request->recipient);
        // }
        // dd($recipient);
        try {
            //code...
            $MessageBird = new \MessageBird\Client('ZIwAaEaORkZ5zYzuDWPJQHiVo');
            $Message = new \MessageBird\Objects\Message();
            $Message->originator = '61448852116';
            $Message->recipients = $recipient;
            // $Message->recipients = $request->phone;
            $Message->body = $request->body;
            $send = $MessageBird->messages->create($Message);

            return response()->json(['status' => 'success', 'message' => 'Message successfully sent']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
