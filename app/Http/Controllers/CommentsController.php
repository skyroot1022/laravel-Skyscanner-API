<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\comment\CreateRequest;

class CommentsController extends Controller
{

    public function store(CreateRequest $request)
    {
//        $data = $request->except( '_token');
//
//        $COMMENT = new Comment();
//
//        $COMMENT->fill( $data );
//
//        $COMMENT->group_id = $group_id;
//
//        $COMMENT->save();
//
//        return redirect()->back();

            $data = $request->except('_token');

            $COMMENT = new Comment();

            $COMMENT->fill($data);

            $COMMENT->save();

        return redirect()->back();
    }


    public function delete($id)
    {


    }
}
