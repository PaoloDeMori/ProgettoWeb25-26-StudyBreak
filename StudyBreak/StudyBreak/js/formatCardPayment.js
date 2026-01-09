document.addEventListener("DOMContentLoaded", () => {

    const cardNumber = document.getElementById("card-number");
    const expiryDate = document.getElementById("expiry-date");
    const cvc = document.getElementById("code");

    cardNumber.addEventListener("input", () => {
        let value = cardNumber.value.replace(/\D/g, '');
        value = value.substring(0, 16);
        cardNumber.value = value.replace(/(.{4})/g, '$1 ').trim();
    });

    expiryDate.addEventListener("input", () => {
        let value = expiryDate.value.replace(/\D/g, '');
        value = value.substring(0, 4);

        expiryDate.value =
            value.length >= 3
                ? value.substring(0, 2) + '/' + value.substring(2)
                : value;
    });

    cvc.addEventListener("input", () => {
        cvc.value = cvc.value.replace(/\D/g, '');
    });
});
