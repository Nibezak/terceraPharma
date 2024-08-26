@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ 'Add Partner' }}</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('partner.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row justify-content-between m-auto ">
                    <div class="form-group " style="width: 100%;">
                        <label for="name">Partner Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Tercera Inc">
                    </div>
                </div>

                <div class="row justify-content-between m-auto py-2 px-2">
                    <div class="form-group" style="width: 100%;">
                        <label for="images">Partner Image</label>
                        <input type="file" name="image" id="images" class="form-control"
                            accept=".jpg,.jpeg,.png,.gif">

                    </div>
                </div>

                <button class="btn btn-dark" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
