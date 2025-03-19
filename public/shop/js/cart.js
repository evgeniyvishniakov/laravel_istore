

// Удаление товара
document.addEventListener("DOMContentLoaded", function () {
    let csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error("CSRF-токен не найден!");
        return;
    }

    // Обработка нажатия на кнопки удаления
    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.dataset.id;

            fetch("/cart/remove", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken.getAttribute("content")
                },
                body: JSON.stringify({ product_id: productId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Удаляем товар из DOM
                        this.closest('tr').remove();
                        // Обновляем итоговую цену
                        document.getElementById("total-price").innerText = data.totalPrice + " грн";
                    }
                })
                .catch(error => console.error("Ошибка:", error));
        });
    });
});


// Изменение количества
document.addEventListener("DOMContentLoaded", function () {
    console.log('JavaScript работает!');

    let csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error("CSRF-токен не найден!");
        return;
    }

    // Проверка, есть ли элементы на странице
    console.log(document.querySelectorAll(".increase"));
    console.log(document.querySelectorAll(".decrease"));

    document.querySelectorAll(".increase, .decrease").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.dataset.id;
            let action = this.classList.contains("increase") ? "increase" : "decrease";
            console.log("Sending POST request to /cart/update with product_id:", productId, "and action:", action);
            fetch("http://127.0.0.1:8000/cart/update", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken.getAttribute("content")
                },
                body: JSON.stringify({ product_id: productId, action: action })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.quantity[data-id='${productId}']`).innerText = data.newQuantity;
                        document.getElementById("total-price").innerText = data.totalPrice + " грн";
                    }
                })
                .catch(error => console.error("Ошибка:", error));
        });
    });
});
