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
        $section = request()->section;
        if ($section == '/inbox') {
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereIn('state', ['received', 'read'])
                    ->whereArchived(false)
                    ->whereTrashed(false)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif ($section == '/search') {
            $q = request()->q;
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->join('users','users.id', '=', 'emails.user_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereIn('state', ['received', 'read'])
                    ->whereArchived(false)
                    ->whereTrashed(false)
                    ->where(function($query) {
                        $query->where('users.name', 'like', '%'.request()->q.'%')
                            ->orWhere('emails.object', 'like', '%'.request()->q.'%')
                            ->orWhere('emails.content', 'like', '%'.request()->q.'%');
                    })
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif ($section == '/important') {
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereArchived(false)
                    ->whereTrashed(false)
                    ->whereimportant(true)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif ($section == '/sent') {
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->where('state', 'sent')
                    ->whereArchived(false)
                    ->whereTrashed(false)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif ($section == '/all') {
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereIn('state', ['sent', 'received', 'read'])
                    ->whereTrashed(false)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif ($section == '/archive') {
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereIn('state', ['sent', 'received', 'read'])
                    ->whereArchived(true)
                    ->whereTrashed(false)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif (strpos($section,'/category') !== false) {
            $c = request()->c;
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereIn('state', ['received', 'read'])
                    ->whereTrashed(false)
                    ->whereCategoryId($c)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }elseif ($section == '/draft') {
            return response()->json(
                UserEmail::select('user_emails.*')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->where('state', 'draft')
                    ->whereTrashed(false)
                    ->orderByDesc('user_emails.created_at')
                    ->paginate(10)
            );
        }elseif ($section == '/trash') {
            return response()->json(
                UserEmail::select('user_emails.*','emails.send')
                    ->join('emails','emails.id', '=', 'user_emails.email_id')
                    ->with('user', 'email', 'category')
                    ->where('user_emails.user_id', Auth::user()->id)
                    ->whereTrashed(true)
                    ->orderByDesc('send')
                    ->paginate(10)
            );
        }

        return response('err', 406);
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
                $email->archived = $request->state;
                $email->save();
            }
        }elseif ($function == 'setTrashed') {
            $emails = UserEmail::findMany($request->ids);
            foreach ($emails as  $email) {
                $email->trashed = $request->state;
                $email->save();
            }
        }

        return response()->json('email updated');
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
