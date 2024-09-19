@extends('frontend.author.author_main')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">My Post List</h3>
            </div>
            <div class="card-body">
                @if (session('status_change'))
                    <div class="alert alert-success">{{ session('status_change') }}</div>
                @endif
                <table class="table table-bordered ">
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Preview</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($posts as $index=>$post )
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $post->title }}</td>
                            <td>
                                <img src="{{ asset('uploads/post/preview') }}/{{ $post->preview }}" alt="">
                            </td>
                            <td>
                                <span class="badge badge-{{ $post->status==1?'success':'secondary' }}">{{ $post->status==1?'Active':'Deactive' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('my.post.status',$post->id) }}" class="btn btn-{{ $post->status==1?'success':'secondary' }}">{{ $post->status==1?'Active':'Deactive' }}</a>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection