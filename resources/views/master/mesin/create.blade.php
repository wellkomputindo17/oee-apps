@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- DataTales Example -->
            <div class="card shadow">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-primary">Form Add {{ $title }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('mesin.store') }}" method="post">
                        @method('post')
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="no_mesin" class="col-md-2">No Machine <span
                                            style="color: red;font-weight: bold;">*</span></label>
                                    <input type="text" required autocomplete="off"
                                        class="form-control col-md-5 @error('no_mesin') is-invalid @enderror"
                                        name="no_mesin" id="no_mesin" value="{{ old('no_mesin') }}">
                                    @error('no_mesin')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2">Name Machine <span
                                            style="color: red;font-weight: bold;">*</span></label>
                                    <input type="text" required value="{{ old('name') }}" autocomplete="off"
                                        class="form-control col-md-5  @error('name') is-invalid @enderror" name="name"
                                        id="name">
                                    @error('name')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="year" class="col-md-2">Year Machine</label>
                                    <input type="number" value="{{ old('year') }}"
                                        class="form-control col-md-5  @error('year') is-invalid @enderror" name="year"
                                        id="year">
                                    @error('year')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-md-2">Type Machine</label>
                                    <input type="text" value="{{ old('type') }}"
                                        class="form-control col-md-5  @error('type') is-invalid @enderror" name="type"
                                        id="type">
                                    @error('type')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="origin" class="col-md-2">Origin Machine</label>
                                    <input type="text" value="{{ old('origin') }}"
                                        class="form-control col-md-5  @error('origin') is-invalid @enderror" name="origin"
                                        id="origin">
                                    @error('origin')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('mesin.index') }}" class="btn btn-danger">Back</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
