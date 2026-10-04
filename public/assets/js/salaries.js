const tableSalaries = document.getElementById("list-salaries");
document.addEventListener("DOMContentLoaded", function () {
    const year = document.getElementById("year").value;
    getData(year);

    const salaryAmount = document.getElementById("salary-amount");

    salaryAmount.addEventListener("input", function () {
        const value = this.value.replace(/\D/g, "");
        this.value = value ? formatRupiah(value) : "";
    });

    document.getElementById("btn-save").addEventListener("click", function () {
        const form = document.getElementById("salary-earning");
        const salaryId = document.getElementById("salary-id").value;
        const formData = new FormData(form);

        let url = `salaries/store`;
        if (salaryId != null && salaryId != "" && salaryId != 0) {
            url = `salaries/update`;
        }
        console.log(url);

        fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                getData();
                resetForm();
            })
            .catch((error) => {
                // console.error("ERROR:", error);
            });
    });

    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;
        console.log(btn.dataset.date_salary_payment);

        document.getElementById("salary-id").value = btn.dataset.salary_id;
        document.getElementById("date-salary-payment").value =
            btn.dataset.date_salary_payment;
        document.getElementById("name-month").value = btn.dataset.name_month;
        document.getElementById("salary-amount").value =
            btn.dataset.salary_amount;
        document.getElementById("fund-type").value = btn.dataset.fund_type;
    });

    document.addEventListener("change", function (e) {
        const select = e.target.closest("#year");
        if (select) {
            getData(select.value);
        }
    });
});

async function getData(year) {
    try {
        const response = await fetch(`salaries/get-data?year=${year}`);

        if (!response.ok) {
            throw new Error(`HTTP error:${response.status}`);
        }

        const data = await response.json();
        loadDataSalaries(data.list);
        document.getElementById("total-salary-amount").textContent =
            data.total_salary_amount;
        document.getElementById("total-salary-remaining").textContent =
            data.total_salary_remaining;
    } catch (error) {
        console.log(error);
    }
}

function loadDataSalaries(data) {
    tableSalaries.innerHTML = "";
    const fundTypeLabel = {
        sales_income: "Penjualan",
        salary: "Gaji",
        purchase: "Pembelian",
        expense: "Pengeluaran",
    };
    data.forEach((item, index) => {
        const fundType = fundTypeLabel[item.fund_type] ?? item.fund_type;

        tableSalaries.insertAdjacentHTML(
            "beforeend",
            `<tr>
                <td>${index + 1}</td>
                <td>${item.name_month}</td>
                <td style="white-space:nowrap">${item.salary_amount}</td>
                <td>${item.salary_remaining}</td>
                <td style="white-space:nowrap">${item.date_salary_payment}</td>
                <td>${fundType}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-name_month="${item.name_month}"
                    data-salary_amount="${item.salary_amount}"
                    data-date_salary_payment="${item.date_salary_payment_ori}"
                    data-fund_type="${item.fund_type}" data-salary_id="${item.id}">
                    <i class="bi bi-pencil"></i></button>
                </td>
            </tr>`,
        );
    });
}

function resetForm() {
    document.getElementById("salary-id").value = "";
    // document.getElementById("date-salary-payment").value = "";
    document.getElementById("name-month").value = "";
    document.getElementById("salary-amount").value = "";
    document.getElementById("fund-type").value = "";
}

function formatRupiah(value) {
    value = String(value).replace(/\D/g, "");

    if (!value) {
        return "";
    }

    return "Rp " + new Intl.NumberFormat("id-ID").format(Number(value));
}
