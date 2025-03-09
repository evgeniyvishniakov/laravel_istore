@extends('admin.components.layout')

@section('content')

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">Table</a></li>
                                <li class="active">Data table</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Список категорій</strong>
                        </div>
                    </div>
                    <a href="{{ route('category.create') }}" class="btn btn-success" >Додати категорію</a>
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Назва</th>
                                    <th>Кількість товарів</th>
                                    <th>Слаг</th>
                                    <th>Редагувати</th>
                                    <th>Видалити</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category['name'] }}</td>
                                    <td>20</td>
                                    <td>{{ $category['slug'] }}</td>
                                    <td><a class="btn btn-info" href="/category/{{ $category['id'] }}/edit">Змінити</a></td>
                                    <td><form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Удалить категорию?');">
                                            @csrf <!-- Токен безопасности -->
                                            @method('DELETE') <!-- Имитация DELETE-запроса -->
                                            <button class="btn btn-danger" type="submit">Видалити</button>
                                        </form>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->


    <div class="clearfix"></div>

    <footer class="site-footer">
        <div class="footer-inner bg-white">
            <div class="row">
                <div class="col-sm-6">
                    Copyright &copy; 2018 Ela Admin
                </div>
                <div class="col-sm-6 text-right">
                    Designed by <a href="https://colorlib.com">Colorlib</a>
                </div>
            </div>
        </div>
    </footer>

</div><!-- /#right-panel -->
@endsection
