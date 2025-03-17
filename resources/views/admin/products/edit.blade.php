
@extends('admin.components.layout')

@section('content')

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-4 col-lg-2 col-sm-4"> </div>
                <div class="col-md-6 col-lg-7 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h2>Редагування товару</h2>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="name" class=" form-control-label">Назва</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" value="{{ old('name', $product->name) }}" id="name" name="name"  class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="desc" class=" form-control-label">Опис</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="desc"  id="desc" rows="9" class="form-control textarea-editor">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="short_desc"  class=" form-control-label">Короткий опис</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="short_desc"  id="short_desc" rows="9" class="form-control textarea-editor2">{{ old('short_desc', $product->short_desc) }}</textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="sku" class=" form-control-label">SKU</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text"  value="{{ old('sku', $product->sku) }}" id="sku" name="sku" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="price" class=" form-control-label">Ціна</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" value="{{ old('price', $product->price) }}"  id="price" name="price" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="sale" class=" form-control-label">Ціна зі знижкою</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" value="{{ old('sale', $product->sale) }}"  id="sale" name="sale" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="qnt" class=" form-control-label">Кількість</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="qnt" value="{{ old('qnt', $product->quantity) }}" name="qnt" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="select" class="form-control-label">Категорія</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="category_id" id="select" class="form-control">
                                            <option value="0">Оберіть категорію</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Відображення</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" name="visible" checked value="1" class="form-check-input {{ old('visible', $product->visible) ? 'checked' : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="file-input" class=" form-control-label">Зображення</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="file-input" name="image" class="form-control-file">
                                        <div class="card">
                                            <img class="card-img-top" src="{{ asset('storage/' . $product->image_url) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="file-multiple-input" class=" form-control-label">Галерея</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="file-multiple-input" name="images[]" multiple class="form-control-file">
                                        <div class="cards">
                                            <div id="image-gallery">
                                                @foreach($product->images as $image)
                                                    <div class="image-item" data-id="{{ $image->id }}">
                                                        <img src="{{ asset('storage/' . $image->image_url) }}" width="100">
                                                        <button type="button" class="remove-image" data-id="{{ $image->id }}">✖</button>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Скрытое поле для передачи удалённых изображений -->
                                            <input type="hidden" name="deleted_images" id="deleted-images">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="slug" class=" form-control-label">Slug</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" value="{{ old('slug', $product->slug) }}" id="slug" name="slug" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="select" class=" form-control-label">Атрибути</label>
                                        <button id="add-attribute-pair" type="button" class="fa fa-plus-circle btn btn-primary"></button>
                                    </div>
                                    <!-- Кнопка "Добавить" -->
                                    <div class="col col-md-9">
                                    <!-- Контейнер для селектов -->
                                        <div id="attributes-container">
                                            <div class="list_product_attr_value" id="list_product_attr_value">
                                                <div class="row">
                                                    @foreach($product->attributes as $attribute)
                                                        <div class="attribute-pair_edit col-12" id="attribute-pair-{{ $attribute->id }}">
                                                            <div class="row">
                                                                <div class="col-6 col-md-5">
                                                                    <select class="form-control">
                                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 col-md-5">
                                                                    <select class="form-control" name="attributes[{{ $attribute->id }}]">
                                                                        @foreach($attribute->values as $value)
                                                                            <option value="{{ $value->id }}"
                                                                                {{ isset($selectedValues[$attribute->id]) && $selectedValues[$attribute->id] == $value->id ? 'selected' : '' }}>
                                                                                {{ $value->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 col-md-2">
                                                                    <button type="button" class="fa fa-times-circle-o btn btn-danger remove-attribute-pair" data-delete-id="{{ $attribute->id }}"></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- Ваши исходные селекты -->
                                            <div class="attribute-pair" id="attribute-pair-1">
                                                <div class="row">
                                                    <div class="col-6 col-md-5">
                                                        <select id="attribute-select-1" class="form-control" name="attributes[]">
                                                            <option value=""  >Выберите атрибут</option>
                                                            @foreach($attributes_edit as $attribute)
                                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6 col-md-5">
                                                        <select id="attribute-values-select-1" class="form-control" name="values[]">
                                                            <option value=""  >Выберите значение</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 col-md-2">
                                                        <button type="button" class="fa fa-times-circle-o btn btn-danger remove-attribute-pair" data-pair-id="1"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Редагувати товар</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2">

                </div>
            </div>
        </div>
    </div><!-- .animated -->
@endsection

@push('scripts')


    <script>

        document.addEventListener("DOMContentLoaded", function() {
            let deletedImages = [];

            document.querySelectorAll('.remove-image').forEach(button => {
                button.addEventListener('click', function() {
                    let imageId = this.getAttribute('data-id');
                    deletedImages.push(imageId); // Добавляем ID в массив

                    // Убираем картинку из DOM
                    this.parentElement.remove();

                    // Записываем в скрытое поле
                    document.getElementById('deleted-images').value = deletedImages.join(',');
                });
            });
        });


        $(document).ready(function() {
            // Обработчик для кнопки удаления
            $('#list_product_attr_value').on('click', '.remove-attribute-pair', function() {
                // Получаем уникальный id пары атрибутов через data-delete-id
                var deleteId = $(this).data('delete-id');

                // Удаляем родительский блок с селектами, используя id
                $('#attribute-pair-' + deleteId).remove();
            });
        });

        $(document).ready(function() {
            let attributeIndex = 1; // Индекс для уникальности ID

            // Обработчик клика на кнопку "Добавить"
            $('#add-attribute-pair').click(function() {
                attributeIndex++; // Увеличиваем индекс для нового блока

                // Клонируем первый блок селектов
                const newAttributePair = $('.attribute-pair').first().clone();

                // Обновляем ID для нового селекта и кнопки
                newAttributePair.find('select#attribute-select-1')
                    .attr('id', 'attribute-select-' + attributeIndex)
                    .val('');
                newAttributePair.find('select#attribute-values-select-1')
                    .attr('id', 'attribute-values-select-' + attributeIndex)
                    .empty()
                    .append('<option value="">Выберите значение</option>');

                // Обновляем data-pair-id для кнопки удаления
                newAttributePair.find('.remove-attribute-pair')
                    .attr('data-pair-id', attributeIndex);

                // Обновляем id контейнера
                newAttributePair.attr('id', 'attribute-pair-' + attributeIndex);

                // Добавляем новый блок в контейнер
                $('#attributes-container').append(newAttributePair);
            });

            // Делегирование событий: обработка удаления элемента
            $('#attributes-container').on('click', '.remove-attribute-pair', function() {
                const pairId = $(this).data('pair-id');
                const remainingPairs = $('#attributes-container .attribute-pair').length;

                // Проверяем, не является ли это последним элементом
                if (remainingPairs > 1) {
                    $('#attribute-pair-' + pairId).remove(); // Удаляем блок с селектами
                } else {
                    alert('Невозможно удалить последний блок');
                }
            });

            // Делегирование событий: обработка изменений для селектов
            $('#attributes-container').on('change', 'select[id^="attribute-select-"]', function() {
                const attributeId = $(this).val();
                const attributeSelectId = $(this).attr('id').split('-')[2]; // Получаем уникальный ID текущего селекта
                const valuesSelect = $('#attribute-values-select-' + attributeSelectId); // Найдем соответствующий селект значений

                if (attributeId) {
                    $.ajax({
                        url: '/admin-panel/product/attribute-values/' + attributeId,
                        type: 'GET',
                        success: function(data) {
                            valuesSelect.empty();
                            valuesSelect.append('<option value="">Выберите значение</option>');

                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    valuesSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                valuesSelect.append('<option value="">Нет значений для этого атрибута</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 404) {
                                // Выводим сообщение о том, что нет значений для данного атрибута
                                alert(xhr.responseJSON.message);  // Это выведет сообщение 'Нет значений для данного атрибута'

                                // Или выводим сообщение в элемент HTML, если вы хотите
                                valuesSelect.empty();
                                valuesSelect.append('<option value="">' + xhr.responseJSON.message + '</option>');
                            } else {
                                console.log('Ошибка AJAX: ', error);
                            }
                        }
                    });
                } else {
                    valuesSelect.empty();
                    valuesSelect.append('<option value="">Выберите значение</option>');
                }
            });
        });



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
