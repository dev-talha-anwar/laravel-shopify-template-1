<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function store(Request $request){
        $validator = validator($request->all(), [
            'email' => 'required|email|max:191',
            'subject' => 'required|string|max:191',
            'message' => 'required|string|max:191'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if(auth()->user()->shop_contacts()->create($request->all())):
            return response()->json(['success' => "Contact Successfull."]);
        endif;
        return response()->json(['error' => "Something Went Wrong."]);
    }
}
