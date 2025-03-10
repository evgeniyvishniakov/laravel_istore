@extends('admin.components.layout')

@section('content')

    <div class="content create">
            <div class="row">
                <div class="col-md-6 offset-md-2 col-sm-2">
                    <div class="card">
                        <div class="card-header">
                            <h2>Редагування категорії</h2>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('category.update', $category->slug) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="name" class=" form-control-label">Назва</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="name" value="{{ old('name', $category->name) }}" name="name" required class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="slug" class=" form-control-label">Slug</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="slug" value="{{ old('slug', $category->slug) }}" required name="slug" class="form-control">
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Редагувати категорію</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div><!-- .animated -->
@endsection
