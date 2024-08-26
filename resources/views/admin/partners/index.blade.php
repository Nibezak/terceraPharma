@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <a href="{{ route('home') }}" class="text-decoration-none mr-3">
                <li class="breadcrumb-item">Home</li>
            </a>
            <li class="breadcrumb-item active">Partner</li>
        </ol>
    </nav>

    <!-- Upload multiple products -->
    <div class="card mb-3">
        <div class="card-body">
        </div>
    </div>

    <!-- Display all products from DB -->
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Partners</span>
            <livewire:admin.search-bar>
                <a href="{{ route('partner.create') }}" class="btn btn-dark">Add Partner</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 40%;">Image</th>
                            <th style="width: 20%;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $partner)
                            <tr>
                                <td>{{ $partner->name }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}"
                                        style="width: 100px; height: auto;">
                                </td>
                                <td>
                                    <form action="{{ route('partner.delete', $partner->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash-alt"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{-- {{ $partners->links() }} --}}
            </div>
        </div>
    </div>
@endsection
