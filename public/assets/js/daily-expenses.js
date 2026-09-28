const date = document.getElementById("date");
const tableDaily = document.getElementById("list-daily-expenses");
document.addEventListener("DOMContentLoaded", function () {
    getDataDaily(date.value);

    const priceInput = document.getElementById("price");
    const totalPrice = document.getElementById("total-price");
    const qtyInput = document.getElementById("qty");

    priceInput.addEventListener("input", function () {
        const value = this.value.replace(/\D/g, "");
        qtyInput.value = 1;
        this.value = value ? formatRupiah(value) : "";
        calculateTotal();
    });

    qtyInput.addEventListener("input", function () {
        calculateTotal();
    });
    function formatRupiah(value) {
        value = String(value).replace(/\D/g, "");

        if (!value) {
            return "";
        }

        return "Rp " + new Intl.NumberFormat("id-ID").format(Number(value));
    }
    function calculateTotal() {
        const price = Number(priceInput.value.replace(/\D/g, "") || 0);

        const qty = Number(qtyInput.value) || 0;

        const total = price * qty;
        totalPrice.value = total > 0 ? formatRupiah(total) : "";
    }

    document.getElementById("btn-save").addEventListener("click", function () {
        const form = document.getElementById("daily-cost");
        const purchaseId = document.getElementById("purchase-id").value;
        const formData = new FormData(form);
        let url = `daily-expenses/store`;
        if (purchaseId != null && purchaseId != "" && purchaseId != 0) {
            url = `daily-expenses/update`;
        }
        console.log(url);

        fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"')
                    .content,
                Accept: "application/json",
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                getDataDaily(date.value);
                resetForm();
            })
            .catch((error) => {
                // console.error(error);
            });
    });

    document.addEventListener("click", function (e) {
        const button = e.target.closest(".btn-delete");

        if (!button) return;

        const id = button.dataset.id;

        fetch(`daily-expenses/delete/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);

                getDataDaily(date.value);
            })
            .catch((error) => {
                console.error(error);
            });
    });

    document.addEventListener("click", function (e) {
        const button = e.target.closest(".btn-edit");
        if (!button) return;

        document.getElementById("purchase-id").value =
            button.dataset.purchase_id;
        document.getElementById("date").value = button.dataset.date;
        document.getElementById("name").value = button.dataset.name;
        document.getElementById("price").value = button.dataset.price;
        document.getElementById("qty").value = button.dataset.amount;
        document.getElementById("salary-id").value = button.dataset.salary_id;

        const categoryChoices =
            document.getElementById("category-id").choicesInstance;
        categoryChoices.removeActiveItems();
        categoryChoices.setChoiceByValue(String(button.dataset.category_id));
        document.getElementById("total-price").value =
            button.dataset.total_price;
    });
});

date.addEventListener("change", function () {
    getDataDaily(date.value);
});

async function getDataDaily(date) {
    try {
        const response = await fetch(
            `daily-expenses/get-data-daily?date=${date}`,
        );

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        loadDataDaily(data.list);
        loadSummary(data);
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

function loadDataDaily(data) {
    tableDaily.innerHTML = "";

    data.data.forEach((item, index) => {
        tableDaily.insertAdjacentHTML(
            "beforeend",
            `
        <tr>
            <td>${index + 1}</td>
            <td>${item.name}</td>
            <td>${item.amount}</td>
            <td>${item.price_format}</td>
            <td>${item.name_category}</td>
            <td>${item.total_price_format}</td>
            <td>
            <button class="btn btn-sm btn-warning btn-edit" data-name="${item.name}"
            data-amount="${item.amount}" data-price="${item.price_format}" data-total_price="${item.total_price_format}"
            data-category_id="${item.category_id}" data-date="${item.date}" data-salary_id="${item.salary_id}"
            data-purchase_id="${item.id}">
            <i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    `,
        );
    });
}

function loadSummary(data) {
    document.getElementById("this-day").textContent = data.cost_day ?? "Rp 0";
    document.getElementById("this-month").textContent =
        data.cost_month ?? "Rp 0";
    document.getElementById("this-year").textContent = data.cost_year ?? "Rp 0";
    document.getElementById("remaining-salary").textContent =
        data.remaining_salary ?? "Rp 0";
    document.getElementById("salary-name").textContent =
        data.salary_name ?? "Rp 0";
}

function formatRupiah(value) {
    return new Intl.NumberFormat("id-ID").format(value);
}

function resetForm() {
    document.getElementById("name").value = "";
    document.getElementById("purchase-id").value = "";
    document.getElementById("price").value = "";
    document.getElementById("total-price").value = "";
    document.getElementById("qty").value = "";
    document.getElementById("salary-id").selectedIndex = 0;
    // Akses langsung dari elemen DOM lalu panggil fungsinya
    document.getElementById("category-id").choices.setChoiceByValue("");
}
