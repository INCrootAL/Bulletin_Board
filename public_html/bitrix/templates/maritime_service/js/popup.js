var pwShown_input1 = 0;
var pwShown_input2 = 0;

document.addEventListener("click", function(e) {
    $(document).ready(function() {
    	$("#popup_wrapper .overlay, #popup_wrapper .close").bind("click", function() {
    		$("body").removeClass("hiddens");
    		$("#popup_wrapper").removeClass("active");
    		$(".popup").removeClass("active");
    		$("#page").removeClass("blured");
    		
    		var c = document.getElementById('bx-auth-reg-input-dop');
    		//alert(c);
    		if ( c !== null && c.getAttribute("type") == "text") {
    		    c.setAttribute('type', 'password');
    		    document.getElementById("eye_new_dop").classList.remove("active");
    		}
    		
            var p = document.getElementById('bx-auto-pass');
            if (c !== null && p.getAttribute("type") == "text") {
                p.setAttribute('type', 'password');
                document.getElementById("eye").classList.remove("active");
            }
            
            var d = document.getElementById('bx-auth-reg-input');
            if (c !== null && d.getAttribute("type") == "text") {
                d.setAttribute('type', 'password');
                document.getElementById("eye_dop").classList.remove("active");
            }
            
    		$(".popup").each(function(index, el) {
    			if ($(el).data("cleaning_off") != true) {
    				$(el).find("input[type='text'], input[type='password'], textarea").val("");
    			}
    		});
    		
    		$("#product_single_rating").data("value", "");
    		$("#product_single_rating .star").removeClass("filed");
    		$("#product_single_rating_label").html($("#product_single_rating_label").data("label"));
    	});
    });
    
    $(document).ready(function() {
        
        if (event.target.className == "bx-btn-show-password"){
            var p = document.getElementById('bx-auto-pass');
            p.setAttribute('type', 'text');
            document.getElementById("eye").classList.add("active");
        } else if (event.target.className == "bx-btn-show-password active") {
            var p = document.getElementById('bx-auto-pass');
            p.setAttribute('type', 'password');
            document.getElementById("eye").classList.remove("active");
        };
        
        if (event.target.className == "bx-btn-show-reg-password"){
            var d = document.getElementById('bx-auth-reg-input');
            d.setAttribute('type', 'text');
            document.getElementById("eye_dop").classList.add("active");
        } else if (event.target.className == "bx-btn-show-reg-password active")  {
            var d = document.getElementById('bx-auth-reg-input');
            d.setAttribute('type', 'password');
            document.getElementById("eye_dop").classList.remove("active");
        }
        
        if (event.target.className == "bx-btn-show-reg-password-dop"){
            var c = document.getElementById('bx-auth-reg-input-dop');
            c.setAttribute('type', 'text');
            document.getElementById("eye_new_dop").classList.add("active");
        } else if (event.target.className == "bx-btn-show-reg-password-dop active")  {
            var c = document.getElementById('bx-auth-reg-input-dop');
            c.setAttribute('type', 'password');
            document.getElementById("eye_new_dop").classList.remove("active");
        }
        
        if (event.target.className == "input_popup_newsletter"){
            document.getElementById("input_popup_newsletter").classList.add("active");
        } else if (event.target.className == "input_popup_newsletter active"){
            document.getElementById("input_popup_newsletter").classList.remove("active");
        }
        
        if (event.target.className == "input_popup_politics"){
            document.getElementById("input_popup_politics").classList.add("active");
        } else if (event.target.className == "input_popup_politics active"){
            document.getElementById("input_popup_politics").classList.remove("active");
        }
    });
})

function popup_show_id(popup) {
	popup_close();
	
	$("#popup_wrapper").addClass("active");
	$("#popup_" + popup).addClass("active");
	$("#page").addClass("blured");
}

function popup_show(e) {
	popup_close();
	
	var popup = $(e).data("popup");
	
	$("body").addClass("hiddens");
	$("#popup_wrapper").addClass("active");
	$("#popup_" + popup).addClass("active");
	$("#page").addClass("blured");
}

function popup_show_recovery(e) {
	//popup_close();
	
	var popup = $(e).data("popup");
	
	$("body").addClass("hiddens");
	$("#popup_wrapper").addClass("active");
	$("#popup_recovery").addClass("active");
	$("#popup_auth").removeClass("active");
	$("#page").addClass("blured");
}

function popup_show_registration(e) {
	//popup_close();
	
	var popup = $(e).data("popup");
	
	$("body").addClass("hiddens");
	$("#popup_wrapper").addClass("active");
	$("#popup_registration").addClass("active");
	$("#popup_recovery").removeClass("active");
	$("#popup_auth").removeClass("active");
	$("#page").addClass("blured");
}

function popup_show_job_position(e) {
	popup_close();
	
	var popup = $(e).data("popup");
	
	if (popup == undefined){
	    popup = "infoAdministrator";
	}
	
	$("body").addClass("hiddens");
	$("#popup_wrapper").addClass("active");
	$("#popup_job_"+ popup).addClass("active");
	$("#page-body").addClass("blured");
}

function popup_close() {
	$("body").removeClass("hiddens");
	$("#popup_wrapper").removeClass("active");
	$(".popup").removeClass("active");
	$("#page").removeClass("blured");
	
	$(".popup").each(function(index, el) {
		if ($(el).data("cleaning_off") != true) {
			$(el).find("input[type='text'], input[type='password'], textarea").val("");
		}
	});
	
	$("#product_single_rating").data("value", "");
	$("#product_single_rating .star").removeClass("filed");
	$("#product_single_rating_label").html($("#product_single_rating_label").data("label"));
}
