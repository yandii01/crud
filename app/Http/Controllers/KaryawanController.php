<?php

namespace App\Http\Controllers;

use App\{Provinsi, District, City, Subdistrict, Karyawan};
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
        $provinsi = Provinsi::select('id', 'name')->get();
        return view('karyawan.index', compact('users', 'provinsi'));
    }

    public function getKota($nama_provinsi)
    {   
        $kota = City::join('reg_provinces', 'reg_provinces.id', '=', 'reg_regencies.province_id')->where('reg_provinces.name', '=', $nama_provinsi)->select('reg_regencies.name')->pluck('reg_regencies.name');
        //$states = DB::table("states")->where("countries_id",$id)->pluck("name","id");
        return json_encode($kota);

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
            'firstname' => 'required',
            'lastname' => 'required',
            'no_hp' => 'required', 
            'ktp_photo' => 'required|mimes:png,jpg,jpeg,svg', 
            'ktpnumber' => 'required',
        ],
        [
            'firstname.required' => 'First Name wajib di isi!',
            'lastname.required' => 'Last Name wajib di isi!',
            'no_hp.required' => 'No HP wajib di isi!',
            'ktpnumber.required' => 'No KTP wajib di isi!',
            'ktp_photo.required' => 'Foto Profil wajib di isi!',
            'ktp_photo.mimes' => 'Foto Profil wajib berformat JPG, JPEG, dan PNG!',
        ]);

        $file = $request->file('ktp_photo');
        $namafile = "profile_".time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'upload/profile';
        $file->move($tujuan_upload,$namafile);

        Karyawan::Create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'ktp_photo' => $namafile,
            'birth' => $request->birth,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'province' => $request->province,
            'city' => $request->city,
            'street' => $request->street,
            'zipcode' => $request->zipcode,
            'ktpnumber' => $request->ktpnumber,
            'currentposition' => $request->currentposition,
            'banknumber' => $request->banknumber,
        ]);  

        return redirect()->back()->with('status', "berhasil menambah data Employee.");
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
            'firstname' => 'required',
            'lastname' => 'required',
            'no_hp' => 'required', 
            'ktpnumber' => 'required',
        ],
        [
            'firstname.required' => 'First Name wajib di isi!',
            'lastname.required' => 'Last Name wajib di isi!',
            'no_hp.required' => 'No HP wajib di isi!',
            'ktpnumber.required' => 'No KTP wajib di isi!',
        ]);

        if($request->file('ktp_photo') != null) {
            File::delete(public_path('upload/profile/'.$karyawan->ktp_photo));
            $file = $request->file('ktp_photo');
            $namafile = "profile_".time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'upload/profile';
            $file->move($tujuan_upload,$namafile);
        }
        else{
            $namafile = $karyawan->ktp_photo;
        }

        Karyawan::whereId($karyawan->id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'ktp_photo' => $namafile,
            'birth' => $request->birth,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'province' => $request->province,
            'city' => $request->city,
            'street' => $request->street,
            'zipcode' => $request->zipcode,
            'ktpnumber' => $request->ktpnumber,
            'currentposition' => $request->currentposition,
            'banknumber' => $request->banknumber,
        ]);  

        return redirect('/karyawan')->with('status', "berhasil mengedit data Employee.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        if($karyawan->ktp_photo!=null) {
            File::delete(public_path('upload/profile/'.$karyawan->ktp_photo));
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
