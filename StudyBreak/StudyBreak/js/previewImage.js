document.addEventListener("DOMContentLoaded", () => {

    const inputPicture = document.getElementById("inputPicture");
    const previewImage = document.getElementById("previewImage");

    inputPicture.addEventListener("change", () => {
        const file = inputPicture.files[0];

        if (!file) return;

        if (!file.type.startsWith("image/")) {
            alert("Please select an image file");
            inputPicture.value = "";
            return;
        }

        previewImage.src = URL.createObjectURL(file);
    });

});
