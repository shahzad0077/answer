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
@endsection
@section('content')
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script src="{{ url('/front/ckeditor/image/plugin.js') }}"></script>
<script type="text/javascript"></script>
<section class="profile-section single-community">
    <div class="container-fluid p-0">
        <div class="bg-new-question" style='background-image: url({{ asset("/front/assets/images/shahzad/ask-question-bg.svg")}});'>
            <div class="row">
                <div class="col-md-9 offset-md-3">
                    <div class="mt-100"></div>
                    <div class="row mt-3">

                        <div class="col-md-9">
                            @include('admin.alert')
                            <div class="row mt-2 mb-4">
                                <div class="col-md-12">
                                    <h1 class="f-20 text-white">Ask your question and get your answers by experts.</h1>
                                </div>
                            </div>
                            <form enctype="multipart/form-data" method="POST" action="{{ url('createquestionuser') }}">
                                {{ csrf_field() }}
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input required="" type="text" class="form-control input-lg" placeholder="Question Title..." name="question_name">
                                    <br>
                                    <textarea id="editor1" name="question_content" class="form-control mt-3" placeholder="Put Description.." rows="15"></textarea>
                                    <script>
                                         $(document).ready(function() {
                                               CKEDITOR.editorConfig = function( config ) {
                                                    config.extraPlugins = 'imageuploader';
                                                };
                                              });
                                      </script>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3 col-3">
                                    <input accept="image/png, image/gif, image/jpeg"  multiple="" name="question_image[]" type="file" id="upload" hidden/>
                                    <label class="file-upload" for="upload" title="Upload photos (optional)"><small>Add Media</small> <img width="20px" src="{{asset('/front/assets/images/shahzad/camera.svg')}}"></label>
                                </div>
                                <div class="col-md-6 col-6">
                                    <select name="question_subject" class="form-control input-lg" required="">
                                        <option value="">Select Subject</option>
                                        @foreach($categories as $r)
                                        <option value="{{ $r->name }}">{{ $r->name }}</option>
                                        @endforeach
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-2">
                                    <button class="btn btn-white-mine btn-block p-3">Submit Now</button>
                                </div>
                            </div>
                            </form>
                            <style type="text/css">
                               #files-area{
                                    /*width: 30%;*/
                                    /*margin: 0 auto;*/
                                }
                                .file-block{
                                    border-radius: 10px;
                                    background-color: rgba(144, 163, 203, 0.2);
                                    margin: 5px;
                                    color: initial;
                                    display: inline-flex;
                                     
                                }

                                .file-block span.name{
                                        padding-right: 10px;
                                        width: max-content;
                                        display: inline-flex;
                                }
                                .file-delete{
                                    display: flex;
                                    width: 24px;
                                    color: initial;
                                    background-color: #6eb4ff00;
                                    font-size: large;
                                    justify-content: center;
                                    margin-right: 3px;
                                    cursor: pointer;
                                }
                                .file-delete span{
                                    transform: rotate(45deg);
                                }
                                .file-delete:hover{
                                        background-color: rgba(144, 163, 203, 0.2);
                                        border-radius: 10px;
                                }
                            </style>
                            <p id="files-area">
                                <span id="filesList">
                                    <span id="files-names"></span>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

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