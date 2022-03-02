// Blog create
$('#create_blog').validate({
    rules: {
        category_id: {
            required: true,
        },
        title: {
            required: true,
        },
        description: {
            required: true,
        },
        image: {
            required: true,
        },
    },
    messages: {
        category_id: {
            required: "Category Required",
        },
        title: {
            required: "Title Required",
        },
        description: {
            required: "description Required",
        },
        image: {
            required: "Image Required",
        },

    },


});

//editblog
$('#edit_blog1').validate({
    rules: {
        category_id: {
            required: true,
        },
        title: {
            required: true,
        },
        description: {
            required: true,
        },
    },
    messages: {
        category_id: {
            required: "Category Required",
        },
        title: {
            required: "Title Required",
        },
        description: {
            required: "description Required",
        },


    },
});
//Comment Section
$("#comment-form").validate({
    rules: {
        comment: {
            required: true,
        },
        messages: {
            comment: {
                required: "This field is required",
            },
        }
    },
})
$('body').on('click', '.like', function() {
    var blog = $('.like').attr('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: like,
        method: "POST",
        data: {

            id: blog
        },
        success: function(data) {
            if (data.status == true) {
                $(".like").addClass('red');
            } else {
                $(".like").removeClass("red");
            }
        },
    })
})

$('body').on('submit', '#comment-form', function() {
    var comment = $('#comment').val();
    blog_id = "{{ $view->id }}"
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: comment_form,
        method: "POST",
        data: {

            comment: comment,
            id: blog_id
        },
        success: function(data) {
            console.log(data);
        }
    })
})

// Delete Comment
$('body').on('click', '.delete', function() {
    var id = $(this).attr('data-id');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: delete_cmnt,
        method: "POST",
        data: {

            id: id
        },
        success: function(data) {
            if (status == true) {}
            location.reload();
        }
    })
});

// reply
$('body').on('click', '.reply', function() {
    $('.reply').toggle();
    var thisClicked = $(this).attr('id');
    var cmt_id = $(this).attr('data-id');
    var route = reply;
    blog_id = "{{ $view->id }}";
    var html = `<div class="sidebar-item submit-comment">
                    <div class="content">
                        <form action="` + route + `" id="comment_reply_form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset>
                                    <textarea name="comment_reply" rows="6" id="comment_reply" placeholder="Type your comment" required></textarea>
                                    </fieldset>
                                </div>
                                <input type="hidden" name="blog_id" value="` + blog_id + `">
                                <input type="hidden" name="parent_id" value="` + cmt_id + `">
                                <div class="col-lg-12">
                                    <fieldset>
                                    <button type="submit" id="reply-submit"  data-id="` + cmt_id + `" class="main-button">Submit</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>`;
    $(this).after(html);
})
$('body').on('click', '#reply-submit', function() {
    var cmnt_id = $(this).attr('data-id');
    var comment = $('#comment_reply').val();
    blog_id = "{{ $view->id }}"
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: reply_submit,
        method: "POST",
        data: {

            parent_id: cmnt_id,
            blog_id: blog_id,
            comment: comment
        },
        success: function(data) {

        },
    });
});

//user verification email
$('#email').validate({

    rules: {
        email: {
            required: true,
        },
        messages: {
            email: {
                required: "email is required ",
            },
        }
    },
    submitHandler: function(form) {
        $(".submit").html("Please Wait");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{route('user.getEmail')}}",
            method: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function(data) {

                if (data.status == true) {
                    $(".submit").html("Send Otp");
                    alert(data.message);
                    window.location.href = 'get_otp' + '/' + data.data.id;

                } else {
                    alert(data.message);
                }


            },

        });
    }

});
// RegisterSection
$('#category').on('change', function() {
    var catId = $(this).val();
    // console.log(catId);
    $.ajax({
        url: getCat,
        method: "GET",
        data: {
            catId: catId
        },
        dataType: 'JSON',
        success: function(data) {
            // console.log(data);
            $.each(data.data, function(key, value) {
                $("#subcategory").append('<option value="' + value.id + '">' + value
                    .subcategory_name + '</option>');
            });
        }
    })

})

// $('#register_form').validate({

//     rules: {
//         firstname: {
//             required: true,
//         },
//         lastname: {
//             required: true,
//         },
//         email: {
//             required: true,
//         },
//         category: {
//             required: true,
//         },
//         subcategory: {
//             required: true,
//         },
//         password: {
//             required: true,
//         },
//         profile: {
//             required: true,
//         },
//     },
//     messages: {
//         firstname: {
//             required: "Firstname is required ",
//         },
//         lastname: {
//             required: "Lastname is required",
//         },
//         email: {
//             required: "Email is required",
//         },
//         category: {
//             required: "Category is required",
//         },
//         subcategory: {
//             required: "SubCategory is required",
//         },
//         password: {
//             required: "Password is required",
//         },
//         profile: {
//             required: "Profile is required",
//         },
//     },
//     submitHandler: function(form) {

//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//             },

//             url: register,
//             method: "POST",
//             data: new FormData(form),
//             contentType: false,
//             cache: false,
//             processData: false,
//             dataType: 'JSON',
//             success: function(data) {

//                 window.location.href = 'verify_register_user' + '/' + data.id;

//             },
//             error: function(error) {
//                 var i;
//                 var res = error.responseJSON.errors;
//                 $.each(res, function(key, value) {
//                     toastr.error(value)
//                 });
//             }
//         })
//     },

// });


// Reset Password
$('#reset').validate({
    rules: {
        pass: {
            required: true,
        },
        cpass: {
            required: true,
            equalTo: '#pass'
        },
    },
    messages: {
        pass: {
            required: "please Enter Passwoord ",
        },
        cpass: {
            required: "Please Enter Confirm Password",
            equalTo: 'Confirm Password must be same as Password',
        },
    },
    submitHandler: function(form) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: confirm_pass,
            method: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status == true) {
                    alert(data.message)
                }
                window.location.href = '/user/login';

            }


        });

    }


});
// Update User
$('#update_form').validate({
    rules: {
        firstname: {
            required: true,
        },
        lastname: {
            required: true,
        },
        email: {
            required: true,
        },
        category: {
            required: true,
        },
        subcategory: {
            required: true,
        },
        password: {
            required: true,
        },

    },
    messages: {
        firstname: {
            required: "Firstname is required ",
        },
        lastname: {
            required: "Lastname is required",
        },
        email: {
            required: "Email is required",
        },
        category: {
            required: "Category is required",
        },
        subcategory: {
            required: "SubCategory is required",
        },
        password: {
            required: "Password is required",
        },

    },
    submitHandler: function(form) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },

            url: user_update,
            method: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                alert(data.message);
                window.location.href = '/dashboard';
            },
            error: function(error) {
                var i;
                var res = error.responseJSON.errors;
                $.each(res, function(key, value) {
                    toastr.error(value);
                });
            }
        })

    },

});
$(".update").on('click', function() {

    var id = $(this).attr('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: user_edit,
        method: "post",
        data: {

            id: id,
        },
        dataType: 'JSON',
        success: function(data) {

            $('#id').val(data.data.user.id);
            $('#firstname').val(data.data.user.firstname);
            $('#lastname').val(data.data.user.lastname);
            $('#email').val(data.data.user.email);
            $("#category").html('');
            $.each(data.data.Category, function(key, value) {
                selectdata = (value.id == data.data.user.category_id) ? 'selected' : '';
                $("#category").append('<option value="' + value.id + '" ' + selectdata +
                    '>' + value.category_name + '</option>');
            });
            $("#subcategory").html('');
            console.log(data.data.subcategory);
            $.each(data.data.subcategory, function(key, value) {
                selectdata = (value.id == data.data.user.subcategory_id) ? 'selected' : '';
                $("#subcategory").append('<option value="' + value.id + '"' +
                    selectdata + '>' + value.subcategory_name + '</option>');
            });

            if (data.data.user.profile == '') {
                $('#profile').html(
                    '<img src="images/default/default.jpg" height="50px" width="50px" />');
            } else {
                $('#profile').html('<img src="' + /images/ + data.data.user.profile +
                    '"height="50px" width="50px"/>');
            }

        }


    })
});
$('body').on('change', '#category', function() {
        var id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: get_subCat,
            method: "post",
            data: {
                id: id,
            },
            dataType: 'JSON',
            success: function(data) {
                $("#subcategory").html('');
                if (data.status == true) {
                    $.each(data.data, function(key, value) {
                        $("#subcategory").append('<option value="' + value.id + '">' + value
                            .subcategory_name + '</option>');
                    });
                }
            }
        })

    })
    //verify User
$('#otp').validate({

    rules: {
        otp: {
            required: true,
        }
    },
    messages: {
        otp: {
            required: "Please enter otp first",
        }
    },
    submitHandler: function(form) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },

            url: otpVerify,
            method: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function(data) {

                if (data.status == true) {
                    alert(data.message);
                    window.location.href = '/home';
                } else {
                    alert(data.message);

                }

            }
        });
    }
});
// Product filter

// Currency converter
var from;
$("#currency").on('focus', function() {
    // e.preventDefault();
    from = this.value;
}).change(function() {
    var to = this.value;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: currency,
        method: "POST",
        data: {

            from: from,
            to: to
        },
        success: function(data) {
            console.log(data);
            $(".product-data").html('');
            $.each(data.data, function(key, value) {
                if (value.session_val == "EUR") {
                    $(".product-data").append(`<div class="col-lg-6">
                              <div class="blog-post">
                                  <div class="blog-thumb">
                                      <img src="` + /images/ + value.image + `"/> 
                                  </div>
                                  <div class="down-content">
                                          <span id=""> ` + value.category.name + `</span>
                                      <a href="#">
                                          <h4>` + value.name +
                        `</h4>
                                      </a>
                                          <span class="converted-currency" name="currency"> <i class="fa fa-euro">` +
                        +
                        value.new_price + `</i> 
                                      </span>
                                  </div>
                              </div>
                          </div>`);
                } else {
                    $(".product-data").append(`<div class="col-lg-6">
                              <div class="blog-post">
                                  <div class="blog-thumb">
                                      <img src="` + /images/ + value.image + `"/> 
                                  </div>
                                  <div class="down-content">
                                          <span id=""> ` + value.category_name + `</span>
                                      <a href="#">
                                          <h4>` + value.name +
                        `</h4>
                                      </a>
                                          <span class="converted-currency" name="currency"> <i class="fa fa-rupee">` +
                        value.price + `</i> 
                                      </span>
                                  </div>
                              </div>
                          </div>`);
                }
            });
        }
    })
});

// Add To cart
$('body').on('click', '.cart', function() {
        var id = $(this).attr('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: cart,
            method: "POST",
            data: {

                id: id,
            },
            success: function(data) {
                if (data.status == true) {
                    toastr.success(data.msg)
                        .delay(500)
                }

            }
        })
    })
    //  Payment