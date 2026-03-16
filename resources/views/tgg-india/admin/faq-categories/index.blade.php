@extends('tgg-india.layouts.app')

@section('title','FAQ Category Dashboard')

@section('content')
<div class="admin-container">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="trainer-heading">FAQ Categories</h4>

        <a href="{{ route('tgg-india.admin.faq-categories.create') }}"
           class="btn btn-primary">
            New Category
        </a>
    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Childs</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('tgg-india.admin.faq-categories.index',['parent_id'=>$category->id]) }}">
                            {{ $category->children->count() }}
                        </a>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                        <a href="{{ route('tgg-india.admin.faq-categories.edit',$category->id) }}"
                           class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width:28px;height:28px;">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('tgg-india.admin.faq-categories.destroy',$category->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" style="width:28px;height:28px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{ $categories->links() }}

</div>
@endsection
