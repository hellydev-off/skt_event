// Элементы DOM
//const openBtn = document.getElementById('openFeedbackBtn');
const openBtns = document.querySelectorAll('[data-type="form-open"]');
const modal = document.getElementById('feedbackModal');
const closeBtn = document.getElementById('closeModalBtn');
const form = document.getElementById('feedbackForm');
const submitBtn = document.getElementById('submitBtn');
const successMessage = document.getElementById('successMessage');

// Поля формы
const nameInput = document.getElementById('name');
const phoneInput = document.getElementById('phone');
const emailInput = document.getElementById('email');

// Сообщения об ошибках
const nameError = document.getElementById('nameError');
const phoneError = document.getElementById('phoneError');
const emailError = document.getElementById('emailError');

// Открытие модального окна
/*openBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Блокируем прокрутку фона
});*/
openBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
});

// Закрытие модального окна
closeBtn.addEventListener('click', closeModal);

// Закрытие при клике вне формы
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// Функция закрытия модального окна
function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto'; // Возвращаем прокрутку
    resetForm();
}

// Валидация формы
// form.addEventListener('submit', (e) => {
//     e.preventDefault();

//     let isValid = false;

//     // Проверка ФИО
//     if (!nameInput.value.trim()) {
//         nameError.style.display = 'block';
//         isValid = false;
//     } else {
//         nameError.style.display = 'none';
//     }

//     // Проверка телефона
//     if (!phoneInput.value.trim()) {
//         phoneError.style.display = 'block';
//         isValid = false;
//     } else {
//         phoneError.style.display = 'none';
//     }

//     // Проверка email
//     if (!emailInput.value.trim()) {
//         emailError.style.display = 'block';
//         isValid = false;
//     } else {
//         emailError.style.display = 'none';
//     }

//     // Если форма валидна, показываем сообщение об успехе
//     if (isValid) {
//         successMessage.style.display = 'block';
//         submitBtn.disabled = true;

//         // Через 3 секунды закрываем форму
//         setTimeout(() => {
//             closeModal();
//         }, 3000);
//     }
// });

// Функция сброса формы
function resetForm() {
    //form.reset();
    nameError.style.display = 'none';
    phoneError.style.display = 'none';
    emailError.style.display = 'none';
    successMessage.style.display = 'none';
    submitBtn.disabled = false;
}

// Закрытие по нажатию Esc
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});