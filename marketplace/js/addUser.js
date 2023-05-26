function showCompagnyField() {
    var role = document.getElementById("role").value;
    if (role === "compagny") {
        document.getElementById("compagnyField").style.display = "block";
    } else {
        document.getElementById("compagnyField").style.display = "none";
    }
    
}

function validateForm(){//Cette fonction verifie que les informations donne par l'utilisateur pour la creation de son compte son correct.
    
    var validate = true; 
    
    /*Login*/
    //On verifie que le champ n'est pas vide.
    if(document.getElementById("login").value == ""){//sinon on affiche un message d'erreur.
        document.getElementById("login").className="error";//Le champ devient rouge.
        document.getElementById("errorLogin").className = "";//On affiche les attendues de la case qui etait auparavant cache.
        validate = false;//indique qu'il y a eu une erreur.
    }
    else{//sioui
        document.getElementById("login").className="form-control";//Le champ redevient normal.
        document.getElementById("errorLogin").className = "d-none";//On cache les attendues de la case qui etait auparavant affiche.
    }
    /*Password*/
    //On verifie que le champ n'est pas vide.
    if(document.getElementById("password").value == ""){
        document.getElementById("password").className="error";
        document.getElementById("errorPassword").className = "";
        validate = false;
    }
    else{
        document.getElementById("password").className="form-control";
        document.getElementById("errorPassword").className = "d-none";
    }  
     /*VerifPassword*/
    //On verifie qu'est les deux mot passes soit les memes.
    if(document.getElementById("password2").value != document.getElementById("password").value){
        document.getElementById("password2").className="error";
        document.getElementById("errorPassword2").className = "";
        validate = false;
    }
    else{
        document.getElementById("password2").className="form-control";
        document.getElementById("errorPassword2").className = "d-none";
    }
    /*Email*/
    //On verifie le format mail. Soit un nom, un "@"", une plateforme, un "." et une direction.
    if(document.getElementById("email").value.match(/[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i) == null){
        document.getElementById("email").className="error";
        document.getElementById("errorEmail").className = "";
        validate = false;
    }
    else{
        document.getElementById("email").className="form-control";
        document.getElementById("errorEmail").className = "d-none";
    }
    /*Role*/
    //On verifie qu'une des 3 fonctions a ete coche.
    if(document.getElementById("role").value != "customer" && document.getElementById("fonction").value != "compagny"){
        document.getElementById("role").className="error";
        document.getElementById("errorRole").className = "";
        validate = false;
    }
    else{
        document.getElementById("role").className="form-control";
        document.getElementById("errorRole").className ="d-none";
    }

   /*validate*/
   //Si validate = false le formulaire sera a corrige et ne passera pas a l'etape suivante.
   return validate;
}