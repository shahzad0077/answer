@extends('layouts.app')
@section('title')
<title>Ask Question</title>
<meta name="DC.Title" content="Ask Question">
<meta name="rating" content="general">
<meta name="description" content="Ask Question">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Ask Question">
<meta property="og:description" content="Ask Question">
<meta property="og:site_name" content="Ask Question">
<meta property="og:url" content="{{ url('') }}">
<meta property="og:locale" content="it_IT">
<link rel="stylesheet" href="{{ asset('/front/assets/summernote/summernote-bs4.css') }}">
<script src="{{ asset('/front/assets/summernote/summernote-bs4.min.js') }}"></script>
@endsection
@section('content')
<!-- include libraries(jQuery, bootstrap) -->
<!-- include summernote css/js -->
<section class="profile-section single-community">
    <div class="container-fluid p-0">
        <div class="bg-new-question" style='background-image: url({{ asset("/front/assets/images/shahzad/ask-question-bg-2.png")}});'>
            <div class="row p-mb-4">
                <div class="col-md-6 offset-md-3">
                    <div class="mt-100"></div>
                    @include('admin.alert')
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                            <h1 class="f-20 ask-text">Ask your question and get your answers by experts.</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-ask">
                                <div class="card-body">
                                    <form id="askquestionformsubmit" enctype="multipart/form-data" method="POST" action="{{ url('createquestionuser') }}">
                                        {{ csrf_field() }}
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="text-black f-weight-500">Question Title</label>
                                                <input required="" type="text" class="form-control input-ask" placeholder="" name="question_name">
                                                <label class="text-black mt-2 f-weight-500">Write a detailed answer</label>
                                                <textarea id="summernote" name="question_content" placeholder="" rows="5"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-9">
                                                <p id="files-area">
                                                    <span id="filesList">
                                                        <span id="files-names"></span>
                                                    </span>
                                                </p>
                                                <div class="g-recaptcha"
                                                    data-sitekey="{{config('services.recaptcha.key')}}">
                                                </div>
                                                <div style="color:red;" id="captchaerror"></div>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <input accept="image/png, image/gif, image/jpeg"  multiple="" name="question_image[]" type="file" id="upload" hidden/>
                                                <label class="file-upload" for="upload" title="Upload photos (optional)"><small>Add Media</small> <img width="20px" src="{{asset('/front/assets/images/shahzad/camera.svg')}}"></label>
                                            </div>
                                        </div>


                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3 col-12 text-center">
                                    <p class="ask-text mt-1 pt-2"> <b>Subject -</b></p>
                                </div>
                                <div class="col-md-5 col-12 mb-2">
                                    <select name="question_subject" id="selec-color-dark" class="form-control subject-rounded input-lg" required="">
                                        <option value="">Select Subject</option>
                                        @foreach($categories as $r)
                                        <option value="{{ $r->name }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <button class="btn btn-white-mine btn-block p-3">Submit Now <img width="27px" src="{{asset('/front/assets/images/shahzad/arrow-circle.png')}}"> </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $('#askquestionformsubmit').on('submit', function(e) {
      if(grecaptcha.getResponse() == "") {
        e.preventDefault();
        $('#captchaerror').html('Captcha Is Required');
      }
    });

    const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

        $("#upload").on('change', function(e){
            for(var i = 0; i < this.files.length; i++){
                let fileBloc = $('<span/>', {class: 'file-block'}),
                     fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
                fileBloc.append('<span class="file-delete"><span>+</span></span>')
                    .append(fileName);
                $("#filesList > #files-names").append(fileBloc);
            };
            // Ajout des fichiers dans l'objet DataTransfer
            for (let file of this.files) {
                dt.items.add(file);
            }
            // Mise à jour des fichiers de l'input file après ajout
            this.files = dt.files;

            // EventListener pour le bouton de suppression créé
            $('span.file-delete').click(function(){
                let name = $(this).next('span.name').text();
                // Supprimer l'affichage du nom de fichier
                $(this).parent().remove();
                for(let i = 0; i < dt.items.length; i++){
                    // Correspondance du fichier et du nom
                    if(name === dt.items[i].getAsFile().name){
                        // Suppression du fichier dans l'objet DataTransfer
                        dt.items.remove(i);
                        continue;
                    }
                }
                // Mise à jour des fichiers de l'input file après suppression
                document.getElementById('upload').files = dt.files;
            });
        });
</script>
@endsection
