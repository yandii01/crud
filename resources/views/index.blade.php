<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Laravel MS Word</title>
</head>
<body>

<div class="container">
<h2>Daftar Karyawan</h2>
        <hr>
        @if(session()->has('status'))
            @if (!session('hasError'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @elseif(session('hasError'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
        @endif
        
        <form action="" method="get" autocomplete="off">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="d-flex">
                            &nbsp;
                            <a class="btn btn-success" data-id="add" data-toggle="modal" data-target="#exampleModal"><i
                                        class="fas fa-plus">tambah data</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <div class="row">
        <div class="col">
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">No HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Foto Profil</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @php $no = 1; @endphp
                @forelse($users as $user)
                    <tr>
                        <td class="text-center">{{ number_format($no++) }}</td>
                        <td>{{ $user->name }}</td>
                        @if($user->gender == 'l')
                        <td>Laki-Laki</td>
                        @else
                        <td>Perempuan</td>
                        @endif
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->email }}</td>
                        <td>Rp {{ $user->salary }}</td>
                        <td><div class="image">
                            <img src="{{asset('upload/profile/'.$user->photo_profile)}}" width="200px">
                        </div>
                        </td>
                        <td>
                            <a href="{{ url('karyawan/word-export/' . $user->id) }}" class="btn btn-sm btn-primary">Export Word</a><br>
                            <a href="{{url('/karyawan/'.$user->id.'/edit')}}" class="btn btn-secondary">Edit<i class="fa fa-pen"></i>
                            </a><br>
                            <a href="javascript:void(0)" class="btn btn-danger" type="button" onclick="hapusKaryawan({{$user->id}})">
                                <i class="fa fa-trash">Delete</i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data</td>
                    <tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="/index" autocomplete="off" id="formId" enctype="multipart/form-data">
                {{csrf_field()}}
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }} <br/>
                    @endforeach
                </div>
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                    <div class="form-group">
                            <label for="name">Nama</label>
                            <input name="name" id="name" class="form-control" title="Nama"
                                type="text" placeholder="Nama"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="nama_lab">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="l"  @if(old('gender') == 'l') selected @endif>Laki-laki</option>
                                <option value="p" @if(old('gender') == 'p') selected @endif>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input name="no_hp" id="no_hp" class="form-control" title="no_hp"
                                type="number"  placeholder="No HP"
                            required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" id="email" class="form-control" title="email"
                                type="email" placeholder="Email"
                            required>
                        </div>
                        <div class="form-group">
                            <label for="salary">Current Salary</label>
                            <input name="salary" id="salary" class="form-control" title="salary"
                                type="number" placeholder="Salary"
                            required>
                        </div>
                        <div class="form-group">
                            <label for="penanggung_jawab">Foto Profil</label>
                            <input name="photo_profile" id="photo_profile" class="form-control" title="Foto profile"
                                type="file" placeholder="Foto lab"
                            required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function hapusKaryawan(id){
        event.preventDefault();
        swal({
            title: 'Anda akan menghapus data?',
            text: 'Data akan dihapus secara permanen!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                console.log(value);
                $.ajax({
                    url: '/index/'+id,
                    data : {
                        "_token" : "{{csrf_token()}}"
                    },
                    type: 'delete',
                    dataType: 'json',
                    success: function(result){
                        console.log(result);
                        if(result){
                            swal({ 
                                title: "Berhasil!", 
                                text: "Penghapusan berhasil dilakukan !.", 
                                icon: "success" 
                            }).then(function() {
                                window.location = "/index";
                            });

                        }else{
                            swal({ title: "Gagal!", text: result.message, icon: "error" })
                        }
                    },
                    error: function(err){
                        swal({ title: "Gagal!", text: "Terjadi kesalahan saat menghapus data !", icon: "error" })
                    }
                })
            }
        });
    }
</script>
</body>
</html>
