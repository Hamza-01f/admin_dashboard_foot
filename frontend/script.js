const body = document.querySelector("body"),
      modeToggle = body.querySelector(".mode-toggle");
      sidebar = body.querySelector("nav");
      sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark");
    }else{
        localStorage.setItem("mode", "light");
    }
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
    }else{
        localStorage.setItem("status", "open");
    }
})
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-player');
    const positionSelect = document.getElementById('position');
    const fieldStats = document.getElementById('field-stats');
    const gkStats = document.getElementById('gk-stats');

    positionSelect.addEventListener('change', function () {
        const position = positionSelect.value;
        updateInputValidation(position);
    });

    form.addEventListener('submit', function (event) {
        let isValid = true;

        // Validate only the input fields relevant to the chosen position
        form.querySelectorAll('input').forEach(function (input) {
            if (isFieldRelevantToPosition(input, positionSelect.value)) {
                if (!isValidInput(input)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            }
        });

        // If the form is not valid, prevent submission
        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Display success message or perform form submission logic
        }
    });

    function updateInputValidation(position) {
        if (position === 'GK') {
            gkStats.style.display = 'block';
            fieldStats.style.display = 'none';
        } else {
            fieldStats.style.display = 'block';
            gkStats.style.display = 'none';
        }
    }

    function isFieldRelevantToPosition(input, position) {
        // Logic to determine if the input field is relevant to the chosen position
        if (position === 'GK') {
            return input.id === 'diving' || input.id === 'handling' || input.id === 'kicking' || input.id === 'reflexes';
        } else {
            return input.id === 'pace' || input.id === 'shooting' || input.id === 'passing' || input.id === 'dribbling';
        }
    }

    function isValidInput(input) {
        // Custom validation logic for relevant input fields
        if (input.type === 'text' || input.type === 'number') {
            return input.value.trim() !== '';
        }
        return true;
    }
});


