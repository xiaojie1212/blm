<?php

namespace App\Http\Controllers\Api;

use App\Models\Addresses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressesController extends BaseController
{
    public function add(Request $request)
    {
        $data=$request->all();
        Addresses::create($data);
        return [
            "status"=>"true",
            "message"=>"添加地址成功"
        ];
    }

    public function list(Request $request)
    {
        $userId=$request->input('user_id');
        $addresses=Addresses::where('user_id',$userId)->get();
        return $addresses;
    }

    public function save(Request $request)
    {
        $id=$request->input('id');
        $address=Addresses::where('id',$id)->first();
        return $address;
    }
    public function edit(Request $request)
    {
        $id=$request->input('id');
        $data=$request->all();
        $address=Addresses::findOrFail($id);
        $address->update($data);
        return [
            "status"=>"true",
            "message"=>"修改地址成功"
        ];

    }
}
