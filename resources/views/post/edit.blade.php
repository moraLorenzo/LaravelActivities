@extends('layouts.app')


@section('content')

    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">       
                <div class="card-header card-light bg-success h3 text-light">Edit Post</div>
                <div class="card-body">
                 
                    
                    <form method="POST" action="{{ route('posts.update', $edit[0]->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="title" @error('title') is-invalid @enderror" name="title" value="{{ $edit[0]->title }}" required  autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $edit[0]->description }}" required autocomplete="description">{{ $edit[0]->description }}</textarea>
                            </div>
                        </div>
                          
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                     
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection