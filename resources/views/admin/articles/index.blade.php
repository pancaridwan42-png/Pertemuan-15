@extends('admin.news.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Berita</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Berita
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel Berita</h6>
            <form action="{{ route('articles.index') }}" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control form-control-sm mr-sm-2" placeholder="Cari berita..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ ($articles->currentPage() - 1) * $articles->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($article->image)
                                    <img src="{{ asset('storage/'.$article->image) }}" width="100">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                <a href="{{ route('frontend.articles.show', $article->slug) }}" class="btn btn-info btn-sm" target="_blank">
                    <i class="fas fa-eye"></i> Lihat
                </a>
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $articles->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
