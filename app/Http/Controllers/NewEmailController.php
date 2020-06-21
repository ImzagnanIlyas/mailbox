<?php

namespace App\Http\Controllers;

use App\Email;
use App\User;
use App\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class NewEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            User::all()
        );
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = Email::Create([
            'user_id' => Auth::user()->id,
            'send' => now(),
        ]);
        $user_email = UserEmail::Create([
            'user_id' => Auth::user()->id,
            'email_id' => $email->id,
            'user_type' => 'sender',
            'state' => 'draft',
        ]);
        return response()->json([$email, $user_email]);
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
        $email = Email::find($id);

        $email->receivers = ($request->receivers) ? json_encode($request->receivers) : null;
        $email->cc = ($request->cc) ? json_encode($request->cc) : null;
        $email->object = $request->object;
        $email->content = $request->content;

        if ($request->fonction == 'send') {
            $tab = [];
            if($request->hasfile('attachments')){
                foreach($request->attachments as $file){
                    $object = new stdClass;
                    $object->path = $file->storeAs('files', $file->getClientOriginalName());
                    $object->name = $file->getClientOriginalName();
                    $object->type = $file->extension(); // or ->getMimeType()
                    $object->size = $file->getSize();
                    array_push($tab, $object);
                }
                $email->files = json_encode($tab);
            }
            $email->send = now();
            $email->save();

            $user_email = UserEmail::find($request->user_email);
            $user_email->state = 'sent';
            $user_email->save();

            if($request->receivers){
                foreach ($request->receivers as $value) {
                    UserEmail::Create([
                        'user_id' => $value,
                        'email_id' => $email->id,
                        'user_type' => 'receiver',
                        'state' => 'received',
                    ]);
                }
            }
            if($request->cc){
                foreach ($request->cc as $value) {
                    UserEmail::Create([
                        'user_id' => $value,
                        'email_id' => $email->id,
                        'user_type' => 'receiver',
                        'state' => 'received',
                    ]);
                }
            }

            return response()->json('Email sent');
        }else{
            $email->save();
            return response()->json($email);
        }


        // $tab = [];
        // // return response()->json($request->toto->getClientOriginalName());
        // if ($request->attachments) {
        //     foreach($request->attachments as $file){
        //         array_push(
        //             $tab,
        //             json_encode([
        //                 'name' => $file->getClientOriginalName(),
        //                 'type' => $file->extension(),
        //             ])
        //         );
        //     }
        //     return response()->json($tab);
        // }else {
        //     return response()->json(0);
        // }


        // $email = Email::find($id);
        // $email->receivers = json_encode($request->receivers);
        // $email->cc = json_encode($request->cc);
        // $email->object = $request->object;
        // $email->content = $request->content;
        // //$email->files = json_encode($request->files);

        // if($request->hasfile('files')){
        //     foreach($request->file('files') as $file){
        //         array_push(
        //             $links_tab,
        //             json_encode([
        //                 'path' => $file->storeAs('files', $file->getClientOriginalName()),
        //                 'name' => $file->getClientOriginalName(),
        //                 'type' => $file->extension(),
        //                 'size' => $file->size(),
        //             ])
        //         );
        //     }
        // }

        // $email->save();

        // return response()->json($email);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_email = UserEmail::find($id);
        $user_email->delete();
        Email::destroy($user_email->email_id);
        return response()->json('Draft deleted');
    }
}
