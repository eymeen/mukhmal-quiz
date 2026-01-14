// Dark mode toggle
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    
    // Check if dark mode was previously enabled
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
        darkModeToggle.textContent = '☀️ Light Mode';
    }
    
    // Toggle dark mode
    darkModeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        
        if (document.body.classList.contains('dark-mode')) {
            darkModeToggle.textContent = '☀️ Light Mode';
            localStorage.setItem('darkMode', 'enabled');
        } else {
            darkModeToggle.textContent = '🌙 Dark Mode';
            localStorage.setItem('darkMode', 'disabled');
        }
    });
    
    // Smooth scrolling for form
    const form = document.getElementById('quizForm');
    if (form) {
        const radioButtons = form.querySelectorAll('input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                // Small delay for smooth transition
                setTimeout(() => {
                    const currentCard = this.closest('.question-card');
                    const nextCard = currentCard.nextElementSibling;
                    if (nextCard && nextCard.classList.contains('question-card')) {
                        nextCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 300);
            });
        });
    }
});

