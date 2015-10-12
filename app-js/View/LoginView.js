Notes.LoginView = function () {
    
    this.resetData = function () {
        console.log("in reset fun");
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
    };

    this.readUserData = function () {
        var id, firstName, lastName, createdOn, email, password;
        
        id = document.getElementById("id").value;
        firstName = document.getElementById("firstName").value;
        lastName = document.getElementById("lastName").value;
        createdOn = document.getElementById("createdOn").value;
        email = document.getElementById("email").value;
        password = document.getElementById("password").value;
        
        return {
            id: id,
            firstName: firstName,
            lastName: lastName,
            password: password,
            email: email,
            createdOn: createdOn
        };
    };

    this.setLoginClickedHandler = function (handler) {
        console.log("In onLoginClickedHandler...");       
    (function(self){
	var loginButton = document.getElementById("login");
    console.log("login Button==",loginButton);
        if(loginButton) {
            
                loginButton.addEventListener("click", function (e) {
                    handler(e, self);
                }, false);
        }
    })(this);
    };

    this.setResetClickedHandler = function (handler) {
        console.log("In onLogin Reset Clicked Handler..");
        (function(self){
                var resetButton = document.getElementById("reset");
                console.log("reset Button==",resetButton);
                if (resetButton) {
                    resetButton.addEventListener("click", function (e) {
                    console.log(e);
                    handler(e, self);
                }, false);
                }
        })(this);
    };

    this.hide = function () {
        document.getElementById("container").style.display = "none";
    };

    this.showError = function (response) {
        var errorMsg = response.data;
        document.getElementById("errorMessage").innerText = errorMsg;
    };

    this.create = function () {
        console.log("in showView function");
        
        var data = {"login": "Login Form"};
        var template = $("#hiddenLoginView").html();
        
        Mustache.parse(template);
        var rendered = Mustache.render(template, data);

        var view = new Notes.View();
        view.show(rendered);
    };
};
