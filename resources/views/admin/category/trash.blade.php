@extends('layouts.admin');
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Trash Category List</h3>
            </div>
            <div class="card-body">
                @if (session('restore'))
            <div class="alert alert-success">{{ session('restore') }}</div>
            @endif
           
           
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trash_cat as $index=>$category )
                        <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>
                            <img src="{{ asset('uploads/category') }}/{{ $category->category_image }}" alt="">
                        </td>
                        <td>
                            <a href="{{ route('category.restore',$category->id) }}" class="btn btn-info">Restore</a>
                            <a data-link="{{ route('category.hard.delete',$category->id) }}" class="btn btn-danger del">Delete</a>
                            
                        </td>
                    </tr>
                    @endforeach
                    
                </table>
            </div>
        </div>



    </div>
</div>


@endsection

@section('script')

    <script>
        $('.del').click(function(){
            Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        var link =$(this).attr('data-link');
                        window.location.href =link
                    }
                    });
        });
    </script>

    @if (session('pdel'))
    <script>
        Swal.fire({
            title: "Good job!",
            text: "{{ session('pdel') }}",
            icon: "success"
            });
    </script>
    @endif



@endsection


