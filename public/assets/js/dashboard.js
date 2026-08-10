const month = document.getElementById("month");
const year = document.getElementById("year");
const startDate = document.getElementById("start_date");
const endDate = document.getElementById("end_date");

document.addEventListener("DOMContentLoaded", function () {
    getExpensesData(month.value, year.value);
    getExpensesDataByDate(startDate.value, endDate.value);
});

[month, year].forEach((element) => {
    element.addEventListener("change", function () {
        console.log("CHANGE:", element.id, element.value);
        getExpensesData(month.value, year.value);
    });
});

[startDate, endDate].forEach((element) => {
    element.addEventListener("change", function () {
        getExpensesDataByDate(startDate.value, endDate.value);
    });
});

async function getExpensesData(month, year) {
    try {
        const response = await fetch(
            `dashboard/get-expenses-per-week?month=${month}&year=${year}`,
        );

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        loadCard(data.data);
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

function loadCard(data) {
    const container = document.getElementById("weekly-expenses");
    container.innerHTML = "";

    Object.entries(data).forEach(([week, total]) => {
        container.insertAdjacentHTML(
            "beforeend",
            ` <div class="col-6 col-lg-3 col-md-6 amount-week">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">
                                            ${week}
                                        </h6>
                                        <h6 class="font-extrabold mb-0">${total}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`,
        );
    });
}

async function getExpensesDataByDate(startDate, endDate) {
    try {
        const response = await fetch(
            `dashboard/get-expenses-by-date?start_date=${startDate}&end_date=${endDate}`,
        );

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        loadCardDate(data.data);
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

function loadCardDate(data) {
    const container = document.getElementById("daily-expenses");

    container.innerHTML = "";

    data.forEach((item) => {
        container.insertAdjacentHTML(
            "beforeend",
            `
            <div class="col-6 col-lg-3 col-md-6 amount-daily">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">
                                    ${item.date}
                                </h6>
                                <h6 class="font-extrabold mb-0">
                                    ${item.total_amount}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `,
        );
    });
}
