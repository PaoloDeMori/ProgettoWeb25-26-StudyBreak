document.addEventListener("DOMContentLoaded", () => {
    const deleteBtn = document.getElementById("delete-item-btn");

    deleteBtn.addEventListener("click", async () => {
        const urlParams = new URLSearchParams(window.location.search);
        const itemId = urlParams.get('id');

        if (!itemId) {
            alert("Error while trying to delete the item");
            return;}
        response = await fetch("../../api/deleteCustomItem.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    itemId: urlParams.get('id'),
                })
            });
        const result = await response.json();
        
        if(true){
            alert("Infuso succesfully deleted");
            window.location.href = 'favourites.php';
        }else{
            alert("Error while trying to delete the item");
        }
    });
});