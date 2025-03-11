@extends('admin.components.layout')

@section('content')

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4 ">
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
        </div>
            <div class="content">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <div class="content create">
                                <div class="row">
                                    <div class="col-md-12 offset-md-12 col-sm-12">
                                        <div class="card">
                                            <div class=" create_card-header card-header">
                                                <h2>Створення значення для {{ $name['name'] }}</h2>
                                            </div>
                                            <div class="card-body card-block">
                                                <form action="{{ route('attribute.value.store', ['id' => $attribute->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    @csrf
                                                    <div class="row form-group">
                                                        <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                                                        <div class="col col-md-3"><label for="name" class=" form-control-label">Назва</label></div>
                                                        <div class="col-12 col-md-9"><input  type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control"></div>
                                                    </div>
                                                    @if($errors->has('name'))
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach($errors->get('name') as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="slug" class=" form-control-label">Slug</label></div>
                                                        <div class="col-12 col-md-9"><input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"></div>
                                                    </div>
                                                    @if($errors->has('slug'))
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach($errors->get('slug') as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <button class="btn btn-success" type="submit">Додати атрибут</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .animated -->
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7 col-lg-8">

                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Список значень {{ $name['name'] }}</strong>
                                </div>
                            </div>


                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Назва</th>
                                        <th>Слаг</th>
                                        <th>Редагувати</th>
                                        <th>Видалити</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($values as $value)
                                        <tr>
                                            <td>{{ $value['name'] }}</td>
                                            <td>{{ $value['slug'] }}</td>
                                            <td><a class="btn btn-info" href="{{ route('attribute.value.edit', ['attribute_slug' => $attribute->slug, 'value_slug' => $value->slug]) }}">Змінити</a></td>
                                            <td><form action="{{ route('attribute.value.destroy', ['attribute' => $attribute->id, 'value' => $value->id]) }}" method="POST" onsubmit="return confirm('Видалити атрибут?');">
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


    </div><!-- /#right-panel -->
@endsection
@push('scripts')
    <script>
        // Функция для транслитерации кириллицы в латиницу
        function transliterate(str) {
            var map = {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'і': 'i', 'ї': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'yu', 'я': 'ya',
                'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh', 'З': 'Z', 'И': 'I', 'І': 'I', 'Ї': 'I', 'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'Kh', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Shch', 'Ы': 'Y', 'Э': 'E', 'Ю': 'Yu', 'Я': 'Ya'
            };

            return str.split('').map(function(char) {
                return map[char] || char;
            }).join('');
        }

        // Функция для преобразования текста в slug
        function generateSlug(text) {
            return transliterate(text)                // Транслитерация
                .toLowerCase()                          // Приводим в нижний регистр
                .replace(/[^a-z0-9\s-]/g, '')            // Убираем все ненужные символы
                .replace(/\s+/g, '-')                    // Заменяем пробелы на дефисы
                .replace(/-+/g, '-')                     // Убираем несколько дефисов подряд
                .replace(/^-+/, '')                      // Убираем дефис в начале
                .replace(/-+$/, '');                     // Убираем дефис в конце
        }

        // Обработчик события для поля 'name'
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            // Когда значение в поле name изменяется, генерируем slug
            nameInput.addEventListener('input', function() {
                slugInput.value = generateSlug(nameInput.value);
            });
        });
    </script>
@endpush
