(function( $, window, document, undefined ) {
	//constant 
	maxAmount = 0;
	$('.carousel').carousel({interval: 2500});

	$(document).on('click','.addbountycheckbox', function(){

		$(".bounty-field [name='amount']").attr("placeholder",""); 
		if($(".addbountycheckbox input").is(':checked'))
		    setFieldEnabled(".bounty-field");  // checked
		else
		    setFieldDisabled(".bounty-field");  // unchecked
	});

	$(document).on("click change mouseenter mouseout",'form #postTitle', function(){
		getval = $(this).val();
		if(getval == ""){
			$(this).val("Find me ");
		}
	});
	$(document).on("change", "[name='walletType']", function(){
		jsonWallet = $(this).find("option:selected").data("wallet");
		maxAmount = 0;
		if(!$.isEmptyObject(jsonWallet))
			maxAmount  = jsonWallet.balance_amount;

		$("[name='amount']").attr("placeholder",maxAmount);
		$("[name='amount']").rules("add", {
        	max: maxAmount
   		 });
	})
	jQuery(document).ready(function($){
		$('#tokenfield').tokenfield({
		  allowDuplicates: false
		});

		$('.has-tooltip').tooltip();

		$('select[name="searchType"]').on('change',function(){
			if($(this).val()=="cat"){
				$('#inputKey').hide();
				$('#dropKey').show().focus();
			}
			else{
				$('#dropKey').hide();
				$('#inputKey').show().focus().val("");
			}
		});

		jQuery.validator.addMethod("notEqual", function(value, element, param) {
		  return this.optional(element) || value != param;
		}, "Please specify a different (non-default) value");

		$('#add-new-post').validate({
			errorClass: "has-error",
			messages: {
				category: "Please enter category",
				postTitle: "Please enter post title",
				postContent: "Please enter post description",
				walletType: "Please select a wallet type",
				amount:{
					required: "Please enter a valid amount",
					number: "Please enter a valid amount",
					min: "Please enter a number greater than 1",
					max: "Reward point exceeded your wallet's balance"
				}
			},
			rules: {
			    category: {
			      required: true
			    },
			    postTitle: {
			      required: true,
			      notEqual: "Find me "
			    },
			    postContent: {
			      required: true
			    },
			    walletType:{
			    	required:true,	
			    },
			    amount:{
			    	required:true,
			    	number:true,
			    	min:1
			    }
			}
		});

	});

	function setFieldDisabled(box){
		$(box).hide();
		fields = $(box).find("input, select");
		$.each(fields, function(){
			$(this).attr("disabled","disabled");
			$(this).val("");
		})
		
	}

	function setFieldEnabled(box){
		$(box).fadeIn();
		$(box).find("input, select").removeAttr("disabled");
	}

})( jQuery, window, document );
