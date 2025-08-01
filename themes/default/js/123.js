$().ready(function () {
    var formid = "";
    $('.cmxform').click(function () {
        form_id = $(this).closest("form").attr('id');
        formid = "#" + form_id;
        $(formid).validate({
            rules: {
                productcode: {required: true, minlength: 3,
                    remote: {
                        url: URL + "checkProductCode", type: "post",
                        data: {productcode: function () {
                                return $("#productcode").val();
                            }}
                    }
                },
                userfile: {
                    extension: "jpg|jpeg|png|gif",
                    filesize: 1000000
                },
                document_file: {
                    required: true,
                    extension: "pdf|doc|docx|jpg|jpeg|png|xls|xlsx",
                    filesize: 3000000
                },
                profile_img: {
                    extension: "jpg|jpeg|png|gif",
                    filesize: 1000000
                },
                // pro_code: {required: true, minlength: 3,
                //     remote: {
                //         url: URL + "checkProductCode", type: "post",
                //         data: {pro_code: function () {
                //                 return $("#pro_code").val();
                //             }}
                //     }
                // },
                customer_code: {required: true, minlength: 3,
                    remote: {
                        url: URL + "customer_settings/customer/checkCustomerCode", type: "post",
                        data: {customer_code: function () {
                                return $("#customer_code").val();
                            }}
                    }
                },
                unit_type_name: {required: true,
                    remote: {
                        url: URL + "product_settings/otherConfigurations/checkUnitType", type: "post",
                        data: {unit_type_name: function () {
                                return $("#unit_type_name").val();
                            }}
                    }
                },
                supplier_code: {minlength: 3,
                    remote: {
                        url: URL + "check_supplier_code", type: "post",
                        data: {supplier_code: function () {
                                return $("#supplier_code").val();
                            }}
                    }
                },
                emp_email: {required: true, email: true, customemail: true,
                    remote: {
                        url: URL + "check_employee_email", type: "post",
                        data: {emp_email: function () {
                                return $("#emp_email").val();
                            }}
                    }
                },
                emp_username: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_employee_username", type: "post",
                        data: {emp_username: function () {
                                return $("#emp_username").val();
                            }}
                    }
                },
                station_name: {required: true, specialChar: true
                    // remote: {
                    //     url: URL + "check_station_name", type: "post",
                    //     data: {station_name: function () {
                    //             return $("#station_name").val();
                    //         }}
                    // }
                },
                brand_name: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_brand_name", type: "post",
                        data: {brand_name: function () {
                                return $("#brand_name").val();
                            }}
                    }
                },
                category_name: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_cagegory_name", type: "post",
                        data: {category_name: function () {
                                return $("#category_name").val();
                            }}
                    }
                },
                pro_name: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_product_name", type: "post",
                        data: {pro_name: function () {
                                return $("#pro_name").val();
                            }}
                    }
                },
                reason_name: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_reason_name", type: "post",
                        data: {reason_name: function () {
                                return $("#reason_name").val();
                            }}
                    }
                },
                cus_type_name: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_customer_type_name", type: "post",
                        data: {cus_type_name: function () {
                                return $("#cus_type_name").val();
                            }}
                    }
                },
                bank_name: {required: true, minlength: 3,
                    remote: {
                        url: URL + "check_bank_name", type: "post",
                        data: {
                            bank_name: function () {
                                return $("#bank_name").val();
                            },
                            bank_type: function () {
                                return $("#bank_type").val();
                            },
                            hid: function () {
                                return $("#hid").val();
                            }
                        }
                    }
                },
                'p_qty[]':{required: true},
                'p_supplier[]': {validatecategory: true},
                check_address: {required: true},
                ref_id1: {validatecategory: true},
                bank_type: {required: true},
                acc_type: {required: true},
                acc_uses: {required: true},
                initial_balance: {required: true},
                name: {required: true},
                city: {validateCity: true},
                password: {required: true, minlength: 5},
                min_stock: {number: {depends: isMinStock}},
                confirm_password: {required: true, minlength: 5, equalTo: "#password"},
                email: {required: true, email: true, customemail: true},
                edit_email: {required: true, email: true, customemail: true},
                phone: {required: true,  number: true},
                edit_phone: {required: true,  number: true},
                number: {required: true, number: true},
                edit_number: {required: true, number: true},
                gender: {required: true},
                edit_gender: {required: true},
                topic: {required: "#newsletter:checked", minlength: 2},
                vat: {required: true, number: true},
                unit: {validateUnit: true},
                cat_type: {validateUnit: true},
                buying_price: {required: true, number: true},
                category: {validatecategory: true},
                store_name: {validatecategory: true},
                edit_category: {validatecategory: true},
                brands: {validatebrands: true},
                discount: {number: true},
                target_sales_volume: {required: true, number: true},
                full_name: {required: true},
                edit_full_name: {required: true},
                address_type: {validateAddressType: true},
                edit_address_type: {validateAddressType: true},
                city_division: {validateCityDivision: true},
                address_location: {validateAddressLocation: true},
                city_division1: {validateCityDivision: true},
                edit_address_location: {validateAddressLocation: true},
                //addr_line_1: {required: true},
               // edit_addr_line_1: {required: true},
                edit_customer_name: {required: true},
                customer_type_id: {validateCustomerType: true},
                edit_customer_type_id: {validateCustomerType: true},
                document_name: {required: true},
                //document_description: {required: true},
                edit_document_name: {required: true},
               // edit_document_description: {required: true},
                //document_file: {required: true},
                contact_person: {required: true},
                edit_contact_person: {required: true},
                f_date: {required: true},
                t_date: {required: true},
                edit_f_date: {required: true},
                edit_t_date: {required: true},
                store_id: {required: true},
                delivery_type: {validatecategory: true},
                agent_name: {validatecategory: true},
                delivery_person: {validatecategory: true},
                service_name: {validatecategory: true},
                service_range: {validatecategory: true},
                service_accounts: {validatecategory: true},
                service_price: {required: true,number: true},
            },
            messages: {
                userfile: {
                    extension:"Please select only jpg,jpeg,png,gif files"
                },
                profile_img: {
                    extension:"Please select only jpg,jpeg,png,gif files"
                },
                document_file: {
                    required: "Please select file.",
                    extension:"Please select only jpg,jpeg,png,gif,pdf,xls,xlsx,doc,docx files"
                },
                name: "This field is required.",
                lastname: "Please enter your lastname",
                productcode: {required: "Please enter a username", minlength: "Your username must consist of at least 3 characters", remote: "User Name already in use! Try another"},
               // pro_code: {required: "This field is required", minlength: "You must consist of at least 3 characters", remote: "This code already in use! Try another"},
                unit_type_name: {required: "This field is required", remote: "This code already in use! Try another"},
                password: {required: "Please provide a password", minlength: "Your password must be at least 5 characters long"},
                confirm_password: {required: "Please provide a password", minlength: "Your password must be at least 5 characters long", equalTo: "Please enter the same password as above"},
                email: {required: "Please Enter Email!", email: "This is not a valid email!"},
                emp_email: {required: "Please Enter Email!", email: "This is not a valid email!", remote: "This email already in use! Try another"},
                //station_name: {required: "This field is required", remote: "This name already in use! Try another"},
                station_name: {required: "This field is required"},
                emp_username: {required: "This field is required", minlength: "You must consist of at least 3 characters", remote: "This username already in use! Try another"},
                phone: {required: "Please provide a Phone Number", number: "Please enter Valid Phone Number"},
                number: {required: "Please enter Number", number: "Please enter Number only."},
                gender: {required: "Please select your gender"},
                agree: "Please accept our policy",
                topic: "Please select at least 2 topics",
                brand_name: {required: "Please enter a Brand Name", minlength: "You name consist of at least 3 characters", remote: "This name already in use! Try another"},
                category_name: {required: "This field is required", minlength: "You name consist of at least 3 characters", remote: "This name already in use! Try another"},
                pro_name: {required: "This field is required", minlength: "You name consist of at least 3 characters", remote: "This name already in use! Try another"},
                reason_name: {required: "This field is required", minlength: "You name consist of at least 3 characters", remote: "This name already in use! Try another"},
                cus_type_name: {required: "This field is required", minlength: "You name consist of at least 3 characters", remote: "This name already in use! Try another"},
                unit: "This Field is Required",
                vat: {required: "This Field is Required", number: "Please enter Number only."},
                buying_price: {required: "This Field is Required", number: "Please enter Number only."},
                discount: {required: "Please enter Discount", number: "Please enter Number only."},
                target_sales_volume: {required: "Please enter Sales Target", number: "Please enter Number only."},
                full_name: {required: "Please enter full name."},
                //addr_line_1: {required: "Please select address location."},
                //document_file: {required: "Please select file."},
                customer_code: {required: "This field is required", minlength: "You must consist of at least 3 characters", remote: "This ID already in use! Try another"},
                contact_person: {required: "Please enter contact person name."},
                supplier_code: {minlength: "You must consist of at least 3 characters", remote: "This code already in use! Try another"},
                bank_name: {required: "Please enter a Bank name", minlength: "Name should be least 3 characters", remote: "This name already in use! Try another"},
                bank_type: {required: "Please select Bank type"},
                store_id: {required: "Please select Store"}
            }
        });
        $.validator.addMethod("validateUnit", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validatecategory", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validatebrands", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validateCity", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validateAddressType", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validateCustomerType", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validateCityDivision", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("validateAddressLocation", function (value, element) {
            return this.optional(element) || value != '0';
        }, 'Please Select Any one');
        $.validator.addMethod("customemail", function (value, element) {
            return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
        }, "Please enter a valid email address.");

        $.validator.addMethod("specialChar", function (value, element) {
            return this.optional(element) || /([0-9a-zA-Z\s])$/.test(value);
        }, "Special Character not supported.");
        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        },"Please enter a value with a valid extension.");
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');

    });
    function isMinStock() {
        return $('#min_stock').val().length > 0;
    }
});