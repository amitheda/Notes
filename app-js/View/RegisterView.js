Notes.RegisterView = function () {
	
	this.create = function () {
        console.log("in showView function");

        var data = {title: "User Registration",test: "Registation Form"};
        var template = $("#hiddenRegisterView").html();
        
        Mustache.parse(template);
        var rendered = Mustache.render(template, data);
        
        var view = new Notes.View();
        view.show(rendered);
    };

	this.resetData = function () {
		console.log("in Register reset fun");
		
		document.getElementById("firstName").value = "";
        document.getElementById("lastName").value = "";
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
	};

	this.readUserData = function () {
        var firstName, lastName, email, password;
        
        firstName = document.getElementById("firstName").value;
        lastName = document.getElementById("lastName").value;
        email = document.getElementById("email").value;
        password = document.getElementById("password").value;
        
        return {
            firstName: firstName,
            lastName: lastName,
            email: email,
            password: password,
        };
    };

	this.setResetClickedHandler = function (handler) {
		console.log("in Register Reset Clicked Handler");

		(function(self){
		var resetButton = document.getElementById("clear");
		console.log(resetButton);
	        if(resetButton) {
	        	resetButton.addEventListener("click", function (e) {
	            handler(e,self);
	            }, false);
	        }
	    })(this);
	};

	this.setRegisterClickedHandler = function (handler) {
		console.log("in Register Clicked Handler");
		
		(function(self){
		var registerButton = document.getElementById("register");
		console.log(registerButton);
	        if(registerButton) {
	        	registerButton.addEventListener("click", function (e) {
	            handler(e,self);
	            }, false);
	        }
	    })(this);
	};

	this.showError = function (response) {
        var errorMessage = response.data;

        document.getElementById("error").innerText = "Error: ";
        document.getElementById("errormsg").innerText = errorMessage;
    };
};