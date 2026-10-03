const month = document.getElementById("month");
const year = document.getElementById("year");
const startDate = document.getElementById("start_date");
const endDate = document.getElementById("end_date");

document.addEventListener("DOMContentLoaded", function () {
    getExpensesData(month.value, year.value);
    getExpensesGroupCategory(month.value, year.value);
    getExpensesDataByDate(startDate.value, endDate.value);
});

[month, year].forEach((element) => {
    element.addEventListener("change", function () {
        console.log("CHANGE:", element.id, element.value);
        getExpensesData(month.value, year.value);
        getExpensesGroupCategory(month.value, year.value);
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
        // loadCard(data.data);
        renderChartMonthlyCost(data.data);
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

async function getExpensesGroupCategory(month, year) {
    try {
        const response = await fetch(
            `dashboard/get-expenses-group-category?month=${month}&year=${year}`,
        );

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        renderChartMonthlyCategory(data.data);
        renderChartSalaryAndRemaining(data.salaryAndRemaining);
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

let monthlyCostChart = null;
function renderChartMonthlyCost(data) {
    console.log(data);

    const categories = data.map((item) => item.week);
    const values = data.map((item) => Number(item.total_amount) || 0);

    if (monthlyCostChart) {
        monthlyCostChart.destroy();
    }

    const options = {
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },
        series: [
            {
                name: "Nominal",
                data: values,
            },
        ],
        xaxis: {
            categories: categories,
        },

        yaxis: {
            labels: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
    };
    monthlyCostChart = new ApexCharts(
        document.querySelector("#chart-monthly-cost"),
        options,
    );

    monthlyCostChart.render();
}

let monthlyCategoryChart = null;
function renderChartMonthlyCategory(data) {
    console.log(data);

    const categories = data.map((item) => item.name_category);
    const values = data.map((item) => Number(item.total_amount) || 0);

    if (monthlyCategoryChart) {
        monthlyCategoryChart.destroy();
    }

    const options = {
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },
        series: [
            {
                name: "Nominal",
                data: values,
            },
        ],
        xaxis: {
            categories: categories,
        },

        yaxis: {
            labels: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
    };
    monthlyCategoryChart = new ApexCharts(
        document.querySelector("#chart-monthly-category"),
        options,
    );

    monthlyCategoryChart.render();
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
        renderChartDailyCost(data.data);
        // loadCardDate(data.data);
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}
let dailyCostChart = null;
function renderChartDailyCost(data) {
    const categories = data.map((item) => item.date);
    const values = data.map(
        (item) => Number(item.total_amount_not_format) || 0,
    );

    if (dailyCostChart) {
        dailyCostChart.destroy();
    }

    const options = {
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },
        series: [
            {
                name: "Nominal",
                data: values,
            },
        ],
        xaxis: {
            categories: categories,
        },

        yaxis: {
            labels: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
    };
    dailyCostChart = new ApexCharts(
        document.querySelector("#chart-daily-cost"),
        options,
    );

    dailyCostChart.render();
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

let salaryAndRemaining = null;

function renderChartSalaryAndRemaining(data) {
    console.log(data);

    const categories = data.map((item) => item.name_month);

    const salaryValues = data.map((item) => Number(item.salary_amount) || 0);

    const remainingValues = data.map(
        (item) => Number(item.remaining_amount) || 0,
    );

    if (salaryAndRemaining) {
        salaryAndRemaining.destroy();
    }

    const options = {
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },

        series: [
            {
                name: "Salary",
                data: salaryValues,
            },
            {
                name: "Remaining",
                data: remainingValues,
            },
        ],

        xaxis: {
            categories: categories,
        },

        yaxis: {
            labels: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },

        tooltip: {
            y: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString("id-ID");
                },
            },
        },

        dataLabels: {
            enabled: false,
        },

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "55%",
            },
        },
    };

    salaryAndRemaining = new ApexCharts(
        document.querySelector("#chart-salary-and-remaining"),
        options,
    );

    salaryAndRemaining.render();
}
