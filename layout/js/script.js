$(function () {
    'use strict';
    // to hide a placeholder when the user focus in field.
    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // To show and hide the details of task
    $('.do-list li').click(function () {
        $(this).children('.do-list li .detail').fadeToggle(200);
    });

    // To change form between the login form and sign up form.
    $('.logForm .log').click(function (){
        // We built data-class attribute to differece between the login and sign up form
        if($(this).data('class') === 'login'){
            $('.signForm').fadeOut(0);
            $('.loginForm').fadeIn(100);
        }else{
            $('.loginForm').fadeOut(0);
            $('.signForm').fadeIn(100);
        }
        // to add active class to no the active form currently.
        $(this).addClass('active').siblings('.log').removeClass('active');
    });
    $('.logForm .password .fa-eye').click(function (){
        // We change the type to appear the password
        if($('.logForm .password input').attr('type') === 'password'){
            $('.logForm .password input').attr('type', 'text');
            $('.logForm .password .fa-eye').css({
                color: '#000',
                textDecoration: 'none'
            });
        }else{
            $('.logForm .password input').attr('type', 'password');
            $('.logForm .password .fa-eye').css({
                color: '#aaa',
                textDecoration: 'line-through'
            });
        }
    });

    // To appear the eye icon in password field when the user starts write in it.
    $('.logForm .password input').keyup(function (){
        var display = $(this).val().length > 0 ? 'block' : 'none';
        $(this).siblings('.logForm .password .fa-eye').css("display", display);
    });

    // Hide the alert after 3 second in the bottom of page.
    $('.errors').delay(3000).slideUp(100);

    // To appear browse surely alert when the user wants to delete task of reset the tasks.
    $('.confirm').click( function () {
        return confirm("Are you sure ? ");
    });
});
