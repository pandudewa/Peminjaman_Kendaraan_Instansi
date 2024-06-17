document.addEventListener('DOMContentLoaded', function () {

    let deleteForms = document.querySelectorAll('form.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            if (confirm('Are you sure want to delete this data ?')) {
                this.submit();
            }
        });
    });

    let welcomeButton = document.getElementById('welcomeButton');
    if (welcomeButton) {
        welcomeButton.addEventListener('click', function () {
            alert('Welcome to Vehicle Monitoring Application !');
        });
    }

    let fetchDataButton = document.getElementById('fetchDataButton');
    if (fetchDataButton) {
        fetchDataButton.addEventListener('click', function () {
            fetch('/api/data')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data from server:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }

    let form = document.getElementById('myForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(this);

            if (formData.get('name') === '') {
                alert('Name must be filled !');
                return false;
            }
    
            this.submit();
        });
    }

});