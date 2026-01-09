document.addEventListener("DOMContentLoaded", () => {
    const quantityOutput = document.getElementById("quantity");
    const increaseBtn = document.getElementById("increase");
    const decreaseBtn = document.getElementById("decrease");
    const hiddenQuantity = document.getElementById("hidden-quantity");

    function updateQuantity(newValue) {
        quantityOutput.value = newValue;
        quantityOutput.textContent = newValue;
        hiddenQuantity.value = newValue;
    }

    increaseBtn.addEventListener("click", () => {
        updateQuantity(parseInt(quantityOutput.value) + 1);
    });

    decreaseBtn.addEventListener("click", () => {
        const current = parseInt(quantityOutput.value);
        if (current > 1) {
            updateQuantity(current - 1);
        }
    });

    const sugarInputs = document.querySelectorAll(
        `fieldset:nth-of-type(3) input[type="radio"]`
    );
    const sugarLabels = document.querySelectorAll(
        `fieldset:nth-of-type(3) label`
    );

    const sugarReset = document.getElementById("sugar-reset");


    sugarInputs.forEach(input => {
        input.addEventListener("change", () => {
            const selectedValue = parseInt(input.value);
            let showBtn = false;

            sugarLabels.forEach(label => {
                const labelValue = parseInt(label.dataset.value);

                if (labelValue <= selectedValue) {
                    label.setAttribute("data-active", "true");
                    showBtn = true;
                } else {
                    label.removeAttribute("data-active");
                }
            });

            sugarReset.style.display = showBtn ? "inline-block" : "none";
        });
    });


    sugarReset.addEventListener("click", function () {
        sugarInputs.forEach(input => (input.checked = false));
        sugarLabels.forEach(label => {
            label.removeAttribute("data-active");
        })
        sugarReset.style.display = "none";
    })

});
