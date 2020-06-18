<?php

namespace App\Http\Controllers;

use App\Category;
use App\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            UserEmail::select('user_emails.*','emails.send')
                ->join('emails','emails.id', '=', 'user_emails.email_id')
                ->with('user', 'email', 'category')
                ->whereUserId(Auth::user()->id)
                ->whereIn('state', ['received', 'read'])
                ->whereArchived(false)
                ->whereTrashed(false)
                ->orderByDesc('send')
                ->paginate(10)
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
        //
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
    public function update(Request $request, $function)
    {
        if ($function == 'toggleImportant') {
            $emails = UserEmail::findMany($request->ids);
            foreach ($emails as  $email) {
                $email->important = $request->state;
                $email->save();
            }
        }elseif ($function == 'setCategory') {
            $emails = UserEmail::findMany($request->ids);
            foreach ($emails as  $email) {
                $email->category_id = $request->categoryId;
                $email->save();
            }
        }elseif ($function == 'setRead') {
            $emails = UserEmail::findMany($request->ids);
            foreach ($emails as  $email) {
                $email->state = ($request->state) ? 'read' : 'received';
                $email->save();
            }
        }elseif ($function == 'setArchived') {
            $emails = UserEmail::findMany($request->ids);
            foreach ($emails as  $email) {
                $email->archived = true;
                $email->save();
            }
        }elseif ($function == 'setTrashed') {
            $emails = UserEmail::findMany($request->ids);
            foreach ($emails as  $email) {
                $email->trashed = true;
                $email->save();
            }
        }

        return response()->json(
            UserEmail::select('user_emails.*','emails.send')
                ->join('emails', 'user_emails.email_id', 'emails.id')
                ->with('user', 'email', 'category')
                ->whereUserId(Auth::user()->id)
                ->whereIn('state', ['received', 'read'])
                ->whereArchived(false)
                ->whereTrashed(false)
                ->orderBy('email.send', 'desc')
                ->paginate(10)
        );
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


    public function storeCategory(Request $request)
    {
        Category::Create($request->all());
        return response()->json(Auth::user());
    }
}
