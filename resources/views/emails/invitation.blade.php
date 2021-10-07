<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>You have been invited to join the {!! $name !!} team</title>
  <style>
    tr td ul li img {
      max-width: 500px;
    }

    tr td pre {
      overflow: auto;
    }

    a:hover {
      text-decoration: underline !important;
    }


    .buttonaccept {
  background-color: #004A7F;
  -webkit-border-radius: 10px;
  border-radius: 3px;
  border: none;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: Arial;
  font-size: 30px;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
}
@-webkit-keyframes glowing {
  0% { background-color: #97bf2d; -webkit-box-shadow: 0 0 3px #97bf2d; }
  50% { background-color: #97bf2d; -webkit-box-shadow: 0 0 40px #97bf2d; }
  100% { background-color: #97bf2d; -webkit-box-shadow: 0 0 3px #97bf2d; }
}

@-moz-keyframes glowing {
  0% { background-color: #97bf2d; -moz-box-shadow: 0 0 3px #97bf2d; }
  50% { background-color: #97bf2d; -moz-box-shadow: 0 0 40px #97bf2d; }
  100% { background-color: #97bf2d; -moz-box-shadow: 0 0 3px #97bf2d; }
}

@-o-keyframes glowing {
  0% { background-color: #97bf2d; box-shadow: 0 0 3px #97bf2d; }
  50% { background-color: #97bf2d; box-shadow: 0 0 40px #97bf2d; }
  100% { background-color: #97bf2d; box-shadow: 0 0 3px #97bf2d; }
}

@keyframes glowing {
  0% { background-color: #97bf2d; box-shadow: 0 0 3px #97bf2d; }
  50% { background-color: #97bf2d; box-shadow: 0 0 40px #97bf2d; }
  100% { background-color: #97bf2d; box-shadow: 0 0 3px #97bf2d; }
}

.buttonaccept {
  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;
}

  </style>
</head>

<body style="
        margin: 10px;
        padding: 0;
        background-color: #f9f9f9;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        font-weight: lighter;
        line-height: 1.2;">
  <div style="
        min-height: 300px;
        width: 100%;
        max-width: 750px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #d7d7d7;
        border-radius: 4px;
        background-color: #fff;
        box-shadow: 0 2px 4px #d7d7d7;">
    <div style="
          width: 100%;">
      <img src="http://dev.petprotectusa.com//frontend/img/logo-white.png" width="25%" height="45px" />
      <div style="
            width: 95%;
            margin: 10px auto;
            border: 1px solid #d7d7d7;">
      </div>
    </div>


    <p style="
    font-size: 15px;
    text-align: left;
    width: 95%;
    padding: 15px;
    ">
        Dear {!! $name !!} !<br>
        You have been invited by {{ DB::table('users')->where('id' , Auth::user()->id)->get()->first()->name }} to join the Pet Protect as a  <b>{!! $label !!}</b> for Pet <b>{!! $petname  !!}</b>. 
    </p>

    <p style="
    font-size: 15px;
    text-align: left;
    width: 95%;
    padding: 15px;
    ">
        To accept this invitation, please click on the following link:
    </p>

    <div style="
          padding-left: 15px;
          max-width: 700px;
          text-align: left;">
      <h4 style="margin-bottom: 5px;">
        <a href="{!! $requesturl !!}" class="buttonaccept" style="
            color: white;
            font-weight: 700;
            text-decoration: none;">
            Accept Invitation </a>
      </h4>
    </div>
    
<p style="
    font-size: 15px;
    text-align: left;
    width: 95%;
    padding: 15px;
    ">
        If you do not wish to accept this invitation, simply do nothing - it is safe to ignore this e-mail.
    </p>    
    
    <p style="
    font-size: 15px;
    text-align: left;
    width: 95%;
    padding: 15px;
    ">
        This e-mail was automatically generated - please do not reply.
    </p>    
    
  </div>
</body>

</html>