 $().ready(function () {
                // validate the comment form when it is submitted
                // 

                var formid = "";
                $('.cmxform').click(function () {
                    form_id = $(this).closest("form").attr('id');
                    formid = "#" + form_id;





                    $(formid).validate({
                        rules: {

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
                            agree: "Please accept our policy",
                            topic: "Please select at least 2 topics"
                        },
                        submitHandler: function (form)
                        {
                            var url = $('#url').attr("value");
                            //alert(url);
                            var value = $(form).serialize()
                            //value.value
                            $.ajax({
                                url: "<?= base_url() ?>" + url,
                                type: form.method,
                                data: value,
                                success: function (response) {
                                    // var obj = jQuery.parseJSON(response);
                                    console.log(response);
                                    $('#message').html(response);
                                    var result = $.parseJSON(response);
                                    $.each(result, function (key, value) {
                                        $( "#"+key ).addClass( "error" );
                                        $("#"+key).after(' <label class="error">'+value+'</label>');
                                    });
                                    // $("#username").after(' <p>- Are you suresdsdf  ?</p>');
                                    //$( "<p>sdfsdf sfd  sdfsf s</p>" ).appendTo( $( "#username" ) );
                                    /* var obj = $.parseJSON(response);
                                     $.each(obj, function () {
                                     district = this['district'];
                                     city = this['city'];
                                     ward = this['ward'];
                                     });
                                     var html = "<ul>";
                                     $.each(obj, function (index1, item1) {
                                     html += "<li>" + item1 + "</li>";
                                     });
                                     html += "</ul>";
                                     */
                                    //if(response=='success'){

                                    // }
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
                $("#username").focus(function () {
                    var firstname = $("#firstname").val();
                    var lastname = $("#lastname").val();
                    if (firstname && lastname && !this.value) {
                        this.value = firstname + "." + lastname;
                    }
                });

                //code to hide topic selection, disable for demo
                var newsletter = $("#newsletter");
                // newsletter topics are optional, hide at first
                var inital = newsletter.is(":checked");
                var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
                var topicInputs = topics.find("input").attr("disabled", !inital);
                // show when newsletter is checked
                newsletter.click(function () {
                    topics[this.checked ? "removeClass" : "addClass"]("gray");
                    topicInputs.attr("disabled", !this.checked);
                });
            });
