@extends('layout.master')
@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-12">
            <h3>Daftar buku</h3>
            <span class="text-secondary">
                <p>* berikut daftar buku yang tersedia</p>
            </span>
            <hr>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('update'))
                <div class="alert alert-warning">
                    {{ session('update') }}
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-danger">
                    {{ session('delete') }}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#addBuku">
                    Tambah Buku
                    </button>
                </div>
                <div class="col-sm-6">
                    <form class="form-inline float-right my-2" method="POST" action="{{ route('buku.search') }}">
                        @csrf
                        @method('put')
                        <input class="form-control mr-sm-2" type="search" name="key" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
            </form>
            <table class="table table-stripped table-hover">
                <thead class="bg-info text-white">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Tgl. Terbit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_buku as $buku)
                    <tr>
                        <td class="text-center">{{ $data['no']++ }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td class="text-center">Rp.{{ number_format($buku->harga) }}</td>
                        <td class="text-center">{{ $buku->tgl_terbit }}</td>
                        <td class="text-center">
                            <form class="d-inline" action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button onclick="return confirm('Lanjutkan menghapus data?')" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editBuku{{$buku->id}}">
                            Edit
                            </button>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="editBuku{{$buku->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                            <div class="modal-body">
                                @method('put')
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{ $buku->judul }}" autofocus name="judul">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" value="{{ $buku->penulis }}" name="penulis">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="number" value="{{ $buku->harga }}" name="harga">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="date" value="{{ $buku->tgl_terbit }}" name="tgl">
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addBuku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('buku.store') }}" method="POST">
        <div class="modal-body">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Judul Buku" autofocus name="judul">
                @error('judul')
                <div id="validationServer03Feedback" class="invalid-feedback">Judul buku harus diisi!</div>
                @enderror
            </div>
            <div class="form-group">
                <input class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis') }}" type="text" placeholder="Penulis" name="penulis">
                @error('penulis')
                <div id="validationServer03Feedback" class="invalid-feedback">Penulis harus diisi!</div>
                @enderror
            </div>
            <div class="form-group">
                <input class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" type="number" placeholder="Harga Buku" name="harga">
                @error('harga')
                <div id="validationServer03Feedback" class="invalid-feedback">Harga harus diisi!</div>
                @enderror
            </div>
            <div class="form-group">
                <input class="form-control @error('tgl') is-invalid @enderror" value="{{ old('tgl') }}" type="date" placeholder="Tanggal Terbit" name="tgl">
                @error('tgl')
                <div id="validationServer03Feedback" class="invalid-feedback">Tanggal Terbit harus diisi!</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection             