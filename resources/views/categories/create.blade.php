@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Створити категорію</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form id="create" method="post" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Назва категорії:</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>

                    <div class="form-group">
                        <img class="chose-image" src="{{ asset('images/200_default.png') }}"
                             id="chooseImage" alt="Обрати фото">
                        <input type="hidden" name="base64Image" id="base64Image">


                    </div>

                    <div class="form-group">
                        <label for="email">Опис:</label>
                        <textarea class="form-control" name="description" id="description" rows="10" cols="45"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add contact</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('view._croper-modal');
@endsection

@section('scripts')
    <script>
        jQuery(function () {
            //фото по якому клікаємо і обираємо файл
            $chooseImage = $("#chooseImage");
            //текстове поле із base64
            $base64Image = $("#base64Image");
            //скритий інпут для вибору файла
            $selectImage = $("#selectImage");
            let dialogCropper = $("#cropperModal");
            //клікнули по фото і клікаємо по скритому інпуту файл
            $chooseImage.on("click", function () {
                let uploader = $('<input type="file" accept="image/*" />');
                uploader.click()
                uploader.on('change', function () {
                    if (this.files && this.files.length) {
                        let file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            dialogCropper.modal('show');
                            cropper.replace(e.target.result);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            });
            //запуск кропера
            const imageCropper = document.getElementById('imageCropper');
            const cropper = new Cropper(imageCropper, {
                aspectRatio: 1 / 1,
                viewMode: 1,
                autoCropArea: 0.5,
                crop(event) {
                    // console.log(event.detail.x);
                    // console.log(event.detail.y);
                    // console.log(event.detail.width);
                    // console.log(event.detail.height);
                    // console.log(event.detail.rotate);
                    // console.log(event.detail.scaleX);
                    // console.log(event.detail.scaleY);
                },
            });
            //поворот малюнка
            $("#img-rotation").on("click", function (e) {
                e.preventDefault();
                cropper.rotate(45);
            });
            //обрізка малюнка
            $("#cropImg").on("click", function (e) {
                e.preventDefault();
                var imgContent = cropper.getCroppedCanvas().toDataURL();
                $chooseImage.attr("src", imgContent);
                dialogCropper.modal('hide');
                $base64Image.val(imgContent);
            });
        })
    </script>

    //запускаємо фороалу едітор

    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('node_modules/tinymce-i18n/langs/uk.js') }}"></script>

    <script>
        $(function () {
            tinymce.init({
                selector: 'textarea#description',
                language: "uk",
                theme: "silver",
                menubar: true,
                skin: 'oxide-dark',
                content_css: 'dark',
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table paste code help wordcount",
                ],
                toolbar:
                    "undo redo | formatselect | bold italic backcolor | \
         alignleft aligncenter alignright alignjustify | \
         bullist numlist outdent indent | removeformat | help",
            });
        });
    </script>
@endsection
