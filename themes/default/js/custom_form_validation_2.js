 $().ready(function () {
                // validate the comment form when it is submitted
                // 

                var formid = "";
                $('.cmxform').click(function () {
                    form_id = $(this).closest("form").attr('id');
                    formid = "#" + form_id;





                    $(formid).validate({
                        rules: {
                            username: {
                                required: true,
                                minlength: 2,
                                remote: {
                                    url: "<?= base_url() ?>main/check",
                                    type: "post",
                                    data: {
                                        username: function () {
                                            return $("#username").val();
                                        }
                                    }
                                }
                            },
                            city: {
                                validateCity: true
                            },
                            

                            
                            topic: {
                                required: "#newsletter:checked",
                                minlength: 2
                            },
                            agree: "required"
                        },
                        messages: {
                            firstname: "Please enter your firstname",
                            lastname: "Please enter your lastname",
                            username: {
                                required: "Please enter a username",
                                minlength: "Your username must consist of at least 2 characters",
                                remote: "User Name already in use! Try another"
                            },

                            
                            agree: "Please accept our policy",
                            topic: "Please select at least 2 topics"
                        },
                        submitHandler: function (form)
                        {
                            var url = $('#url').attr("value");
                            alert(url);
                            var value = $(form).serialize()
                            //value.value
                            $.ajax({
                                url: "<?= base_url() ?>" + url,
                                type: form.method,
                                data: value,
                                success: function (response) {
                                    
                                    $('#message').html(response);
                                    var result = $.parseJSON(response);
                                    $.each(result, function (key, value) {
                                        $( "#"+key ).addClass( "error" );
                                        $("#"+key).after(' <label class="error">'+value+'</label>');
                                    });

                                }
                            });
                        }
                    });
                    $.validator.addMethod("validateCity", function (value, element) {
                        return this.optional(element) || value != 'default';
                    }, 'Please Select Any one');

                });
                // validate signup form on keyup and submit

                // propose username by combining first- and lastname
                
            });


