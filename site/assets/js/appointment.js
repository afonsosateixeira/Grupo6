document.addEventListener('DOMContentLoaded', function() {
    
    const animalTypeInputs = document.querySelectorAll('input[name="animal"]');
    const animalNameInput = document.getElementById('name_animal');
    const animalAgeInput = document.getElementById('age_animal');
    const breedAnimalInput = document.getElementById('breed_animal');
    const dateInput = document.querySelector('input[name="data_consulta"]');
    const timeInputs = document.querySelectorAll('input[name="horary"]');

    function updateSummary() {
        
        const selectedAnimal = document.querySelector('input[name="animal"]:checked');
        document.getElementById('resumo-animal-type').textContent = selectedAnimal ? selectedAnimal.value : '';
       
        document.getElementById('resumo-pet-name').textContent = animalNameInput.value || '';

        const ageValue = document.getElementById('age_animal').value;
        document.getElementById('resumo-pet-age').textContent = ageValue || '';

        const breedValue = document.getElementById('breed_animal').value;
        document.getElementById('resumo-breed').textContent = breedValue || '';

        document.getElementById('resumo-date').textContent = dateInput.value || '';

        const selectedTime = document.querySelector('input[name="horary"]:checked');
        document.getElementById('resumo-time').textContent = selectedTime ? selectedTime.value : '';
    }

    animalNameInput.addEventListener('input', updateSummary);
    animalAgeInput.addEventListener('input', updateSummary);
    dateInput.addEventListener('change', updateSummary);
    breedAnimalInput.addEventListener('input', updateSummary);

    animalTypeInputs.forEach(input => input.addEventListener('change', updateSummary));
    timeInputs.forEach(input => input.addEventListener('change', updateSummary));
});
