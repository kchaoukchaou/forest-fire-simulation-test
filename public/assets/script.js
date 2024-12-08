document.addEventListener("DOMContentLoaded", () => {
    const nextStepButton = document.getElementById("nextStep");
    const resetButton = document.getElementById("reset");

    nextStepButton.addEventListener("click", () => {
        fetch("nextStep.php", { method: "POST" })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateGrid(data.grid);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Erreur lors de la requête :", error));
    });

    resetButton.addEventListener("click", () => {
        fetch("reset.php", { method: "POST" })
            .then(() => location.reload())
            .catch(error => console.error("Erreur lors de la réinitialisation :", error));
    });

    function updateGrid(grid) {
        const table = document.querySelector("#grid table");
        table.innerHTML = "";

        grid.forEach(row => {
            const tr = document.createElement("tr");
            row.forEach(cell => {
                const td = document.createElement("td");
                td.className = cell;
                tr.appendChild(td);
            });
            table.appendChild(tr);
        });
    }
});