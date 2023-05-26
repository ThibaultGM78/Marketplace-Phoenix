function validateForm() {
    var name = document.getElementById("name").value;
    var desc = document.getElementById("desc").value;
    var price = document.getElementById("price").value;
    var stock = document.getElementById("stock").value;
    var img = document.getElementById("img").value;
    var category = document.getElementById("category").value;

    if (name == "" || desc == "" || price == "" || stock == "" || img == "" || category == "") {
    alert("Veuillez remplir tous les champs");
    return false;
    }

    if (isNaN(price) || isNaN(stock)) {
    alert("Le prix et le stock doivent être des nombres");
    return false;
    }

    return true;
}