function plus(n,isCalculatingTotal){//Cette fonction ajoute un au nombre d'unite de cette article contenue dans le panier de l'utilisateur et retire un au nombre d'unite de cette article present en stock.
    //On recupere le nombre d'unite de cette article contenue dans le panier. 
    var x = Number( document.getElementById("basket"+n).value);
    //On recupere le nombre d'unite de cette article encore en stock.
    var stock = Number( document.getElementById("stockV"+n).value);

    //Si il reste au moins une unite de cette article en stock.
    if(stock > 0) {
        //1)---Cette partie est purement de l'affichage---//
            //L'affichage contenant le nombre d'unite de cet article deja dans le panier recoit plus un.
            document.getElementById("basket"+n).value = x + 1;
            //L'affichage cache contenant le nombre de  d'unite de cet article encore en stock recoit moins un.
            document.getElementById("stockV"+n).value = Number( document.getElementById("stockV"+n).value) - 1;
            //L'affichage contenant le prix de toute les unites de cette article cumule recoit le nouveau prix.
            document.getElementById("group"+n).value = document.getElementById("basket"+n).value*document.getElementById("price"+n).value;

            if(isCalculatingTotal){
                document.getElementById("basketTotal").value = Number(document.getElementById("basketTotal").value) + Number(document.getElementById("price"+n).value);
            }
        //------//
        //2)---AJAX, Cette modife le panier de l'utilisateur et les stocks du site---//
            //On recupere la reference du produit afin de pouvoir la transmettre la reference de l'article a l'operation suivante.
            var ref = document.getElementById("ref"+n).value;
            //On creer l'AJAX.
            var xhr = new XMLHttpRequest();
            //On verifie qu'il n'y a pas de probleme.                    
            xhr.onreadystatechange = function() {
                                    
                if(this.readyState == 4 && this.status == 200){
                    console.log(this.response);
                }
                else if(this.readyState == 4){
                    alert("error");
                }
            };  
            //On appelle la fonction php qui mettra a jour les donnee de stock est de panier.
            xhr.open("POST", "php/basketManagement/plus.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("ref="+ref);//On passe la reference de l'article en parametre.
        //------//
    }
}  

function minus(n,isCalculatingTotal){//Cette fonction retire un au nombre d'unite de cette article contenue dans le panier de l'utilisateur et ajoute un au nombre d'unite de cette article present en stock.
    //On recupere le nombre d'unite de cette article contenue dans le panier. 
    var x = Number( document.getElementById("basket"+n).value);

    //Si il reste au moins une unite de cette article dans le panier.
    if(x > 0) {
        //1)---Cette partie est purement de l'affichage---//
            //L'affichage contenant le nombre de produits deja dans le panier recoit moins un.
            document.getElementById("basket"+n).value =  x - 1;
            //L'affichage cache contenant le nombre de produits encore en stock recoit plus un.       
            document.getElementById("stockV"+n).value = Number( document.getElementById("stockV"+n).value) + 1;
            //L'affichage contenant le prix de toute les unites de cette article cumule recoit le nouveau prix.
            document.getElementById("group"+n).value = document.getElementById("basket"+n).value*document.getElementById("price"+n).value;

            if(isCalculatingTotal){
                document.getElementById("basketTotal").value = Number(document.getElementById("basketTotal").value) - Number(document.getElementById("price"+n).value);
            }
        //------//
        //2)---AJAX, Cette modife le panier de l'utilisateur et les stocks du site---//
            //On recupere la reference du produit afin de pouvoir la transmettre la reference de l'article a l'operation suivante.
            ref = document.getElementById("ref"+n).value;
            //On creer l'AJAX.
            var xhr = new XMLHttpRequest();
            //On verifie qu'il n'y a pas de probleme.                   
            xhr.onreadystatechange = function() {
                                    
                if(this.readyState == 4 && this.status == 200){
                    console.log(this.response);
                }
                else if(this.readyState == 4){
                    alert("error");
                }
            };
            //On appelle la fonction php qui mettra a jour les donnee de stock est de panier.                    
            xhr.open("POST", "php/basketManagement/minus.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("ref="+ref);//On passe la reference de l'article en parametre.
        //------//
    }
}   

function deleteElement(n,isCalculatingTotal){//Cette fonction retire l'article de l'affichage et remet les unitees de l'article retire dans les stocks 
    //On recupere le nombre d'unite de cette article contenue dans le panier. 
    var x = Number(document.getElementById("basket"+n).value);
    
    //L'element retire est retire du visuel.
    document.getElementById("element"+n).style.display = 'none';

    //On retire l'element du prix total
    if(isCalculatingTotal){
        document.getElementById("basketTotal").value = Number(document.getElementById("basketTotal").value) - Number(document.getElementById("group"+n).value);
    }

    //---AJAX---//
    //On recupere la reference du produit afin de pouvoir la transmettre la reference de l'article a l'operation suivante.
    ref = document.getElementById("ref"+n).value;
    //On creer l'AJAX.
    var xhr = new XMLHttpRequest();
    //On verifie qu'il n'y a pas de probleme.                         
    xhr.onreadystatechange = function() {                              
        if(this.readyState == 4 && this.status == 200){
            console.log(this.response);
        }
        else if(this.readyState == 4){
            alert("error");
        }
    };
    //On appelle la fonction php qui mettra a jour les donnee de stock est de panier.                         
    xhr.open("POST", "php/basketManagement/delete.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("ref="+ ref + "&number=" + x);//On passe la reference de l'article et le nombre d'unite de l'article encore present dans le panier parametre.
    //------//
}