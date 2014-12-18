<div class="container"><div class="row">
    <div class="col-md-8">
        <div id="tabs" style="margin-bottom: 5px">
            <a href="#public" class="btn btn-primary btn-lg active" id="0" role="button"><?=_t('public')?></a>
        </div>
        <div id="chatArea">
            <div class="list-group clearfix" style="height: 300px; overflow:hidden; border: 1px solid #ddd">
                <div id="messages" style="position:relative; bottom:0px;"></div>
            </div>
            <div>
                <textarea class="form-control" style="height: 200px" id="messageText"></textarea>
                <button id="send" class="btn btn-primary pull-right"><?=_t('send')?></button>                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h2><?=_t('online');?></h2>
        <div class="list-group" id="online_users_container"></div>
    </div>
</div></div>
<script type="text/javascript">
    var other = 'all';
    var name = '<?=$_SESSION["username"]?>';
    var conversations = [];
    conversations[0] = 'all';

    function updateOnlineList(){
        $.get("api.php?action=get&info=online_users",function(result){
            var data = JSON.parse(result);
            var txt = '';
            data.forEach(function(item){
                txt += '<a href="#'+item+'" class="list-group-item">'+item+'</a>';
            });
            $('#online_users_container').html(txt);
        });
    }

    function updateMessages(){
        if(other == 'all'){
            $.get("api.php?action=get&info=public_messages",function(result){
                var data = JSON.parse(result);
                var txt = '';
                data.forEach(function(item){
                    txt += '<span class="label label-default">'+item["from"]+'</span> '+item["message"];
                });
                $('#messages').html(txt);
                var h = 290 - $('#messages').height();
                $('#messages').css('margin-top',h);
            });
        }else{
            $.get("api.php?action=get&info=messages&from="+name+"&to="+other,function(result){
                var data = JSON.parse(result);
                var txt = '';
                data.forEach(function(item){
                    txt += '<span class="label label-default">'+item["from"]+'</span> '+item["message"];
                });
                $('#messages').html(txt);
                var h = 290 - $('#messages').height();
                $('#messages').css('margin-top',h);
            });
        }
    }

    function gotoConversation(indice){
        $('#tabs > a').removeClass('active');
        $("#"+indice).addClass('active');
        other = conversations[indice];
        updateMessages();
    }

    $(document).ready(function(){
        
        updateOnlineList();
        setInterval(function(){
            updateOnlineList();
        }, 10000); // Every 10 seconds

        updateMessages();
        setInterval(function(){
            updateMessages();
        }, 1000); // Every second

        // Click Events
        $('#online_users_container').on('click', 'a', function(){
            var target = $(this).html();
            var indice = $.inArray(target, conversations);
            if(indice == -1){
                conversations.push(target);
                var id = $.inArray(target, conversations);
                $('#tabs').append('<a href="#'+target+'" id="'+id+'" class="btn btn-primary btn-lg active" role="button">'+target+'</a>');
                gotoConversation(id);
            }else{
                gotoConversation(indice);
            }
        });
        
        $('#tabs').on('click', 'a', function(){
            gotoConversation($(this).attr('id'));
        });

        $("#send").click(function(){
            var content = CKEDITOR.instances.messageText.getData();
            if(content != ''){
                $.get("api.php?action=post&method=send&from="+name+"&to="+other+"&message="+content,function(result){
                    CKEDITOR.instances.messageText.setData('');
                    updateMessages();
                });
            }
        });

        CKEDITOR.replace('messageText');
    });
</script>