
(function ($) {
    "use strict";


    /*==================================================================
     [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })
    })


    /*==================================================================
     [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
            hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

    /*==================================================================
     [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('zmdi-eye');
            $(this).find('i').addClass('zmdi-eye-off');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('zmdi-eye');
            $(this).find('i').removeClass('zmdi-eye-off');
            showPass = 0;
        }

    });


})(jQuery);

$(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if (
        $(this)
            .parent()
            .hasClass("active")
    ) {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
            .parent()
            .removeClass("active");
    } else {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
            .next(".sidebar-submenu")
            .slideDown(200);
        $(this)
            .parent()
            .addClass("active");
    }
});

$("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function() {
    $(".page-wrapper").addClass("toggled");
});

$(function()
{
    $('nav a[href^="/category' + location.pathname.split("/")[1] + '"]').addClass('active');
});

$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

        });
    });
    document.documentElement.setAttribute('theme', $.cookie('theme'));
});


    const toggleBtn = document.querySelector("#toggle-theme");
    toggleBtn.addEventListener('click', (e) => {
        console.log("Switching theme");
        if ($.cookie('theme') == 'dark'){
            document.documentElement.setAttribute('theme', 'light');
            $.cookie('theme', 'light');
        }
        else
        {
            document.documentElement.setAttribute('theme','dark');
            $.cookie('theme','dark');
        }
});









/*
$(document).ready(function () {
    $('#categories').click(function()
        {
            event.preventDefault();
            $.ajax({
                type:"GET",
                url:"/category",
                async: true,
                success: function(category)
                {
                    $('#lay1').html(category);
                    getVideos();
                }
            });
        });

    $('#genres').click(function () {
        {
            event.preventDefault();
            $.ajax({
                type:"GET",
                url:"/genre",
                async: true,
                success: function(gen)
                {
                    $('#lay1').html(gen);
                }
            });
        }
    });


    function  getVideos() {
        $('.getVideo').click(function () {
            event.preventDefault();
            $.ajax({
                type:"GET",
                url: $(this).attr("href"),
                async: true,
                success: function(showww)
                {
                    $('#lay2').html(showww);
                }
            });
        });
    }

    getVideos();


    function  getVideos() {
        $('.getVideo').click(function () {
            event.preventDefault();
            $.ajax({
                type:"GET",
                url: $(this).attr("href"),
                async: true,
                success: function(showww)
                {
                    $('#lay2').html(showww);
                }
            });
        });
    }
    getVideos();
});


/!*
function getCat()
{
    event.preventDefault();
    $.ajax({
        type:"GET",
        url:"/category",
        async: true,
        success: function(category)
        {
            $('#lay1').html(category);
        }
    });
}

function getGen()
{
    event.preventDefault();
    $.ajax({
        type:"GET",
        url:"/genre",
        async: true,
        success: function(gen)
        {
            $('#lay1').html(gen);
        }
    });
}
*!/
*/
