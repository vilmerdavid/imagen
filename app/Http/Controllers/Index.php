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
        
        $base64_image = $request->foto;
        $user=new User([
            'name'=>'vilmer',
            'email'=>'vilmer@gmail.com',
            'password'=>Hash::make('123456')
        ]);
        $user->save();

        
        $base64_image = $request->foto;
        
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            $nombreFoto=$user->id.'.jpg';
            Storage::put("public/firmas/".$nombreFoto, $data);
            $url = Storage::url("public/firmas/".$nombreFoto);
            $user->firma=$url;
            $user->save();
        }
        return response()->json(['ok'=>'ok']);
    }
}
