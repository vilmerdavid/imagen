<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Index extends Controller
{
    public function indexFirma()
    {
        $data = array('usuario' => User::first());
        return view('index',$data);
    }

    public function procesarFirma(Request $request)
    {
        
        
        $user=new User([
            'name'=>'vilmer',
            'email'=>'vilmer@gmail.com',
            'password'=>Hash::make('123456')
        ]);
        $user->save();

        

        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $extension = $request->foto->extension();
                Storage::delete($user->foto);
                $path = Storage::putFileAs(
                    'public/firmas', $request->file('foto'), $user->id.'.'.$extension
                );
                $user->firma=$path;
                $user->save();
            }
        }
        
        return response()->json($user);
    }
}
