const date = document.getElementById("date");
const tableDaily = document.getElementById("list-daily-expenses");
document.addEventListener("DOMContentLoaded", function () {
    getDataDaily(date.value);
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
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

function loadDataDaily(data) {
    console.log(data);

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
            <td><button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button></td>
        </tr>
    `,
        );
    });
}
