document.addEventListener('click', function (e) {

    /* ============================= */
    /* CATEGORY TOGGLE */
    /* ============================= */
    const categoryTitle = e.target.closest('.faq-category-title');

    if (categoryTitle) {

        const categoryGroup = categoryTitle.closest('.faq-category-group');

        // Close all categories first
        document.querySelectorAll('.faq-category-group').forEach(group => {
            if (group !== categoryGroup) {
                group.classList.remove('active');
            }
        });

        // Toggle clicked category
        categoryGroup.classList.toggle('active');

        return;
    }

    /* ============================= */
    /* FAQ QUESTION TOGGLE */
    /* ============================= */
    const question = e.target.closest('.faq-question');

    if (!question) return;

    const id = question.getAttribute('data-id');
    const answer = document.getElementById('faq-answer-' + id);
    const parentItem = question.closest('.faq-item');

    parentItem.classList.toggle('active');
    answer.classList.toggle('active');

});
