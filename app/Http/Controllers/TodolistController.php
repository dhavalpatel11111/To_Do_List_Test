<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodolistController extends Controller
{
    public function add(Request $request)
    {

        $userid = Auth::user()->id;
    

        $requestData = $request->all();
        if ($requestData['hid'] > 0) {
            $responce['status'] = 0;

            $tododata = Todolist::find($requestData['hid']);
            if ($tododata->update([
                'title' => $requestData['title'],
                'description' => $requestData['description'],
            ])) {
                $responce['status'] = 0;
                $responce['msg'] = "To Do Updated Succsessfully";
                return $responce;
            } else {
                $responce['status'] = 1;
                $responce['msg'] = "Finding Some Error";
                return $responce;
            }
        } else {
            $responce['status'] = 0;


            if (Todolist::create([
                'userid' => $userid,
                'title' => $requestData['title'],
                'description' => $requestData['description'],
                'status' => "notdone",
            ])) {
                $responce['status'] = 0;
                $responce['msg'] = "To Do Added Succsessfully";
                return $responce;
            } else {
                $responce['status'] = 1;
                $responce['msg'] = "Finding Some Error";
                return $responce;
            }
        }
    }

    function todo_list()
    {
        $userid = Auth::user()->id;

        $user = Todolist::where("userid" , $userid)->get();


        $data = [];
        $no = 0;
        foreach ($user as $user) {

            $data[] = [
                'id' => ++$no,
                'title' => $user->title,
                'description' => $user->description,
                'status' => $user->status,
                'date_when_created' => $user->created_at,
                'date_when_updated' => $user->updated_at,
                'action' => '<button id="' . $user->id . '" class="btn btn-warning edit">Edit</button> | | <button id="' . $user->id . '" class="btn btn-danger delete">Delete</button>',
            ];
        }


        return response()->json(['data' => $data]);
    }


    public function delete_todo(Request $request)
    {
        $post = $request->all();
        $id = $post['id'];
        if (Todolist::find($id)->delete()) {
            $responce['status'] = 0;
            $responce['msg'] = "To-Do deleted ";
            return $responce;
        } else {
            $responce['status'] = 1;
            $responce['msg'] = "Finding Some Error";
            return $responce;
        }
    }



    function edit(Request $request)
    {


        $post = $request->all();
        $editId = $post["id"];
        $categories = Todolist::find($editId);

        return json_encode($categories);
    }
}
