/*--------------------- Copyright (c) 2020 -----------------------
[Master Javascript]
Project: E Academy
Version: 1.0.0
Assigned to: Theme Forest
-------------------------------------------------------------------*/
(function ($) {
	"use strict";
	/*-----------------------------------------------------
		Function  Start
	-----------------------------------------------------*/
	var rzp_key ="rzp_live_eVhpmENtjt90wU";
		var Education = {
			initialised: false,
			version: 1.0,
			mobile: false,
			init: function () {
				if (!this.initialised) {
					this.initialised = true;
				} else {
					return;
				}
				/*-----------------------------------------------------
					Function Calling
				-----------------------------------------------------*/
				this.preLoader();
				this.popupFix();
			},

			/*-----------------------------------------------------
				Fix PreLoader
			-----------------------------------------------------*/
			preLoader: function () {
				jQuery(window).on('load', function() {
					jQuery(".edu_preloader").fadeOut();
				});
			},
			
    		
    		/*-----------------------------------------------------
    			Fix Popup Image
    		-----------------------------------------------------*/
    		
    		popupFix: function () {
            	$('.openPopupLink').magnificPopup({
                  type: 'inline',
                  midClick: true,
                  mainClass: 'mfp-fade'
                });
            },
    		
        };

		Education.init();

		/* Login Js */

		$(document).ready(function(){
				$('[data-action="submitThisForm"]').on('click' , function(){
				var targetForm = $(this).closest('form');
				if(!myCustom.checkFormFields(targetForm)){
					myCustom.callFormAjax(targetForm).done(function(res){
						var resp = $.parseJSON(res);
						if(resp.status == 1){
							if(typeof targetForm.attr('data-reset') != 'undefined' && targetForm.attr('data-reset') == 1){ //check reset form data
								targetForm[0].reset();
							}
							if(typeof targetForm.attr('data-redirect') != 'undefined'){ //check reset form data
								if(resp.msg != '')
									toastr.success(resp.msg)
									
									if($('#batchIdDisplay').val() != ''){
									    $('.enrollNowSubmit').trigger('click');
									}else{
    								    setTimeout(function(){
    								        location.href = resp.url;
    								    },1500)
									} 
							}else if(resp.msg){
								toastr.success(resp.msg);
							}
						}else if(resp.status == 2){
							$.magnificPopup.open({
								items: {
									src: '#studentLogin',
								},
								type: 'inline'
							});
							$('#studentLogin .changeStudentLogin').attr('data-id',resp.student_id);
						}
						else if(resp.status == 0){
							toastr.error((resp.msg)?resp.msg:resp.error);
						}
					});
				}
			});
			
			
    $('.enrollNowSubmit').on('click', function() { 
			 //   alert($('#batchIdDisplay').val());
        var formdata = new FormData();
        formdata.append('batchId', $('#batchIdDisplay').val());
        formdata.append('email', $('#email').val());
        formdata.append('name', $('#name').val());
        formdata.append('mobile', $('#mobile').val());
        formdata.append('state', $('#state').val());
        formdata.append('city', $('#city').val());
      
        // 		formdata.append('mobile','');

        var valid_check = validate_form($(this).closest('form'));
        var form = $(this).closest('form');
   if (valid_check === 'valid') {
    $('.edu_preloader').css('background-color', 'rgba(255,255,255,0.80)').css('display', 'block');
    $.ajax({
        method: "POST",
        url: base_url + 'front_ajax/enroll_check',
        data: new FormData(form[0]), // Use FormData to correctly serialize the form data
        processData: false,
        contentType: false,
        success: function(resp) {
            try {
                var resp = $.parseJSON(resp); // Parse JSON inside a try-catch block
                if (resp['status'] === '1') {
                    if (resp['payment_type'] === '1') {
                // console.log(resp);
                        $('.edu_preloader').fadeOut();
                        var data = resp['data'];
                        var amount = localStorage.getItem('myData'); 
                        
                        alert (amount);
                        razorpay_form(amount, data['batchId'], data['name'], data['email'], data['mobile'], data['state'], data['city']);
                    } else {
                        window.setTimeout(function() {
                            // alert('here');
                            // window.location.href = resp['url'];
                        }, 1000);
                    }
                } else if (resp['status'] === '2') {
                    toastr.success("Course purchased successfully.");
                    window.setTimeout(function() {
                        window.location.href = base_url + 'student/my-course';
                    }, 1000);
                } else {
                    toastr.error(resp['msg']);
                }
                $('.edu_preloader').fadeOut();
            } catch (e) {
                console.error("Error parsing JSON response: ", e);
                toastr.error("Invalid response from server.");
                $('.edu_preloader').fadeOut();
            }
        },
        error: function() {
            toastr.error("Something went wrong, please try again.");
            $('.edu_preloader').fadeOut();
        }
    });
        }
    });
    
    function validate_form(target) {
        var check = 'valid';
        target.find('input , textarea , select').each(function() {
            var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            var url = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
            var websiteUrl = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
            var image = /\.(jpe?g|gif|png|PNG|SVG|svg|JPE?G)$/;
            var images = /\.(jpe?g|png|PNG|JPE?G)$/;
            var video = /\.(flv|avi|mov|mpg|wmv|m4v|mp4|mp3|wma|3gp)$/;
            var mobile = /((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/;
            var facebook = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
            var twitter = /^(https?:\/\/)?(www\.)?twitter.com\/[a-zA-Z0-9(\.\?)?]/;
            var google_plus = /^(https?:\/\/)?(www\.)?plus.google.com\/[a-zA-Z0-9(\.\?)?]/;
            var number = /^[\s()+-]*([0-9][\s()+-]*){1,20}$/;
            var password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#])[A-Za-z\d$@$!%*?&#]{8,}$/;
            var pdfimage = /\.(xls|XLS|XLSX|xlsx|PPT|ppt|PPTX|pptx||doc|DOC|DOCX|docx|pdf|PDF)$/;
            var float_num = /^[-+]?[0-9]+\.[0-9]+$/;
            //var youtube = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var youtube =   /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|live\/)|youtu\.be\/)[\w\-\_]{11}(\?[\w\-\_=&]*)?$/;

            var vimeo = /^.*((http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)).*/;
            var TagReg = /[<>`;&=+/()|^%*+]/g;
            var text_only = /^[a-zA-Z ]*$/g;

            var dropbox = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?([a-z0-9]+([\-\.]dropboxusercontent)|dropbox)\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            var embed = /embed/g;
            var excel = /\.(xlsx)$/;
            if ($(this).hasClass('require')) {

                if ((typeof $(this).val() == 'object' && isEmpty($(this).val()) == true) || (typeof $(this).val() != 'object' && $(this).val().trim() == '')) {
                    toastr.error('Some required fields are missing.');
                    $(this).addClass('error').focus();
                    if ($('.edu_accord_parent').length)
                        $(this).closest('.edu_accord_parent').addClass('error');
                    check = 'novalid';
                    return false;
                } else {
                    $(this).removeClass('error');
                    if ($('.edu_accord_parent').length)
                        $(this).closest('.edu_accord_parent').removeClass('error');
                    check = 'valid';
                }
            }

            if ((typeof $(this).val() == 'object' && isEmpty($(this).val()) == true) || (typeof $(this).val() != 'object' && $(this).val().trim() != '')) {
                var valid = $(this).attr('data-valid');
                if (typeof valid != 'undefined') {
                    if (!eval(valid).test($(this).val().trim())) {
                        $(this).addClass('error').focus();
                        toastr.error($(this).attr('data-error'));
                        check = 'novalid';
                        return false;
                    } else {
                        $(this).removeClass('error');
                        check = 'valid';
                    }
                }
            }

        });
        return check;
    }
    
function razorpay_form(totalAmount, product_id, name, email, mobile, state, city) {
    var options = {
        "key": rzp_key,
        "amount": totalAmount * 100, // Convert amount to paise
        "name": name,
        "image": site_logo,
        "handler": function(response) {
            console.log(response);
            $.ajax({
                url: base_url + 'front_ajax/razorPaySuccess',
                type: 'post',
                dataType: 'json',
                data: {
                    razorpay_payment_id: response.razorpay_payment_id,
                    totalAmount: totalAmount,
                    product_id: product_id,
                    name: name,
                    email: email,
                    mobile: mobile,
                    state: state,
                    city: city,
                },
                success: function(msg) {
                    toastr.success("Course purchased successfully.");
                    window.setTimeout(function() {
                        window.location.href = base_url + 'student/my-course';
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    toastr.error("Payment failed. Please try again.");
                }
            });
        },
        "theme": {
            "color": "#528FF0"
        },
        "prefill": {
            "name": name,
            "email": email,
            "contact": '91' + mobile
        },
        "modal": {
            "ondismiss": function() {
                 window.location.href = base_url + 'student/dashboard';
                toastr.info("Payment process cancelled.");
            }
        }
    };

    var rzp1 = new Razorpay(options);

    // Attach an event listener for errors (if available)
    rzp1.on('payment.failed', function(response) {
        toastr.error("Payment failed: " + response.error.description);
    });

    rzp1.open();
}


			
			$(document).keypress('#auth_login',function(event){
				var keycode = (event.keyCode ? event.keyCode : event.which);
				if(keycode == '13'){
					$('[data-action="submitThisForm"]#auth_login').trigger('click');
				}
			});
		
			$(document).on('click','.PopupCancelBtn',function(){
				$('#studentLogin').find('.mfp-close').trigger('click');
			}); 
		
			$(document).on('click','.changeStudentLogin',function(){
				$.ajax({
					method: "POST",
					url: $('#base_url').val()+'front_ajax/change_student_status',
					data: {'id':$(this).attr('data-id')},
					success: function(resp){
						if(resp == '1'){
							$('[data-action="submitThisForm"]#auth_login').trigger('click');
						}else{
							toastr.error(ltr_something_msg);
						}
					},
					error:function(resp){
						toastr.error(ltr_something_msg);
					}
				});
			}); 
		
		});
		// SRART code stop ctrl+U and right click

/*document.addEventListener("contextmenu", function(e){ e.preventDefault(); }, false); 
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            ( 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
            return false;
        } else {
            return true;
        }
};
$(document).keypress("u",function(e) {
  if(e.ctrlKey)
  {
return false;
}
else
{
return true;
}
});*/

// END code stop ctrl+U and right click

})(jQuery);
