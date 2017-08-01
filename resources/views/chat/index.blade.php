@extends('layouts.app')
@section('content')
<div class="container">
<div class="row " style="padding-top:40px;">
  <h3 class="text-center" >Welcome {{Auth::user()->name}} </h3>
  <br /><br />

  <div class="col-md-2">

  </div>
  <div class="col-md-8">
      <div class="panel panel-info">
          <div class="panel-heading">
              RECENT CHAT HISTORY
          </div>
          <div class="panel-body">
              <ul class="media-list" id="message">
                    @foreach($messages as $message)
                    <li class="media">

                        <div class="media-body">

                            <div class="media">
                                <div class="media-body" >
                                    {{$message->message}}
                                    <br />
                                   <small class="text-muted">{{$message->from_name}} | {{$message->from_email}} | {{$message->created_at}}</small>
                                    <hr />
                                </div>
                            </div>

                        </div>
                    </li>
                    @endforeach
                </ul>
          </div>
          <div class="panel-footer">
              <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Enter Message" />
                {{csrf_field()}}
                <input type="hidden" name="from_name" value="{{Auth::user()->name}}" />
                <input type="hidden" name="from_email" value="{{Auth::user()->email}}" />
                <span class="input-group-btn">
                    <button class="btn btn-info" id="send" type="button">SEND</button>
                </span>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-2">

  </div>
</div>
<script type="text/javascript" src="/js/jquery.js">

</script>
<script type="text/javascript">
  $(document).ready(function(){
    setTimeout(realTime,2000);
  });
  function realTime(){
    $.ajax({
      type:'post',
      url:'/chat/get',
      data:{
        '_token':$('input[name=_token]').val(),
      },
      success:function(data){
        $('#message').replaceWith('<ul class="media-list" id="message"></ul>');
        for (var i = 0; i < data.length; i++) {
          $('#message').append(" <li class='media'><div class='media-body'><div class='media'><div class='media-body'>"+data[i].message+"<br /><small class='text-muted'>"+data[i].from_name+ "|"+data[i].from_email+ "|" +data[i].created_at+"</small><hr /></div></div></div></li>");
        }
      },
      dataType: "json"
    });
    setTimeout(realTime,2000);
  }
  $(document).on('click', '#send', function(){
    $.ajax({
      type:'post',
      url:'/chat/send',
      data:{
        '_token':$('input[name=_token]').val(),
        'from_name':$('input[name=from_name]').val(),
        'from_email':$('input[name=from_email]').val(),
        'message':$('input[name=message]').val(),
      },
      success:function(data){
        $('#message').append(" <li class='media'><div class='media-body'><div class='media'><div class='media-body'>"+data.message+"<br /><small class='text-muted'>"+data.from_name+ "|"+data.from_email+ "|" +data.created_at+"</small><hr /></div></div></div></li>");
      },
      dataType: "json"
    });
    $('input[name="message"]').val('');
  });

</script>
@endsection
