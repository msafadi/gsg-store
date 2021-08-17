require('./bootstrap');

require('alpinejs');

var typing = false;
var typingTime, typingInterval;

window.Echo.private('orders')
    .listen('.order.created', function(event) {
        alert(`New order created ${event.order.number}`)
    });

window.Echo.private(`Notifications.${userId}`)
    .notification(function(e) {
        var count = Number($('#unread').text());
        count++;
        $('.unread').text(count);

        $('#notifications').prepend(`<a href="#${e.id}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> <b>*</b>
            ${e.title}
            <span class="float-right text-muted text-sm">${e.time}</span>
        </a>
        <div class="dropdown-divider"></div>`);

        alert(e.title);
    })

const chat = window.Echo.join('chat')
    .here((users) => {
        for (i in users) {
            $('#users').append(`<li id="user-${users[i].id}">${users[i].name}</li>`);
        }
    })
    .joining((user) => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
            User ${user.name} joined!
        </div>`);
        $('#users').append(`<li id="user-${user.id}">${user.name}</li>`);    
    })
    .leaving((user) => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
            User ${user.name} left!
        </div>`);
        $('#users').find(`#user-${user.id}`).remove();
    })
    .listen('MessageSent', (event) => {
        addMessage(event);
    })
    .listenForWhisper('typing-start', (e) => {
        /*$('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
            ${e.name} is typing...
        </div>`);*/
        $('#typing').css('display', 'block');
    })
    .listenForWhisper('typing-stop', (e) => {
        $('#typing').css('display', 'none');
    });

(function($) {
    $('#chat-form').on('submit', function(event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('#chat-form input').val('');
        })
    });

    $('#chat-form input').on('keypress', function(e) {
        if (e.key == 'Enter') return;
        typingTime = new Date();
        if (!typing) {
            typing = true;
            chat.whisper('typing-start', {
                name: 'Someone'
            });
            typingInterval = setInterval(function() {
                var seconds = ((new Date) - typingTime);
                if (seconds > 600) {
                    typing = false;
                    clearInterval(typingInterval);
                    chat.whisper('typing-stop', {
                        name: 'Someone'
                    });
                }
            }, 1000);
        }
    })

})(jQuery);

function addMessage(event) {
    $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
        ${event.sender.name}: ${event.message}
    </div>`);
}

