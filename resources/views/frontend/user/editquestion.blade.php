@extends('layouts.app')
@section('title')
<title>Answerout</title>
<meta name="DC.Title" content="Answerout">
<meta name="rating" content="general">
<meta name="description" content="Answerout">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Answerout">
<meta property="og:description" content="Answerout">
<meta property="og:site_name" content="Answerout">
<meta property="og:url" content="{{ url('') }}">
<meta property="og:locale" content="it_IT">
@endsection
@section('content')
@include('admin.alert')
<!-- ========= Profile Section Start -->
    <section class="profile-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/my-profile')}}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-center">
                @include('frontend.user.userprofile')
                <div class="col-xl-8 col-lg-6">
                    <div class="profile-main-content">
                        <ul class="top-menu">
                            <li>
                                <a href="{{url('/profile/notifications')}}">
                                    Notifications  
                                    @if(DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count() > 0)  <div class="num">{{DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count()}}</div> @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/my-profile')}}">
                                    Your Questions 
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/profile/answered')}}">
                                    Answered 
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/profile/unanswered')}}">
                                    Unanswered 
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/profile/saved')}}">
                                    Saved  &nbsp;<img src="{{asset('/front/assets/images/shahzad/tag-filled.svg')}}" width="14px"> 
                                </a>
                            </li>
                        </ul>
                        <br>

                        <div class="card card-ask box-shadow">
                            <div class="card-body">
                                @include('admin.alert')
                                   <form enctype="multipart/form-data" method="POST" action="{{ url('updatequestionuser') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $data->id }}" name="id">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <input required="" value="{{ $data->question_name }}" type="text" class="form-control input-lg input-ask" placeholder="Question Title..." name="question_name">
                                            <br>
                                            <textarea id="summernote" name="question_content" class="input-bg-light form-control mt-3" placeholder="Put Description.." rows="15">{{ $data->question_content }}</textarea>
                                        </div>

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3 col-12">
                                            <input accept="image/png, image/gif, image/jpeg"  name="question_image[]" multiple="" type="file" id="upload" hidden/>
                                            <label class="file-upload-edit" for="upload" title="Upload photos (optional)"><small>Add Media</small> <img width="20px" src="{{asset('/front/assets/images/shahzad/camera.svg')}}"></label>
                                        </div>
                                        <div class="col-md-5 col-12 mb-2">
                                            <select name="question_subject" id="input-bg-light-edit" class="bg-imp-select form-control input-lg" required="">
                                                <option value="">Select Subject</option>
                                                @foreach($categories as $r)
                                                <option @if($r->name == $data->question_subject) selected @endif value="{{ $r->name }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <button class="btn btn-white-mine-edit-2 btn-block p-3">Submit Now <img width="27px" src="{{asset('/front/assets/images/shahzad/arrow-circle.png')}}"></button>
                                        </div>
                                    </div>
                                    </form>
                                    <p id="files-area">
                                        <span id="filesList">
                                            <span id="files-names">
                                                @foreach(DB::table('questionimages')->where('questionid'  ,$data->id)->get() as $r)
                                                <span class="file-block"><span onclick="deleteimage({{$r->id}})" class="file-delete"><span>+</span></span><span class="name">{{ $r->image_name }}</span></span>
                                                @endforeach
                                            </span>
                                        </span>
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========= Profile Section Start -->
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
            function deleteimage(id)
            {
                var mainurl = '{{ url('') }}';
                 $.ajax({
                    type: "GET",
                    url: mainurl+'/deleteimagequestion/'+id,
                    success: function(resp) {
                        $('#files-names').html(resp)
                    }
                });
            }
    </script>
@endsection