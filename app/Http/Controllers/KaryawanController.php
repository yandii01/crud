<?php

namespace App\Http\Controllers;

use App\Karyawan;
use Illuminate\Http\Request;
use File;
use PhpOffice\PhpWord\TemplateProcessor;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Karyawan::get();
        return view('karyawan.index', compact('users'));
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
        // dd($request);
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'no_hp' => 'required', 
            'photo_profile' => 'required|mimes:png,jpg,jpeg,svg', 
            'email' => 'required', 
            'salary' => 'required', 
        ],
        [
            'name.required' => 'Nama wajib di isi!',
            'gender.required' => 'Lokasi wajib di isi!',
            'no_hp.required' => 'No HP wajib di isi!',
            'photo_profile.required' => 'Foto Profil wajib di isi!',
            'photo_profile.mimes' => 'Foto Profil wajib berformat JPG, JPEG, dan PNG!', 
            'email.required' => 'Email wajib di isi!', 
            'salary.required' => 'Salary wajib di isi!', 
        ]);

        $file = $request->file('photo_profile');
        $namafile = "profile_".time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'upload/profile';
        $file->move($tujuan_upload,$namafile);

        Karyawan::Create([
            'name' => $request->name,
            'photo_profile' => $namafile,
            'gender' => $request->gender,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'salary' => $request->salary,
        ]);  

        return redirect()->back()->with('status', "berhasil menambah data Karyawan baru.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        // dd($karyawan);
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        // dd($karyawan);
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'no_hp' => 'required', 
            'email' => 'required', 
            'salary' => 'required', 
        ],
        [
            'name.required' => 'Nama wajib di isi!',
            'gender.required' => 'Lokasi wajib di isi!',
            'no_hp.required' => 'No HP wajib di isi!',
            'photo_profile.mimes' => 'Foto Profil wajib berformat JPG, JPEG, dan PNG!', 
            'email.required' => 'Email wajib di isi!', 
            'salary.required' => 'Salary wajib di isi!', 
        ]);

        if($request->file('photo_profile') != null) {
            File::delete(public_path('upload/profile/'.$karyawan->photo_profile));
            $file = $request->file('photo_profile');
            $namafile = "profile_".time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'upload/profile';
            $file->move($tujuan_upload,$namafile);
        }
        else{
            $namafile = $karyawan->photo_profile;
        }

        Karyawan::whereId($karyawan->id)->update([
            'name' => $request->name,
            'photo_profile' => $namafile,
            'gender' => $request->gender,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'salary' => $request->salary,
        ]);  

        return redirect('/karyawan')->with('status', "berhasil mengedit data Karyawan baru.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        if($karyawan->photo_profile!=null) {
            File::delete(public_path('upload/profile/'.$karyawan->photo_profile));
        }
        return Karyawan::destroy($karyawan->id);
    }

    public function wordExport($id)
    {
        $user = Karyawan::findOrFail($id);
        $templateProcessor = new TemplateProcessor('word-template/user.docx');
        $templateProcessor->setValue('name', $user->name);
        if($user->gender=='l'){
        $templateProcessor->setValue('gender', 'Laki-laki');
        }
        else{
        $templateProcessor->setValue('gender', 'Perempuan');
        }
        $templateProcessor->setValue('no_hp', $user->no_hp);
        $templateProcessor->setValue('email', $user->email);
        $templateProcessor->setValue('salary', $user->salary);
        $templateProcessor->setImageValue('photo_profile', array('src' => 'upload/profile/'.$user->photo_profile,'swh'=>'250'));
        $fileName = $user->name;
        $templateProcessor->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
    }
}
