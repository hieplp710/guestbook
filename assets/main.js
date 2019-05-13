var loaderHtml = '<span class="loader">Loading...</span>';
var emptyState = '<span class="empty-state">There is no message!</span>';


function renderEmptyState() {
    $('#content-wrapper').html(emptyState);
}

function renderList(messageList) {            
    var template = '<div class="col-xs-12 col-sm-12 col-md-6 post-item" id="message-:id:"><div class="content">:message:</div>'
                + '<div class="author">:guest_name:</div><div class="time">:timestamp:</div>'
                + '</div>';
    if (isLogged) {
        template = '<div class="col-xs-12 col-sm-12 col-md-6 post-item" id="message-:id:">'
                + '<div class="content">:message:</div>'
                + '<div class="edit-wrapper"><div class="form-group"><textarea class="txtContentEdit form-control">:message:</textarea></div>'
                + '<div class="edit-control"><button class="btn btnUpdate btn-primary" data-id=":id:">Update</button></div></div>'
                + '<div class="author">:guest_name:</div><div class="time">:timestamp:</div>'
                + '<div class="control">'
                + '<button class="btnEdit btn btn-primary circle" data-id=":id:"><i class="fas fa-pencil-alt"></i></button>'
                + '<button class="btnCancelEdit btn btn-primary circle" data-id=":id:"><i class="fas fa-ban"></i></button>'
                + '<button class="btnDelete btn btn-primary circle" data-id=":id:"><i class="fas fa-trash"></i></button>'
                + '</div></div>';
    }
    var html = '';
    for(var i = 0; i < messageList.length; i++) {
        var guestMessage = messageList[i];
        var itemHtml = template;
        var keys = Object.keys(guestMessage);
        for (var n = 0; n < keys.length; n++) {
            var key = keys[n];
            var find = '\:' + key +'\:';
                itemHtml = itemHtml.replace(new RegExp(find, 'g'), guestMessage[key]);
        }
        html += itemHtml;                
    }
    $('#content-wrapper').html(html);
}

function renderPaginationBar(numberPage, active_page) {
    if (numberPage == 0) {
        $('#footer').html('');
        return false;
    }
    var pageListHtml = '<ul class="lstPagination"> <li class="page previos"><button class="btn btn-page"><</button></li>';
    for (var i = 1; i <= numberPage; i++) {
        pageListHtml += '<li class="page" value="' + i + '"><button class="btn btn-page page-item">' + i + '</button></li>';
    }
    pageListHtml += '<li class="page next"><button class="btn btn-page">></button></li>';
    $('#footer').html(pageListHtml);
    togglePage(active_page);
}

function togglePostForm(isShow) {
    var shown = isShow != undefined ? isShow : false;
    if (shown) {
        //show form
        $('div.post-message-wrapper').show();
        $('#btnPostMessage').hide();
    } else {
        //show button post a message
        $('div.post-message-wrapper').hide();
        $('#btnPostMessage').show();
    }
}

function toggleEditMessage(id, isShow) {
    var shown = isShow != undefined ? isShow : false;
    if (shown) {
        //show form
        $('#message-' + id + ' div.edit-wrapper').show();
        $('#message-' + id + ' .btnCancelEdit').show();
        $('#message-' + id + ' .btnEdit').hide();
        $('#message-' + id + ' .content').hide();                
    } else {
        //show button post a message
        $('#message-' + id + ' div.edit-wrapper').hide();
        $('#message-' + id + ' .btnCancelEdit').hide();
        $('#message-' + id + ' .btnEdit').show();
        $('#message-' + id + ' .content').show();      
    }
}

function resetForm() {
    $('#txtGuestName').val('');
    $('#txtMessage').val('');
    togglePostForm();
}

function resizeToFix() {
    var rightPanel = $('div.right-panel').height();
    var windowHeight = $(window).height();
    if (rightPanel < windowHeight) {
        $('div.right-panel').height(windowHeight);
    }
}

function loadGuestMessage(pageIndex) {
    var page = pageIndex != undefined ? parseInt(pageIndex) : 1;
    $.ajax({
        type: "GET",
        url: "/controller/GetListMessage.php",
        contentType: "application/json",
        data: {"page":page},
        dataType: "json",
        success: function (response) {
            if (response.data.length > 0) {
                renderList(response.data);
                renderPaginationBar(response.numberPage, page);                        
            } else {
                renderEmptyState();
            }
            //resize the window height
            resizeToFix();                    
        },
        error: function(){
        }
    });
}

function togglePage(pageIndex) {
    $('ul > li.page.active').removeClass('active');
    $('ul > li.page[value="' + pageIndex + '"]').addClass('active');
}

$(document).ready(function(){
    $('#btnPostMessage').on('click', function(e){
        e.preventDefault();
        togglePostForm(true);
    });

    $('#btnCancel').on('click', function(e){
        resetForm();
    });

    $('#content-wrapper').on('click', '.post-item .btnEdit', function(e){
        var id = $(this).attr('data-id');
        toggleEditMessage(id, true);
    });

    $('#content-wrapper').on('click', '.post-item .btnCancelEdit', function(e){
        var id = $(this).attr('data-id');
        toggleEditMessage(id);
    });

    $('#btnSubmitMessage').on('click', function(e){
        e.preventDefault();
        var guestName = $('#txtGuestName').val();
        var message   = $('#txtMessage').val();
        if ($.trim(guestName) == '') {
            alert('Please enter guest name!');
            return false;
        }
        if ($.trim(message) == '') {
            alert('Please enter message!');
            return false;
        }
        var dataPost = {
            "guest_name": guestName,
            "message"   : message,
        }
        $.ajax({
            type: "POST",
            url: "/controller/PostMessage.php",
            data: JSON.stringify(dataPost),
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    loadGuestMessage();
                    resetForm();
                } else {
                    alert('Error: ' + response.msg)
                }
                
            },
            error: function(error) {
                alert('Error: ' + error);
            }
        });
    });
    $("#footer").on("click", "ul > li.page", function(e) {
        var pageIndex = $(this).attr('value');
        if (pageIndex != undefined) {
            loadGuestMessage(pageIndex);
            togglePage(pageIndex);
            $("#footer").attr('current-page', pageIndex);
        };                
    });

    $("#footer").on("click", "ul > li.page.previos", function(e) {
        var pageIndex = parseInt($("#footer").attr('current-page')) - 1;
        if (pageIndex >= 1) {
            loadGuestMessage(pageIndex);
            togglePage(pageIndex);
            $("#footer").attr('current-page', pageIndex);
        };                
    });

    $("#footer").on("click", "ul > li.page.next", function(e) {
        var pageIndex = parseInt($("#footer").attr('current-page')) + 1;
        if (pageIndex <= ($("#footer ul > li.page").length - 2)) {
            loadGuestMessage(pageIndex);                    
            $("#footer").attr('current-page', pageIndex);
        };                
    });

    $('#content-wrapper').on('click', 'button.btnUpdate', function(e){
        var id = $(this).attr('data-id');
        var message = $('#message-' + id + ' .txtContentEdit').val();
        var current_page = $('#footer').attr('current-page');
        if ($.trim(message) == '') {
            alert('Please enter message!');
            return false;
        }
        var dataPost = {
            "id"      : id,
            "message" : message,
        }
        $.ajax({
            type: "POST",
            url: "/controller/UpdateMessage.php",
            data: JSON.stringify(dataPost),
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    loadGuestMessage(current_page);
                } else {
                    alert('Error: ' + response.msg)
                }
                
            },
            error: function(error) {
                alert('Error: ' + error);
            }
        });
    });

    $('#content-wrapper').on('click', 'button.btnDelete', function(e){
        var id = $(this).attr('data-id');
        var current_page = $('#footer').attr('current-page');
        var confirmed = confirm('Are you sure to delete this message?');
        if (!confirmed) {
            return false;
        }
        var dataPost = {
            "id"      : id,
        }
        $.ajax({
            type: "POST",
            url: "/controller/DeleteMessage.php",
            data: JSON.stringify(dataPost),
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    loadGuestMessage(current_page);
                } else {
                    alert('Error: ' + response.msg)
                }
                
            },
            error: function(error) {
                alert('Error: ' + error);
            }
        });
    });

    $('#btnLogin').on('click', function(e){
        var dataPost = {
            "username" : $('#txtUsername').val(),
            "password" : $('#txtPassword').val(),
        }
        $.ajax({
            type: "POST",
            url: "/controller/Login.php",
            data: JSON.stringify(dataPost),
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    window.location.reload();
                } else {
                    alert('Error: ' + response.msg)
                }
                
            },
            error: function(error) {
                alert('Error: ' + error);
            }
        });
    });

    $('#btnLogout').on('click', function(e){
        $.ajax({
            type: "POST",
            url: "/controller/Logout.php",
            data: {},
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    window.location.reload();
                } else {
                    alert('Error: ' + response.msg)
                }
                
            },
            error: function(error) {
                alert('Error: ' + error);
            }
        });
    });
    //load list message
    $('#content-wrapper').append(loaderHtml);
    loadGuestMessage();            
});