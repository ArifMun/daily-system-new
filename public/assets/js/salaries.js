const tableSalaries = document.getElementById("list-salaries");
document.addEventListener("DOMContentLoaded", function () {
    getData();

    document.getElementById("btn-save").addEventListener("click", function () {
        const form = document.getElementById("salary-earning");
        const salaryId = document.getElementById("salary-id");
        const formData = new FormData(form);

        let url = `salaries/store`;
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
                // resetForm();
            })
            .catch((error) => {
                console.error("ERROR:", error);
            });
    });
});

async function getData() {
    try {
        const response = await fetch(`salaries/get-data`);

        if (!response.ok) {
            throw new Error(`HTTP error:${response.status}`);
        }

        const data = await response.json();
        loadDataSalaries(data.list);
    } catch (error) {
        console.log(error);
    }
}

function loadDataSalaries(data) {
    tableSalaries.innerHTML = "";

    data.forEach((item, index) => {
        tableSalaries.insertAdjacentHTML(
            "beforeend",
            `<tr>
                <td>${index + 1}</td>
                <td>${item.name_month}</td>
                <td>${item.salary_amount}</td>
                <td>${item.date_salary_payment}</td>
                <td>${item.fund_type}</td>
            </tr>`,
        );
    });
}
