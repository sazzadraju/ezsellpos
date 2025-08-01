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
                        invalidHandler: function() {
                            var validator;
                            var errors = validator.numberOfInvalids();
                            $('#error_check').val(errors);
                            alert(errors)
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
