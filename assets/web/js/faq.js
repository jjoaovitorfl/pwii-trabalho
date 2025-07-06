const questions = document.querySelectorAll('.faq-question');

questions.forEach(button => {
    button.addEventListener('click', () => {
        const answer = button.nextElementSibling;

        questions.forEach(btn => {
            if (btn !== button) {
                btn.nextElementSibling.classList.remove('active');
            }
        });

        answer.classList.toggle('active');
    });
});
