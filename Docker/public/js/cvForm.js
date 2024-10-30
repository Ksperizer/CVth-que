function addEducation() {
    console.log("Adding education entry");  // Debug line
    const educationSection = document.getElementById('educationSection');
    const entry = document.createElement('div');
    entry.classList.add('education-entry');
    entry.innerHTML = `
        <label for="degree">Diplôme :</label>
        <input type="text" name="degree[]" required>
        
        <label for="institution">Institution :</label>
        <input type="text" name="institution[]" required>
        
        <label for="year">Année :</label>
        <input type="text" name="year[]" required>
    `;
    educationSection.appendChild(entry);
}

function addExperience() {
    console.log("Adding experience entry");  // Debug line
    const experienceSection = document.getElementById('experienceSection');
    const entry = document.createElement('div');
    entry.classList.add('experience-entry');
    entry.innerHTML = `
        <label for="jobTitle">Titre du poste :</label>
        <input type="text" name="jobTitle[]" required>
        
        <label for="company">Entreprise :</label>
        <input type="text" name="company[]" required>
        
        <label for="jobYear">Année :</label>
        <input type="text" name="jobYear[]" required>
    `;
    experienceSection.appendChild(entry);
}
