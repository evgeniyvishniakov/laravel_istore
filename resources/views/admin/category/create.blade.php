@extends('admin.components.layout')

@section('content')

    <div class="content create">
            <div class="row">
                <div class="col-md-6 offset-md-2 col-sm-2">
                    <div class="card">
                        <div class="card-header">
                            <h2>Створення категорії</h2>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="name" class=" form-control-label">Назва</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="name" name="name" required class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="slug" class=" form-control-label">Slug</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="slug" required name="slug" class="form-control"></div>
                                </div>
                                <button class="btn btn-success" type="submit">Додати категорію</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div><!-- .animated -->
@endsection
