<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <title>Laravel MS Word</title>
</head>
<body>

<div class="container">
<h2>Employee</h2>
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
            <table id="example" class="display" style="width:100%">
                <thead>
                <tr>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">No HP</th>
                    <th scope="col">DoB</th>
                    <th scope="col">Address</th>
                    <th scope="col">Current Position</th>
                    <th scope="col">Ktp File</th>
                    <th scope="col">Action</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                    <th scope="col" style="display:none;">ID</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="display:none;">{{ $user->id }}</td>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->birth }}</td>
                        <td>{{ $user->street }}</td>
                        <td>{{ $user->currentposition }}</td>
                        <td>
                            <!-- <div class="image">
                            <img src="{{asset('upload/profile/'.$user->ktp_photo)}}" width="200px">
                        </div> -->
                        <!-- <button href="#imgModal" data-toggle="modal" data-img-url="{{asset('upload/profile/'.$user->ktp_photo)}}">
                            KTP
                        </button> -->
                        <a href="#imgModal" data-toggle="modal" data-gallery="example-gallery" class="col-sm-3" data-img-url="{{asset('upload/profile/'.$user->ktp_photo)}}">KTP
                            <img src="{{asset('upload/profile/'.$user->ktp_photo)}}" class="img-fluid image-control" hidden>
                        </a>
                        </td>
                        <td>
                            <!-- <a href="{{ url('karyawan/word-export/' . $user->id) }}" class="btn btn-sm btn-primary">Export Word</a><br>
                            <a href="{{url('/karyawan/'.$user->id.'/edit')}}" class="btn btn-secondary">Edit<i class="fa fa-pen"></i>
                            </a><br> -->
                            <button class="btn btn-warning edit" value="{{$user->id}}">Edit</button>
                            <a href="javascript:void(0)" class="btn btn-danger" type="button" onclick="hapusKaryawan({{$user->id}})">
                                <i class="fa fa-trash">Delete</i>
                            </a>
                        </td>
                        <td style="display:none;">{{ $user->email }}</td>
                        <td style="display:none;">{{ $user->province }}</td>
                        <td style="display:none;">{{ $user->city }}</td>
                        <td style="display:none;">{{ $user->zipcode }}</td>
                        <td style="display:none;">{{ $user->ktpnumber }}</td>
                        <td style="display:none;">{{ $user->banknumber }}</td>
                        <td style="display:none;">{{ $user->firstname }}</td>
                        <td style="display:none;">{{ $user->lastname }}</td>
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

@foreach($users as $user)
<div id="imgModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img class="" src="" style="width:400px;"/>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Attachment Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/karyawan/" method="POST" id="editForm" >
      <div class="modal-body">
      
        @method('patch')
        {{csrf_field()}}

        <div class="form-group">
            <label for="">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-group" placeholder="">
        </div>
        
        <div class="form-group">
            <label for="">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-group" placeholder="">
        </div>

        <div class="form-group">
            <label for="">DoB</label>
            <input type="date" name="birth" id="birth" class="form-group" placeholder="">
        </div>

        <div class="form-group">
            <label for="">No HP</label>
            <input type="number" name="no_hp" id="no_hp" class="form-group" placeholder="">
        </div>

        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" id="email" class="form-group" placeholder="">
        </div>
        
        <div class="form-group">
            <label for="">Street</label>
            <textarea type="text" name="street" id="street" class="form-group" placeholder=""></textarea>
        </div>
        
        <div class="form-group">
            <label for="">Zip Code</label>
            <input type="number" name="zipcode" id="zipcode" class="form-group" placeholder="">
        </div>

        <div class="form-group">
            <label for="">KTP Number</label>
            <input type="number" name="ktpnumber" id="ktpnumber" class="form-group" placeholder="">
        </div>

        <div class="form-group">
            <label for="currentposition">Current Position</label>
            <select name="currentposition" id="currentposition" class="form-control" required>
                <option value="manager"  @if(old('currentposition') == 'manager') selected @endif>Manager</option>
                <option value="supervisor" @if(old('currentposition') == 'supervisor') selected @endif>Supervisor</option>
                <option value="staff" @if(old('currentposition') == 'staff') selected @endif>Staff</option>
                <option value="etc" @if(old('currentposition') == 'etc') selected @endif>etc</option>
            </select>
        </div>

        <div class="form-group">
            <label for="banknumber">Bank Account Number</label>
            <select name="banknumber" id="banknumber" class="form-control" required>
                <option value="bca"  @if(old('banknumber') == 'bca') selected @endif>BCA</option>
                <option value="mandiri" @if(old('banknumber') == 'mandiri') selected @endif>Mandiri</option>
                <option value="etc" @if(old('banknumber') == 'etc') selected @endif>etc</option>
            </select>
        </div>

        <div class="form-group">
                            <label for="">Attach KTP</label>
                            <input name="ktp_photo" id="ktp_photo" class="form-control" title="Foto profile"
                                type="file" placeholder="Foto lab">
                        </div>
                        
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update changes</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- /Attachment Modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="/karyawan/" autocomplete="off" id="formId" enctype="multipart/form-data">
                {{csrf_field()}}
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }} <br/>
                    @endforeach
                </div>
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="firstname">FirstName</label>
                            <input name="firstname" id="firstname" class="form-control" title="Nama"
                                type="text" placeholder=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">LastName</label>
                            <input name="lastname" id="lastname" class="form-control" title="Nama"
                                type="text" placeholder=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="birth">DoB</label>
                            <input name="birth" id="birth" class="form-control" title="Nama"
                                type="date" placeholder=""
                                >
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input name="no_hp" id="no_hp" class="form-control" title="no_hp"
                                type="number"  placeholder=""
                            required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" id="email" class="form-control" title="email"
                                type="email" placeholder="Email"
                            >
                        </div>
                        <!-- <div class="form-group">
                            <label for="nama_lab">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="l"  @if(old('gender') == 'l') selected @endif>Laki-laki</option>
                                <option value="p" @if(old('gender') == 'p') selected @endif>Perempuan</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="title">Select provinsi:</label>
                            <select name="province" class="form-control">
                                <option value="">--- Select provinsi ---</option>
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->name }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control">
                            <option value="">---City ---</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <textarea name="street" id="street" class="form-control" title="Nama"
                                placeholder=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="zipcode">ZIP Code</label>
                            <input name="zipcode" id="zipcode" class="form-control" title="zipcode"
                                type="number"  placeholder=""
                            >
                        </div>
                        <div class="form-group">
                            <label for="ktpnumber">KTP Number</label>
                            <input name="ktpnumber" id="ktpnumber" class="form-control" title="ktpnumber"
                                type="number"  placeholder=""
                            required>
                        </div>
                        <div class="form-group">
                            <label for="currentposition">Current Position</label>
                            <select name="currentposition" id="currentposition" class="form-control" required>
                                <option value="manager"  @if(old('currentposition') == 'manager') selected @endif>Manager</option>
                                <option value="supervisor" @if(old('currentposition') == 'supervisor') selected @endif>Supervisor</option>
                                <option value="staff" @if(old('currentposition') == 'staff') selected @endif>Staff</option>
                                <option value="etc" @if(old('currentposition') == 'etc') selected @endif>etc</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="banknumber">Bank Account Number</label>
                            <select name="banknumber" id="banknumber" class="form-control" required>
                                <option value="bca"  @if(old('banknumber') == 'bca') selected @endif>BCA</option>
                                <option value="mandiri" @if(old('banknumber') == 'mandiri') selected @endif>Mandiri</option>
                                <option value="etc" @if(old('banknumber') == 'etc') selected @endif>etc</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="penanggung_jawab">Attach KTP</label>
                            <input name="ktp_photo" id="ktp_photo" class="form-control" title="Foto profile"
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
                $.ajax({
                    url: '/karyawan/'+id,
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
                                window.location = "/karyawan/";
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
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="province"]').on('change', function() {
            var nama_provinsi = $(this).val();
            console.log(nama_provinsi);
            if(nama_provinsi) {
                $.ajax({
                    url: '/karyawan/getkota/'+nama_provinsi,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ value +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "pagingType": "full_numbers"
        } );
    } );
</script>
<script>
    $('div a').click(function(e) {
        $('#imgModal img').attr('src', $(this).attr('data-img-url')); 
    });
</script>
<script>
    $(document).ready(function(){

        var table = $('#example').DataTable();

        table.on('click', '.edit', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#firstname').val(data[13]);
            $('#lastname').val(data[14]);
            $('#birth').val(data[3]);
            $('#no_hp').val(data[2]);
            $('#email').val(data[8]);
            $('#province').val(data[9]);
            $('#city').val(data[10]);
            $('#street').val(data[4]);
            $('#zipcode').val(data[11]);
            $('#ktpnumber').val(data[12]);
            $('#currentposition').val(data[5]);
            $('#banknumber').val(data[13]);
            // $('#ktp_photo').val(data[3]);

            $('#editForm').attr('action', '/karyawan/'+data[0]);
            $('#editModal').modal('show');
        })

    });
</script>
</body>
</html>
