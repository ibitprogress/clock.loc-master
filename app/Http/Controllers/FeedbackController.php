<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Jobs\SendNotificationEmail;
use Illuminate\Http\Request;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Feedback::orderBy('revised', 'asc')->latest()->get()->toJson();
        return view('admin.feedbacksTable')->with(['data' => $data, 'title' => "Зворотній зв'язок"]);
    }

    public function oldFeedbacks()
    {
        return ('oldFeedbacks');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Helpers\SendMail  $mail
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedback = Feedback::create([
            'first_name' => $request->input('firstName'),
            'phone' => $request->input('phone'),
            'revised' => false
        ]);
        if (!$feedback) return response()->json(['error' => 'Creation Feedback'], 500);

        dispatch(new SendNotificationEmail($feedback));
        return response()->json('Created', 201);
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
        $revised = $request->input('revised');
        if (isset($revised)) {
            $revised = boolval($revised);
            $order = Feedback::find($id);
            $order->revised = $revised;
            $order->save();

            if ($request->ajax()){
                $data = Feedback::orderBy('revised', 'asc')->latest()->get()->toJson();
                return $data;
            }
            return $this->index();

        } else
            return response()->json(["error" => "Невірні вхідні дані"], 403);
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
}
