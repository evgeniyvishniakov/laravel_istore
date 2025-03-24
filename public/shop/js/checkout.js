

$.ajax({
    url: "/get-cities",
    type: "GET",
    success: function (response) {
        let cities = response.result; // JSON с API
        let select = $("#city");

        select.empty();
        $.each(cities, function (index, city) {
            select.append(`<option value="${city.Ref}">${city.Description}</option>`);
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const citySelect = document.querySelector(".delivered select");
    const warehouseSelect = document.getElementById("warehouse");

    citySelect.addEventListener("change", function () {
        const cityRef = this.value;

        if (!cityRef) {
            warehouseSelect.innerHTML = "<option value=''>Выберите отделение</option>";
            return;
        }

        fetch("/warehouses?city_ref=" + cityRef, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ city_ref: cityRef })
        })
            .then(response => response.json())
            .then(data => {
                warehouseSelect.innerHTML = "";

                if (data.success && Array.isArray(data.result)) {
                    data.result.forEach(warehouse => {
                        const option = document.createElement("option");
                        option.value = warehouse.Ref;
                        option.textContent = warehouse.Description;
                        warehouseSelect.appendChild(option);
                    });
                } else {
                    warehouseSelect.innerHTML = "<option value=''>Нет доступных отделений</option>";
                }
            })
            .catch(error => {
                console.error("Ошибка при загрузке отделений:", error);
                warehouseSelect.innerHTML = "<option value=''>Ошибка загрузки</option>";
            });
    });
});
