const tableSalaries = document.getElementById("list-salaries");
document.addEventListener("DOMContentLoaded", function () {
    getData();
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
    // console.log(data);
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
