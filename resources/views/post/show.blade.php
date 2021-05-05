@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @isset($show)
                <div class="card">
                    <div class="card-header card-light bg-success">
                       <span class="h3 text-light"> Post Overview</span>
                        
                       <form style="float: right;" action="{{ route('posts.destroy', $show[0]->id) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        <button type="submit" class="btn btn-danger">Delete <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg></button>
                        </form>
                        
                        <a style="float: right;margin-right:1%" href="/posts/{{ $show[0]->id }}/edit" class="btn btn-primary">Edit 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg></a>
                        
                    </div>
                    <div class="card-body">
                      <span class="badge badge-pill badge-primary h3">Title</span>
                      <h4 class="card-title">{{ $show[0]->title }}</h4>

                      <br>

                      <span class="badge badge-pill badge-warning h3">Description</span>
                      <h4 class="card-text">{{ $show[0]->description }}</h4>

                      <br>
                    
                      @if ( $show[0]->img != '' )
                        <span class="badge badge-pill badge-warning h3">Image</span><br>
                        <img style="width:300px" src="{{ asset('/storage/img/'.$show[0]->img) }}" alt="No image found">
                      @endif

                      <br>
                      <br>

                      @if ($show[0]->comments)
                      <span class="badge badge-pill badge-warning h3">Comments:</span><br>
                      @foreach ($show[0]->comments as $comment)
                          <div class="display-comment" >
                              <p>{{ $comment->description }}</p>
                              <a href="" id="reply"></a>
                              <form method="post" action="{{ route('comments.store') }}">
                                  @csrf
                                  <div class="form-group">
                                      <input type="text" name="description" class="form-control" />
                                      <input type="hidden" name="post_id" value="{{ $comment->post_id }}" />
                                      <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                  </div>
                                  <div class="form-group">
                                      <input type="submit" class="btn btn-warning" value="Reply" />
                                  </div>
                              </form>
                          </div>
                      @endforeach                            
                  @endif

                      <br>


                    <form method="post" action="{{ route('comments.store') }}">  
                        @csrf
                       
                        <span class="badge badge-pill badge-warning h3">Comment:</span><br>

                           <div class="col-md-6">
                               <input id="description" type="text" class="form-control  @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required>
                               <input type="hidden" name="post_id" value="{{ $show[0]->id }}">        
                               
                               @error('description')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                           </div>

                           <br>
                           <br>

                           <div class="form-group">
                                <input type="submit" class="btn btn-block btn-outline-primary" value="Add Comment">
                           </div>


                      </form>

                    </div>
                  </div>
                @endisset     
            </div>
        </div>
    </div>
</div>
@endsection