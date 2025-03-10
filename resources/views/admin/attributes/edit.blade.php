@extends('admin.components.layout')

@section('content')

    <div class="content create">
        <div class="row">
            <div class="col-md-6 offset-md-2 col-sm-2">
                <div class="card">
                    <div class="card-header">
                        <h2>Редагування атрибута</h2>
                    </div>
                    <div class="card-body card-block">
                        <form action="{{ route('attribute.update', $attribute->slug) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name" class=" form-control-label">Назва</label></div>
                                <div class="col-12 col-md-9"><input  type="text" id="name" name="name" value="{{ $attribute['name'] }}" required class="form-control"></div>
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
                                <div class="col-12 col-md-9"><input type="text" value="{{ $attribute['slug'] }}" id="slug" name="slug" class="form-control"></div>
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
                            <button class="btn btn-success" type="submit">Редагувати атрибут</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
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
